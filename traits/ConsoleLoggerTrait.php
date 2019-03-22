<?php namespace Tschallacka\FormTools\Traits; 

use Symfony\Component\Console\Output\ConsoleOutput;
use ReflectionClass;

trait ConsoleLoggerTrait 
{
    private $console;
    private $reflection;     
    
    protected function log($str='')
    {
        static $classname;
        if(is_null($this->console)) {
            $this->console = new ConsoleOutput();
        }
        if(is_null($classname)) {
            $reflect = $this->getReflection();
            $classname = $reflect->getShortName();
        }
        $this->console->writeln($classname. ' > ' . $str);
    }
    
    protected function debugLog($object) 
    {
        $this->log(var_export($object, true));
    }
    
    /**
     * Returns the reflection class of this instance.
     * @return \ReflectionClass
     */
    protected function getReflection()
    {
        if(is_null($this->reflection)) {
            $this->reflection = new ReflectionClass($this);
        }
        return $this->reflection;
    }
}