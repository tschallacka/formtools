<?php namespace Tschallacka\FormTools;

use Backend;
use System\Classes\PluginBase;
use Tschallacka\FormTools\FormWidgets\ColorPicker;
use Tschallacka\FormTools\FormWidgets\FilteredCheckboxList;

/**
 * FormTools Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'FormTools',
            'description' => 'A collection of form utilities for use in the backend.',
            'author'      => 'Tschallacka',
            'icon'        => 'icon-th-list'
        ];
    }

    public function registerFormWidgets()
    {
    	return [
    			ColorPicker::class => 'tsch_color_picker',
    			FilteredCheckboxList::class => 'tsch_filtered_checkboxlist',
    	];
    }

}
