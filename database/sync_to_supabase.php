<?php

/**
 * Script to sync SQLite data to Supabase (PostgreSQL)
 * Preserves all existing IDs and data.
 */

if (php_sapi_name() !== 'cli') {
    die("This script can only be run via CLI.\n");
}

// 1. Get arguments
if ($argc < 6) {
    echo "Usage: php database/sync_to_supabase.php <host> <database> <port> <user> <password>\n";
    exit(1);
}

$host = $argv[1];
$dbname = $argv[2];
$port = $argv[3];
$user = $argv[4];
$password = $argv[5];

echo "Connecting to SQLite...\n";
try {
    $sqlite = new PDO('sqlite:database/database.sqlite');
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error connecting to SQLite: " . $e->getMessage() . "\n");
}

echo "Connecting to Supabase (PostgreSQL)...\n";
try {
    $pgsql = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user", $user, $password);
    $pgsql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error connecting to Supabase: " . $e->getMessage() . "\n");
}

// Ordered list of tables to avoid foreign key conflicts during insertion
$tables = [
    // Core master tables
    'm_tim',
    'm_sub_tim',
    'm_kegiatan',
    'm_kabkota',
    'm_periode',
    // Transactional & relation tables
    't_target_kegiatan',
    'm_user',
    't_monitoring_progress',
    't_dokumen_survei',
    't_progress_history',
    // Laravel tables
    'migrations',
    'personal_access_tokens',
    'sessions'
];

echo "Starting data synchronization...\n";

try {
    $pgsql->beginTransaction();

    // Disable foreign key constraints temporarily on PostgreSQL
    $pgsql->exec("SET CONSTRAINTS ALL DEFERRED;");

    foreach ($tables as $table) {
        echo "Processing table: $table...\n";

        // Check if table exists in SQLite
        $stmtCheck = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
        if (!$stmtCheck->fetch()) {
            echo "  Table $table does not exist in SQLite, skipping.\n";
            continue;
        }

        // Empty the PostgreSQL table first
        $pgsql->exec("TRUNCATE TABLE \"$table\" CASCADE;");

        // Fetch all rows from SQLite
        $stmt = $sqlite->query("SELECT * FROM \"$table\"");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) === 0) {
            echo "  No data found in SQLite for $table.\n";
            continue;
        }

        // Prepare PostgreSQL insert query
        $columns = array_keys($rows[0]);
        $colNames = implode(', ', array_map(function($c) { return "\"$c\""; }, $columns));
        $placeholders = implode(', ', array_map(function($c) { return ":$c"; }, $columns));
        
        $insertQuery = "INSERT INTO \"$table\" ($colNames) VALUES ($placeholders)";
        $insertStmt = $pgsql->prepare($insertQuery);

        $insertedCount = 0;
        foreach ($rows as $row) {
            // Bind values, converting datatypes as necessary
            $bindParams = [];
            foreach ($row as $col => $val) {
                // Postgres boolean conversion if needed
                if ($val === null) {
                    $bindParams[":$col"] = null;
                } else {
                    $bindParams[":$col"] = $val;
                }
            }
            $insertStmt->execute($bindParams);
            $insertedCount++;
        }

        echo "  Successfully migrated $insertedCount rows to $table.\n";

        // Reset PostgreSQL serial sequence to prevent future auto-increment conflicts
        // Determine the primary key column name
        $pkName = null;
        if ($table === 'personal_access_tokens' || $table === 'migrations') {
            $pkName = 'id';
        } else if (strpos($table, 'm_') === 0 || strpos($table, 't_') === 0) {
            // For custom tables, they are formatted as id_tablename (e.g. id_tim for m_tim)
            // Exception for m_kabkota which has id_kabkota as CHAR(4) (non-serial)
            if ($table !== 'm_kabkota') {
                $parts = explode('_', $table, 2);
                $pkName = 'id_' . $parts[1];
            }
        }

        if ($pkName) {
            try {
                $pgsql->exec("SELECT setval(pg_get_serial_sequence('\"$table\"', '$pkName'), coalesce(max(\"$pkName\"), 1)) FROM \"$table\";");
                echo "  Reset sequence for $table ($pkName) successfully.\n";
            } catch (Exception $seqEx) {
                // If not a sequence column, ignore
            }
        }
    }

    $pgsql->commit();
    echo "\nData synchronization completed successfully!\n";

} catch (Exception $e) {
    $pgsql->rollBack();
    echo "\nError during synchronization: " . $e->getMessage() . "\n";
    exit(1);
}
