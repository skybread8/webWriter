<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateFromSqlite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-from-sqlite 
                            {--sqlite-path= : Path to SQLite database file}
                            {--force : Force migration even if tables exist}
                            {--truncate : Truncate tables before migrating (WARNING: deletes all existing data)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from SQLite database to PostgreSQL';

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

        $this->info("Starting migration from SQLite to PostgreSQL...");
        $this->info("SQLite path: {$sqlitePath}");

        // Configurar conexión temporal a SQLite
        $sqlitePath = realpath($sqlitePath);
        
        config(['database.connections.sqlite_source' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]]);

        try {
            // Verificar que PostgreSQL esté configurado
            $this->info("Checking PostgreSQL connection...");
            $pgsqlConnection = config('database.default') === 'pgsql' ? 'pgsql' : config('database.default');
            DB::connection($pgsqlConnection)->getPdo();
            $this->info("✓ PostgreSQL connection OK");

            // Verificar SQLite
            $this->info("Checking SQLite connection...");
            DB::connection('sqlite_source')->getPdo();
            $this->info("✓ SQLite connection OK");

            // Migrar cada tabla
            foreach ($this->tables as $table) {
                $this->migrateTable($table);
            }

            // Migrar archivos de storage si existen
            $this->info("\n=== Migrating Storage Files ===");
            $this->migrateStorageFiles();

            $this->info("\n✅ Migration completed successfully!");
            $this->info("All data has been migrated from SQLite to PostgreSQL.");

            return 0;
        } catch (\Exception $e) {
            $this->error("Migration failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Migrate a single table
     */
    protected function migrateTable(string $table)
    {
        $this->info("\n=== Migrating table: {$table} ===");

        // Verificar si la tabla existe en SQLite
        if (!Schema::connection('sqlite_source')->hasTable($table)) {
            $this->warn("Table {$table} does not exist in SQLite, skipping...");
            return;
        }

        // Verificar si la tabla existe en PostgreSQL
        $pgsqlConnection = config('database.default') === 'pgsql' ? 'pgsql' : config('database.default');
        if (!Schema::connection($pgsqlConnection)->hasTable($table)) {
            $this->warn("Table {$table} does not exist in PostgreSQL, skipping...");
            $this->warn("Make sure you've run migrations first: php artisan migrate");
            return;
        }

        // Obtener datos de SQLite
        $data = DB::connection('sqlite_source')->table($table)->get();

        if ($data->isEmpty()) {
            $this->info("No data found in {$table}, skipping...");
            return;
        }

        $this->info("Found {$data->count()} records in {$table}");

        // Verificar si hay datos en PostgreSQL
        $pgsqlConnection = config('database.default') === 'pgsql' ? 'pgsql' : config('database.default');
        $existingCount = DB::connection($pgsqlConnection)->table($table)->count();
        
        // Truncar tabla si se solicita
        if ($this->option('truncate') && $existingCount > 0) {
            if ($this->confirm("⚠️  WARNING: This will DELETE all {$existingCount} existing records in {$table}. Continue?", false)) {
                DB::connection($pgsqlConnection)->table($table)->truncate();
                $this->info("✓ Table {$table} truncated");
                $existingCount = 0;
            } else {
                $this->warn("Skipping truncate for {$table}...");
            }
        }
        
        if ($existingCount > 0 && !$this->option('force')) {
            $this->warn("Table {$table} already has {$existingCount} records.");
            $this->info("Using updateOrInsert to update existing records and add new ones...");
        }

        // Insertar datos en PostgreSQL
        $bar = $this->output->createProgressBar($data->count());
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        // Procesar registro por registro para mejor control de errores
        $pgsqlConnection = config('database.default') === 'pgsql' ? 'pgsql' : config('database.default');
        
        foreach ($data as $record) {
            try {
                $array = (array) $record;
                
                // Eliminar campos que no existen en PostgreSQL
                unset($array['rowid']); // SQLite tiene rowid, PostgreSQL no
                
                // Convertir booleanos de SQLite (0/1) a booleanos de PostgreSQL
                foreach ($array as $key => $value) {
                    if ($value === null) {
                        continue;
                    }
                    
                    // Detectar campos booleanos por nombre
                    if (in_array($key, ['active', 'approved']) && (is_int($value) || is_string($value))) {
                        $array[$key] = (bool) (int) $value;
                    }
                }
                
                // Determinar la clave única para updateOrInsert
                $uniqueKey = $this->getUniqueKey($table, $array);
                
                if ($uniqueKey) {
                    // Usar updateOrInsert para actualizar si existe o insertar si no
                    DB::connection($pgsqlConnection)->table($table)
                        ->updateOrInsert($uniqueKey, $array);
                } else {
                    // Si no hay clave única, intentar insertar directamente
                    try {
                        DB::connection($pgsqlConnection)->table($table)->insert($array);
                    } catch (\Exception $e) {
                        // Si falla por duplicado, intentar updateOrInsert con ID
                        if (isset($array['id'])) {
                            DB::connection($pgsqlConnection)->table($table)
                                ->updateOrInsert(['id' => $array['id']], $array);
                        } else {
                            throw $e;
                        }
                    }
                }
                
                $successCount++;
                $bar->advance();
            } catch (\Exception $e) {
                $errorCount++;
                $bar->advance();
                $recordId = $array['id'] ?? ($array['email'] ?? 'unknown');
                $this->newLine();
                $this->warn("⚠️  Failed to migrate record ID {$recordId} in {$table}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        
        if ($errorCount > 0) {
            $this->warn("⚠️  {$table}: {$successCount} migrated, {$errorCount} errors");
        } else {
            $this->info("✓ {$table}: {$successCount} records migrated successfully");
        }
    }

    /**
     * Get unique key for updateOrInsert based on table structure
     */
    protected function getUniqueKey(string $table, array $data): ?array
    {
        // Usar 'id' como clave única si existe
        if (isset($data['id'])) {
            return ['id' => $data['id']];
        }
        
        // Para tablas específicas, usar otras claves únicas
        $uniqueKeys = [
            'users' => ['email'],
            'site_settings' => ['id'], // Solo debería haber uno
            'pages' => ['slug'],
        ];
        
        if (isset($uniqueKeys[$table])) {
            $key = $uniqueKeys[$table];
            $keyData = [];
            foreach ($key as $field) {
                if (isset($data[$field])) {
                    $keyData[$field] = $data[$field];
                }
            }
            return !empty($keyData) ? $keyData : null;
        }
        
        return null;
    }

    /**
     * Migrate storage files
     */
    protected function migrateStorageFiles()
    {
        $sourceStorage = storage_path('app/public');
        $this->info("Storage files should be manually copied if needed.");
        $this->info("Source: {$sourceStorage}");
        $this->info("Make sure to run: php artisan storage:link");
    }
}
