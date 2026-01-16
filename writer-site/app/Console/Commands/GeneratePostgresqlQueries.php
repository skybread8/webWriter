<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GeneratePostgresqlQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:generate-postgresql-queries 
                            {--sqlite-path= : Path to SQLite database file}
                            {--output= : Output file path (default: postgresql_migration.sql)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PostgreSQL INSERT queries from SQLite database';

    /**
     * Tables to migrate in order (respecting foreign key constraints)
     */
    protected $tables = [
        'users',
        'site_settings',
        'pages',
        'books',
        'testimonials',
        'blog_posts',
        'orders',
        'order_items',
        'reviews',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sqlitePath = $this->option('sqlite-path') 
            ?: database_path('database.sqlite');

        if (!file_exists($sqlitePath)) {
            $this->error("SQLite database not found at: {$sqlitePath}");
            return 1;
        }

        $outputPath = $this->option('output') ?: base_path('postgresql_migration.sql');

        $this->info("Generating PostgreSQL INSERT queries from SQLite...");
        $this->info("SQLite path: {$sqlitePath}");
        $this->info("Output file: {$outputPath}");

        // Configurar conexión temporal a SQLite
        $sqlitePath = realpath($sqlitePath);
        
        config(['database.connections.sqlite_source' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]]);

        try {
            // Verificar SQLite
            $this->info("Checking SQLite connection...");
            DB::connection('sqlite_source')->getPdo();
            $this->info("✓ SQLite connection OK");

            // Abrir archivo de salida
            $file = fopen($outputPath, 'w');
            if (!$file) {
                $this->error("Cannot create output file: {$outputPath}");
                return 1;
            }

            // Escribir encabezado
            fwrite($file, "-- PostgreSQL Migration Script\n");
            fwrite($file, "-- Generated from SQLite database\n");
            fwrite($file, "-- Date: " . date('Y-m-d H:i:s') . "\n\n");
            fwrite($file, "BEGIN;\n\n");

            // Generar queries para cada tabla
            foreach ($this->tables as $table) {
                $this->generateTableQueries($table, $file);
            }

            fwrite($file, "\nCOMMIT;\n");
            fclose($file);

            $this->info("\n✅ SQL file generated successfully!");
            $this->info("File: {$outputPath}");
            $this->info("\nTo execute, run:");
            $this->info("psql -h your-host -U your-user -d your-database -f {$outputPath}");

            return 0;
        } catch (\Exception $e) {
            $this->error("Generation failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Generate INSERT queries for a table
     */
    protected function generateTableQueries(string $table, $file)
    {
        $this->info("\n=== Generating queries for: {$table} ===");

        // Verificar si la tabla existe en SQLite
        if (!Schema::connection('sqlite_source')->hasTable($table)) {
            $this->warn("Table {$table} does not exist in SQLite, skipping...");
            return;
        }

        // Obtener datos de SQLite
        $data = DB::connection('sqlite_source')->table($table)->get();

        if ($data->isEmpty()) {
            $this->info("No data found in {$table}, skipping...");
            return;
        }

        $this->info("Found {$data->count()} records in {$table}");

        // Obtener columnas de la tabla
        $columns = Schema::connection('sqlite_source')->getColumnListing($table);

        // Escribir comentario
        fwrite($file, "-- Table: {$table}\n");
        fwrite($file, "-- Records: {$data->count()}\n\n");

        // Generar DELETE para limpiar (opcional, comentado)
        fwrite($file, "-- DELETE FROM {$table};\n\n");

        $count = 0;
        foreach ($data as $record) {
            $array = (array) $record;
            
            // Eliminar campos que no existen en PostgreSQL
            unset($array['rowid']);
            
            // Filtrar solo columnas que existen
            $filteredArray = [];
            foreach ($columns as $column) {
                if ($column !== 'rowid' && array_key_exists($column, $array)) {
                    $filteredArray[$column] = $array[$column];
                }
            }

            // Construir query INSERT (escapar palabras reservadas de PostgreSQL)
            $escapedColumns = array_map(function($col) {
                return $this->escapeColumnName($col);
            }, array_keys($filteredArray));
            $columnsList = implode(', ', $escapedColumns);
            $values = [];
            
            // Detectar columnas booleanas por nombre
            $booleanColumns = $this->getBooleanColumns($table);
            
            foreach ($filteredArray as $key => $value) {
                if ($value === null) {
                    $values[] = 'NULL';
                } elseif (in_array($key, $booleanColumns)) {
                    // Convertir a booleano: 0/1, '0'/'1', true/false -> TRUE/FALSE
                    $boolValue = false;
                    if (is_bool($value)) {
                        $boolValue = $value;
                    } elseif (is_int($value)) {
                        $boolValue = (bool) $value;
                    } elseif (is_string($value)) {
                        $boolValue = in_array(strtolower($value), ['1', 'true', 'yes', 'on']);
                    }
                    $values[] = $boolValue ? 'TRUE' : 'FALSE';
                } elseif (is_bool($value)) {
                    $values[] = $value ? 'TRUE' : 'FALSE';
                } elseif (is_int($value)) {
                    $values[] = $value;
                } elseif (is_float($value)) {
                    $values[] = $value;
                } else {
                    // Escapar comillas simples y barras invertidas para PostgreSQL
                    $escaped = str_replace(["'", "\\"], ["''", "\\\\"], (string) $value);
                    $values[] = "'{$escaped}'";
                }
            }
            
            $valuesList = implode(', ', $values);
            
            // Usar INSERT ... ON CONFLICT para evitar duplicados
            $uniqueKeyFields = $this->getUniqueKeyFields($table, $filteredArray);
            
            if ($uniqueKeyFields && is_array($uniqueKeyFields) && !empty($uniqueKeyFields)) {
                // Asegurar que todos los elementos son strings (nombres de columnas)
                $conflictColumns = array_filter($uniqueKeyFields, function($field) {
                    return is_string($field) && !empty($field);
                });
                
                if (!empty($conflictColumns)) {
                    // Escapar nombres de columnas en ON CONFLICT
                    $escapedConflictColumns = array_map(function($col) {
                        return $this->escapeColumnName($col);
                    }, $conflictColumns);
                    $conflictColumnsStr = implode(', ', $escapedConflictColumns);
                    
                    $updateSet = [];
                    foreach ($filteredArray as $key => $val) {
                        if (!in_array($key, $conflictColumns)) {
                            $escapedKey = $this->escapeColumnName($key);
                            $updateSet[] = "{$escapedKey} = EXCLUDED.{$escapedKey}";
                        }
                    }
                    $updateClause = !empty($updateSet) ? 'DO UPDATE SET ' . implode(', ', $updateSet) : 'DO NOTHING';
                    
                    fwrite($file, "INSERT INTO {$table} ({$columnsList}) VALUES ({$valuesList}) ON CONFLICT ({$conflictColumnsStr}) {$updateClause};\n");
                } else {
                    // INSERT simple si no hay columnas válidas
                    fwrite($file, "INSERT INTO {$table} ({$columnsList}) VALUES ({$valuesList});\n");
                }
            } else {
                // INSERT simple sin ON CONFLICT si no hay clave única identificada
                fwrite($file, "INSERT INTO {$table} ({$columnsList}) VALUES ({$valuesList});\n");
            }
            
            $count++;
        }

        fwrite($file, "\n");
        $this->info("✓ Generated {$count} INSERT queries for {$table}");
    }

    /**
     * Get unique key fields for ON CONFLICT clause
     */
    protected function getUniqueKeyFields(string $table, array $data): ?array
    {
        // Usar 'id' como clave única si existe
        if (isset($data['id'])) {
            return ['id'];
        }
        
        // Para tablas específicas, usar otras claves únicas
        $uniqueKeys = [
            'users' => ['email'],
            'site_settings' => ['id'],
            'pages' => ['slug'],
        ];
        
        if (isset($uniqueKeys[$table])) {
            $keyFields = $uniqueKeys[$table];
            $availableFields = [];
            foreach ($keyFields as $field) {
                if (isset($data[$field])) {
                    $availableFields[] = $field;
                }
            }
            return !empty($availableFields) ? $availableFields : null;
        }
        
        return null;
    }

    /**
     * Get boolean columns for a table
     */
    protected function getBooleanColumns(string $table): array
    {
        $booleanColumns = [
            'books' => ['active'],
            'testimonials' => ['active'],
            'site_settings' => ['cookies_enabled'],
            'reviews' => ['approved'],
            'blog_posts' => ['published'],
        ];
        
        return $booleanColumns[$table] ?? [];
    }

    /**
     * Escape column name if it's a PostgreSQL reserved word
     */
    protected function escapeColumnName(string $column): string
    {
        // Palabras reservadas de PostgreSQL que pueden usarse como nombres de columna
        $reservedWords = [
            'order', 'user', 'group', 'select', 'table', 'index', 'key',
            'default', 'constraint', 'foreign', 'primary', 'references',
            'check', 'unique', 'limit', 'offset', 'as', 'on', 'where',
            'from', 'join', 'inner', 'left', 'right', 'full', 'outer',
            'union', 'except', 'intersect', 'distinct', 'all', 'case',
            'when', 'then', 'else', 'end', 'having', 'order', 'by',
            'asc', 'desc', 'null', 'not', 'and', 'or', 'in', 'like',
            'between', 'is', 'exists', 'any', 'some', 'all', 'cast',
            'extract', 'current_date', 'current_time', 'current_timestamp',
        ];
        
        // Si es una palabra reservada, escapar con comillas dobles
        if (in_array(strtolower($column), $reservedWords)) {
            return '"' . $column . '"';
        }
        
        return $column;
    }
}
