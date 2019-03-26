<?php namespace Tschallacka\FormTools\FormWidgets;

use Tschallacka\FormTools\Traits\BackendFormHelpers;
use Backend\Classes\FormWidgetBase;

/**
 * FilteredCheckboxList Form Widget
 */
class FilteredCheckboxList extends FormWidgetBase
{
    
    use BackendFormHelpers;
    
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'filtered_checkboxlist';
    
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->loadOptionList();
    }
    
    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('filteredcheckboxlist');
    }
    
    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $value = $this->getLoadValue();
        
        $this->vars['value'] = $value;
        $this->vars['model'] = $this->model;
        $this->vars['field'] = $this->formField;
        $this->vars['fieldOptions'] =  $this->formField->options();
        $this->vars['name'] = $this->formField->getName();
        $this->vars['checkedValues'] = (is_array($value) ? $value : (is_null($value) ? [] : [$value]));
        $this->vars['enabled_class'] = (array_get( $this->formField->config,'disabled', false) ? '' : 'custom-checkbox');
        $this->vars['disabled_status'] = (array_get( $this->formField->config,'disabled', false) ? 'disabled="disabled"' : '');
        $this->vars['placeholder'] = ($this->formField->placeholder ? e(trans($this->formField->placeholder)) : null);
    }
    
    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/filteredcheckboxlist.css', 'ExitControl.BackendForms');
        $this->addJs('js/filteredcheckboxlist.js', 'ExitControl.BackendForms');
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return $value;
    }
    
}