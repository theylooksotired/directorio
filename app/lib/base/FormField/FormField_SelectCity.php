<?php
/**
* @class FormFieldSelectCity
*
* This is a helper class to generate a select form field filled with internal links.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class FormField_SelectCity extends FormField_DefaultSelect {

    /**
    * The constructor of the object.
    */
    public function __construct($options) {
        $options['value'] = FormField_SelectCity::valuesInternal();
        parent::__construct($options);
    }

    /**
    * Render the element with an static function.
    */
    static public function create($options) {
        return FormField_DefaultSelect::create($options);
    }

    /**
    * Create an array with all the accesible internal links.
    */
    static public function valuesInternal() {
        $query = 'SELECT DISTINCT cityUrl, city, COUNT(idPlace) AS numPlaces
                        FROM '.Db::prefixTable('Place').'
                        GROUP BY cityUrl
                        HAVING numPlaces > 5
                        ORDER BY cityUrl';
        $results = Db::returnAll($query);
        $values = [''=>'-- Seleccione --'];
        foreach ($results as $result) {
            $values[$result['city']] = $result['city'];

        }
        return $values;
    }

}
?>