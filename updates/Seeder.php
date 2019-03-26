<?php namespace Tschallacka\FormTools\Updates;

use Db;
use \Seeder as BaseSeeder;
use Tschallacka\FormTools\Traits\ConsoleLoggerTrait;

class Seeder extends BaseSeeder
{
    protected $table;
    protected $file;
    
    use ConsoleLoggerTrait {
        log as genericLog;
    }
    
    protected function log($message)
    {
        if(env('APP_ENV') !== 'testing') {
            $this->genericLog($message);
        }
    }
    
    public function run()
    {
        if(is_null($this->table)) {
            throw new \Exception('No database table name defined');
        }
        
        if(is_null($this->file)) {
            throw new \Exception('No file table name defined');
        }
        
        /** Don't seed all the files in the tables when in testing mode **/
        if(env('APP_ENV') !== 'testing') {
            $ds = DIRECTORY_SEPARATOR;
            $dir = dirname($this->getReflection()->getFileName());
            $basepath = $dir . $ds . 'seed' . $ds . $this->file . $ds;
            
            $file_list = array_merge(glob($basepath . '*.txt'), glob($basepath . '*.json'));
            
            foreach($file_list as $file) {
                $this->insert($file);
                gc_collect_cycles();
            }
            
            $this->afterRun();
        }
        else {
            
        }
        
        
    }
    
    public function insert($file)
    {
        $this->log('Seeding file '.$file);
        $json = json_decode(file_get_contents($file),true);
        DB::transaction(function() use($json) {
            foreach($json as $entry) {
                if(array_key_exists('row_num', $entry)) {
                    unset($entry['row_num']);
                }
                if($to_insert = $this->modify($entry)) {
                    Db::table($this->table)->insert($to_insert);
                }
            }
        });
    }
    
    /**
     * modify the values to be inserted.
     * return null or false to skip a value
     * @param array $to_insert
     * @return array
     */
    public function modify($to_insert)
    {
        return $to_insert;
    }
    
    public function afterRun()
    {
        
    }
}