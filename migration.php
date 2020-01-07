<?php
require __DIR__.'/vendor/autoload.php';
use App\Core\Utils\Tokenizer;

define('MIGRATION_DIR', __DIR__.'/migrations/');
try{

    $app = require_once __DIR__.'/bootstrap/app.php';

    $db = $app->get('database');
    echo "Checking for Migration Table....\n";
    if (!$db->tableExists('migrations')){
        echo "migration table doesn't exist creating one ...\n";
        $db->getConnection()->exec("CREATE TABLE IF NOT EXISTS migrations (
                migration_file VARCHAR(225) NOT NULL,
                ran enum('yes','no') NOT NULL DEFAULT 'no'
            );"
        );
        echo "migration table successfully created!\n";
        echo "running migrations" . PHP_EOL;
    }else{
        echo "migration table already exists" . PHP_EOL;
    }
    if ($migrationSth = $db->query("SELECT migration_file, ran FROM migrations")){

        $insertedMigrationFiles = $migrationSth->fetchAll();
        $migrationFiles = glob(MIGRATION_DIR. '*.php');
        $migrationsNotInserted = array_diff($migrationFiles, array_map(function($row){
            return MIGRATION_DIR. $row['migration_file'];
        }, $insertedMigrationFiles));
        if (count($migrationsNotInserted) > 0){
            $migrationStatement = array_map(function($mfile){
                return sprintf("('%s')", pathinfo($mfile, PATHINFO_BASENAME));
            }, $migrationsNotInserted);
            $db->exec(sprintf("INSERT INTO migrations (migration_file) VALUES %s", implode(',',$migrationStatement)));
        }
        

        if ($migrationToRun = $db->query("SELECT migration_file from migrations where ran = 'no'")){
            foreach($migrationToRun as $migration){
                $migrationFile = MIGRATION_DIR. $migration['migration_file'];
                if(file_exists($migrationFile)){
                    require $migrationFile;
                    $classData = Tokenizer::file_get_php_classes(MIGRATION_DIR.$migration['migration_file']);
                    $className = array_keys($classData)[0];
                    $migrationObject = new $className($app);
                    $migrationSql = $migrationObject->up();
                    $db->exec($migrationSql);
                    if ($db->query(sprintf("UPDATE migrations SET ran='yes' where migration_file = '%s' ",$migration['migration_file'])) !== false){
                            echo "{$migrationFile} successfully ran" . PHP_EOL;
                    }else{
                            echo "{$migrationFile} unsuccessfully ran" . PHP_EOL;
                    }
                }else{
                    echo sprintf("%s file not found", $migrationFile);
                }
               
            }
        }else{
            echo "No Migrations to run";
        }
    }else{
        throw new \Exception('Unable to Fetch migrations from database');
    }
} catch (\Exception $e){
    echo $e;
}
exit();
