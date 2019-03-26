<?php namespace Tschallacka\FormTools\Tests\FormWidgets;

use Tschallacka\FormTools\Models\FormToolsDemo as Model;
use Tschallacka\FormTools\Tests\PluginTestCase;
use Backend\Classes\FormField;
use Backend\Classes\Controller;
use Tschallacka\FormTools\FormWidgets\ColorPicker;

class ColorPickerTest extends PluginTestCase
{
    
    /**
     * Test wether all expected assets are loaded by the controller.
     */
    public function testAssets() 
    {
        $formField = new FormField('color', 'color');
        $formField->valueFrom = 'color';
        
        $model = new Model(['color' => 'rgba(255, 255, 255, 0.5)']);
        
        $controller = new Controller();
        
        $colorpicker = new ColorPicker($controller, $formField, [
            'model' => $model,
        ]);
       
        $registeredAssets = $controller->getAssetPaths();

        $js = array_get($registeredAssets, 'js');
        $css = array_get($registeredAssets, 'css');
        
        $this->assertEquals(2, count($js), 'No Javascript files registered');
        
        $this->assertEquals(2, count($css), 'No CSS files registered');
        
        $found_count = 0;
        
        $files = ['css/colorpicker.css', 'css/spectrum.css', 'js/colorpicker.js', 'js/spectrum.js'];
        $expected_count = count($files);
        
        $merged_files = array_merge($js, $css);
        
        foreach($merged_files as $file) {
            foreach($files as $key => $match_file) {
                if(strpos($file, $match_file)) {
                    $found_count++;
                    unset($files[$key]);
                    continue;
                }
            }
        }
        
        $this->assertEquals($expected_count, $found_count, 'Not all expected files were registered');
    }
    
    /**
     * Check wether all required rendering variables are set.
     */
    public function testSettings()
    {
        $formField = new FormField('color', 'color');
        $formField->valueFrom = 'color';
        
        $model = new Model(['color' => 'rgba(255, 255, 255, 0.5)']);
        
        $controller = new Controller();
        
        $colorpicker = new ColorPicker($controller, $formField, [
            'model' => $model,
        ]);
        
        $colorpicker->prepareVars();
        
        $vars = $colorpicker->vars;
        
        $this->assertArrayHasKey('value', $vars);
        $this->assertEquals('rgba(255, 255, 255, 0.5)', $vars['value']);
        
        $this->assertArrayHasKey('name', $vars);
        $this->assertEquals('color', $colorpicker->vars['name']);
        
        $this->assertArrayHasKey('model', $vars);
        $this->assertNotNull($vars['model']);
        
        $this->assertEquals(3, count($vars), 'Unexpected amount of registered variables');
    }
}