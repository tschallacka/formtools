<?php namespace Tschallacka\FormTools\Tests;

use Model;
use ReflectionClass;
use PluginTestCase as BasePluginTestCase;
use Tschallacka\FormTools\Traits\ConsoleLoggerTrait;


abstract class PluginTestCase extends BasePluginTestCase
{
    use ConsoleLoggerTrait;
    
    public function setUp() 
    {
        parent::setup();
    }
    
    /**
     * Test wether a certain test method is active at this moment.
     * @param string $name the method of this class to test
     * @return boolean
     */
    public function isTestActive($name) 
    {
        $clazz = get_class($this);
        return $this->getName() == $name || $this->getName() === ($clazz . '::' . $name);
    }
    
    /**
     * Test wether any of the given tests names in the array is active at this point
     * @param array $names An array of names of tests
     * @return boolean
     */
    public function isAnyTestActive(array $names) 
    {
        foreach($names as $name) {
            if($this->isTestActive($name)) {
                return true;
            }
        }
        return false;
    }
    
    protected function getPluginCodeFromClass($class) 
    {
        $reflect = new ReflectionClass($class);
        $path = $reflect->getFilename();
        $basePath = $this->app->pluginsPath();
        
        $result = false;
        
        if (strpos($path, $basePath) === 0) {
            $result = ltrim(str_replace('\\', '/', substr($path, strlen($basePath))), '/');
            $result = implode('.', array_slice(explode('/', $result), 0, 2));
        }
        
        return $result;
    }
    
    /**
     * Generate a spoof model
     * @param $clazz
     * @param array $attributes
     * @return Model
     */
    protected function spoofModelInsert($clazz, $attributes = [])
    {
        Model::unguard();
        $test = new $clazz();
        if(!is_null($test->connection)) {
            throw new \Exception('Model connection is not null but ' . $test->connection);
        }
        $model = $clazz::create($attributes);
        Model::reguard();
        return $model;
    }
    
}