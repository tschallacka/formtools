<?php namespace Tschallacka\FormTools\Traits;

use ApplicationException;
use Lang;

trait BackendFormHelpers 
{
    
    protected function loadOptionList() 
    {
        $field = $this->formField;
        $config = (array)$this->config;
        $field->options(function () use ($field, $config) {
            $fieldOptions = (isset($config['options'])) ? $config['options'] : null;
            $fieldOptions = $this->getOptionsFromModel($field, $fieldOptions);
            return $fieldOptions;
        });
    }
    
    /**
     * Looks at the model for defined options.
     */
    protected function getOptionsFromModel($field, $fieldOptions)
    {
        
        /**
         * Advanced usage, supplied options are callable
         */
        if (is_array($fieldOptions) && is_callable($fieldOptions)) {
            $fieldOptions = call_user_func($fieldOptions, $this, $field);
        }
    
        /**
         * Refer to the model method or any of its behaviors
         */
        if (!is_array($fieldOptions) && !$fieldOptions) {
            list($model, $attribute) = $field->resolveModelAttribute($this->model, $field->fieldName);
    
            $methodName = 'get'.studly_case($attribute).'Options';
            if (
                !$this->backendFormHelperMethodExists($model, $methodName) &&
                !$this->backendFormHelperMethodExists($model, 'getDropdownOptions')
                ) {
                    throw new ApplicationException(Lang::get(
                        'backend::lang.field.options_method_not_exists',
                        ['model'=>get_class($model), 'method'=>$methodName, 'field'=>$field->fieldName]
                        ));
                }
    
                if ($this->backendFormHelperMethodExists($model, $methodName)) {
                    $fieldOptions = $model->$methodName($field->value);
                }
                else {
                    $fieldOptions = $model->getDropdownOptions($attribute, $field->value);
                }
        }
        
        /**
         * Field options are an explicit method reference
         */
        elseif (is_string($fieldOptions)) {
            if (!$this->backendFormHelperMethodExists($this->model, $fieldOptions)) {
                throw new ApplicationException(Lang::get(
                    'backend::lang.field.options_method_not_exists',
                    ['model'=>get_class($this->model), 'method'=>$fieldOptions, 'field'=>$field->fieldName]
                    ));
            }
    
            $fieldOptions = $this->model->$fieldOptions($field->value, $field->fieldName);
        }
    
        return $fieldOptions;
    }
    
    /**
     * Internal helper for method existence checks
     * @param  object $object
     * @param  string $method
     * @return boolean
     */
    protected function backendFormHelperMethodExists($object, $method)
    {
        if (method_exists($object, 'methodExists')) {
            return $object->methodExists($method);
        }
    
        return method_exists($object, $method);
    }
}