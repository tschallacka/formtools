<?php namespace Tschallacka\FormTools\Tests\FormWidgets;

use Tschallacka\FormTools\Models\FormToolsDemo as Model;
use Tschallacka\FormTools\Tests\PluginTestCase;
use Backend\Classes\FormField;
use Backend\Classes\Controller;
use Tschallacka\FormTools\FormWidgets\FilteredCheckboxList;

class FilteredCheckboxListTest extends PluginTestCase
{
 
    /**
     * Check wether all required assets are loaded by the controller.
     */
    public function testAssets()
    {
        $formField = new FormField('options', 'options');
        
        
        $model = new Model(['options' => [1, 2, 3]]);
        
        $controller = new Controller();
        
        $checkboxlist = new FilteredCheckboxList($controller, $formField, [
            'model' => $model,
        ]);
        
        $registeredAssets = $controller->getAssetPaths();
        
        $js = array_get($registeredAssets, 'js');
        $css = array_get($registeredAssets, 'css');
        
        $this->assertEquals(1, count($js), 'Not enough Javascript files registered');
        
        $this->assertEquals(1, count($css), 'Not enough CSS files registered');
        
        $found_count = 0;
        
        $files = ['css/filteredcheckboxlist.css', 'js/filteredcheckboxlist.js'];
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
     * Check wether the default variables for rendering are set correctly.
     */
    public function testSettings()
    {
        $formField = new FormField('options', 'label');
       
        
        $model = new Model([
            'options' => [1, 2, 3]
            
        ]);
        
        $controller = new Controller();
        
        $checkboxlist = new FilteredCheckboxList($controller, $formField, [
            'model' => $model,
        ]);
        
        $checkboxlist->prepareVars();
        $vars = $checkboxlist->vars;
        
        $this->assertArrayHasKey('value', $vars);
        $this->assertEquals(true, is_array(array_get($vars, 'value')));
        $this->assertEquals('123', implode(array_get($vars,'value'),''));
        
        $this->assertArrayHasKey('model', $vars);
        $this->assertNotNull(array_get($vars, 'model'));
        
        $this->assertArrayHasKey('fieldOptions', $vars);
        $this->assertNotNull(array_get($vars, 'fieldOptions'));
        $this->assertEquals(true, is_array(array_get($vars, 'fieldOptions')));
        $this->assertEquals(count($model->getOptionsOptions()), count(array_get($vars, 'fieldOptions')));
        
        $this->assertArrayHasKey('name', $vars);
        $this->assertEquals('options', array_get($vars, 'name'));
        
        $this->assertArrayHasKey('checkedValues', $vars);
        $this->assertEquals(true, is_array(array_get($vars, 'checkedValues')));
        $this->assertEquals('123', implode(array_get($vars,'checkedValues'), ''));
        
        $this->assertArrayHasKey('enabled_class', $vars);
        $this->assertEquals('custom-checkbox', array_get($vars, 'enabled_class'));
        
        $this->assertArrayHasKey('disabled_status', $vars);
        $this->assertEquals('', array_get($vars, 'disabled_status'));
        
        $this->assertArrayHasKey('placeholder', $vars);
        $this->assertNotNull('', array_get($vars, 'placeholder'));
        
        $this->assertEquals(9, count($vars), 'Unexpected amount of registered variables');
    }
    
    /**
     * Check wether all settings for disabled are
     * working as expected.
     */
    public function testDisabledSettings() 
    {
        $formField = new FormField('options', 'label');

        $formField->config = [
            'disabled' => true,
        ];
        
        $model = new Model();
        
        $controller = new Controller();
        
        $checkboxlist = new FilteredCheckboxList($controller, $formField, [
            'model' => $model,
        ]);
        
        $checkboxlist->prepareVars();
        $vars = $checkboxlist->vars;
        
        $this->assertArrayHasKey('enabled_class', $vars);
        $this->assertEquals('', array_get($vars, 'enabled_class'));
        
        $this->assertArrayHasKey('disabled_status', $vars);
        $this->assertEquals('disabled="disabled"', array_get($vars, 'disabled_status'));
    }
    
    /**
     * Check wether null value will result in an empty array
     * for the checked items list.
     */
    public function testNoSelectedItems()
    {
        $formField = new FormField('options', 'label');
        
        $formField->config = [
            'disabled' => true,
        ];
        
        $model = new Model();
        
        $controller = new Controller();
        
        $checkboxlist = new FilteredCheckboxList($controller, $formField, [
            'model' => $model,
        ]);
        
        $checkboxlist->prepareVars();
        $vars = $checkboxlist->vars;
        
        $this->assertEquals(false, is_array(array_get($vars, 'value')));
        $this->assertNull(array_get($vars,'value'));
        
        $this->assertArrayHasKey('checkedValues', $vars);
        $this->assertEquals(true, is_array(array_get($vars, 'checkedValues')));
        $this->debugLog(array_get($vars,'checkedValues'));
        $this->assertEquals(0, count(array_get($vars,'checkedValues')));
    }
}