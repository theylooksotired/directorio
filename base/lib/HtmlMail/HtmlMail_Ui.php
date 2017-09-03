<?php
/**
* @class HtmlMailUi
*
* This class manages the UI for the HtmlMail objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class HtmlMail_Ui extends Ui{

    /**
    * Render an email using values in the form #VALUE and a template code of the HtmlMailTemplate object
    * Ex: If the template has the #NAME and #LASTNAME fields, we can fill them using:
    * renderMail(array('values'=>array('NAME'=>'Ray', 'LASTNAME'=>'Bradbury')))
    * Ex: If we also need to use an specific template, we use:
    * renderMail(array('values'=>array('NAME'=>'Ray', 'LASTNAME'=>'Bradbury'), 'template'=>'welcomeToWebsite'))
    */
    public function renderMail($options=array()) {
        $values = (isset($options['values']) && is_array($options['values'])) ? $options['values'] : array();
        if (isset($options['template'])) {
            $template = HtmlMailTemplate::code($options['template']);
        } else {
            $template = HtmlMailTemplate::code('basic');
        }
        $content = $this->object->get('mail');
        foreach ($values as $key=>$value) {
            $content = str_replace('#'.$key, $value, $content);
        }
        return $template->showUi('Template', array('values'=>array('CONTENT'=>$content)));
    }

    public function renderMailFile($options=array()) {
        $values = (isset($options['values']) && is_array($options['values'])) ? $options['values'] : array();
        $content = $this->object->get('mail');
        foreach ($values as $key=>$value) {
            $content = str_replace('#'.$key, $value, $content);
        }
        return '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                    <tbody>
                        <tr><td><p style="text-align: center;"><img src="https://www.plasticwebs.com/plastic/visual/img/logo.png" /></p></td></tr>
                        <tr><td>'.$content.'</td></tr>
                        <tr>
                            <td style="text-align: center;">
                            <p style="font-size: 12px; color: #666;"><strong>------<br />
                            Plastic Webs</strong><br />
                            Tel. <a href="tel:+59122712050">+591 2 2712050</a> | Cel. <a href="tel:+59172555443">+591 725 55443</a><br />
                            Zona Achumani c.20 manzana "W" #3<br />
                            La Paz - Bolivia<br /><br />
                            <a href="mailto:info@plasticwebs.com">info@plasticwebs.com</a><br />
                            <a href="https://www.plasticwebs.com" target="_blank">www.plasticwebs.com</a></p>
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }

}

?>