<?php
/**
* @class FormFieldDateComplete
*
* This is a helper class to generate complete date fields with selectboxes.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class FormField_DateComplete extends FormField_DefaultDate {

    /**
    * The constructor of the object.
    */
    public function __construct($options) {
        parent::__construct($options);
        $this->options['view'] = 'complete';
    }

    /**
    * Render the element with an static function.
    */
    static public function create($options) {
        $options['view'] = 'complete';
        return FormField_DefaultDate::create($options);
    }
    
}
?>