<?php
/**
* @class HtmlMail
*
* This class represents the wrapup for the emails
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class HtmlMail extends Db_Object {

    /**
    * Load an object using its code
    */
    static public function code($code) {
        return HtmlMail::readFirst(array('where'=>'code="'.$code.'"'));
    }

    /**
    * Send an email formatted with a template
    */
    static public function send($email, $code, $values=array(), $template='basic') {
        $htmlMail = HtmlMail::code($code);
        Email::send($email, $htmlMail->get('subject'), $htmlMail->showUi('Mail', array('values'=>$values, 'template'=>$template)), $htmlMail->get('replyTo'));
    }

    static public function sendFromFile($email, $code, $values=array()) {
        $subjects = array('notification'=>'Usted tiene una nueva notificación',
                            'welcomePlaceEditPayPal'=>'Gracias por registrar su empresa',
                            'welcomePlaceEditTransference'=>'Gracias por registrar su empresa',
                            'welcomePlaceEditFree'=>'Gracias por registrar su empresa',
                            'passwordForgot'=>'Contraseña olvidada',
                            'report'=>'Una empresa ha sido reportada',
                            'publishedPlace'=>'Su empresa ha sido publicada',
                            'payedThanks'=>'Gracias por su pago',
                            'modifyPlaceEdit'=>'Gracias por actualizar la información de la empresa',
                            'placeEditNew'=>'ADMIN - Lugar a editar - Nuevo',
                            'placeEditModified'=>'ADMIN - Lugar a editar - Modificado',
                            'payedPlace'=>'ADMIN - Se pagó para publicar una empresa',
                            'payedPlaceEdit'=>'ADMIN - Se pagó para publicar una empresa',
                            'placeEditNewPromoted'=>'ADMIN - Lugar a editar - Promocionado');
        $subject = $subjects[$code];
        Email::send($email, $subject, HtmlMail::showFile($code, $values));
    }

    static public function showFile($code, $values) {
        $file = BASE_FILE.'data/HtmlMail/'.$code.'.html';
        if (file_exists($file)) {
            $htmlMail = new HtmlMail(array('mail_es'=>file_get_contents($file)));
            return $htmlMail->showUi('MailFile', array('values'=>$values));
        }
    }

}
?>