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
                            {--force : Force migration even if tables exist}';

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
        
        if ($existingCount > 0 && !$this->option('force')) {
            if (!$this->confirm("Table {$table} already has {$existingCount} records. Continue? (This will add new records)", true)) {
                $this->warn("Skipping {$table}...");
                return;
            }
        }

        // Insertar datos en PostgreSQL
        $bar = $this->output->createProgressBar($data->count());
        $bar->start();

        $chunkSize = 100;
        $data->chunk($chunkSize)->each(function ($chunk) use ($table, $bar, $pgsqlConnection) {
            try {
                // Convertir a array y manejar campos especiales
                $records = $chunk->map(function ($record) use ($table) {
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
                    
                    return $array;
                })->toArray();

                // Usar insertOrIgnore para evitar duplicados si hay IDs
                if ($existingCount > 0) {
                    foreach ($records as $record) {
                        try {
                            DB::connection($pgsqlConnection)->table($table)->insertOrIgnore($record);
                        } catch (\Exception $e) {
                            // Si insertOrIgnore no funciona, intentar updateOrInsert
                            if (isset($record['id'])) {
                                DB::connection($pgsqlConnection)->table($table)
                                    ->updateOrInsert(['id' => $record['id']], $record);
                            } else {
                                DB::connection($pgsqlConnection)->table($table)->insert($record);
                            }
                        }
                    }
                } else {
                    DB::connection($pgsqlConnection)->table($table)->insert($records);
                }
                
                $bar->advance(count($records));
            } catch (\Exception $e) {
                $bar->advance(count($chunk));
                $this->newLine();
                $this->warn("Error inserting chunk: " . $e->getMessage());
                // Intentar insertar uno por uno para identificar el problema
                foreach ($chunk as $record) {
                    try {
                        $array = (array) $record;
                        unset($array['rowid']);
                        DB::connection($pgsqlConnection)->table($table)->insert($array);
                    } catch (\Exception $e2) {
                        $this->error("Failed to insert record ID " . ($array['id'] ?? 'unknown') . ": " . $e2->getMessage());
                    }
                }
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("✓ {$table} migrated successfully");
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
