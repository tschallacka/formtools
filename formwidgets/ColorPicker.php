<?php namespace Tschallacka\FormTools\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * ColorPicker Form Widget
 */
class ColorPicker extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'tsch_color_picker';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
    	
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('colorpicker');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/colorpicker.css','1.0.0');
        $this->addCss('css/spectrum.css','1.0.0');
        
        $this->addJs('js/colorpicker.js','1.0.0');
        $this->addJs('js/spectrum.js','1.0.0');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
