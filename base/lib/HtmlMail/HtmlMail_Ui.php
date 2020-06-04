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
        return '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px;">
                    <tbody>
                        <tr>
                            <td>
                                <div style="border-bottom: 2px solid #00AB83; text-align: center; padding: 20px; margin: 0 0 40px;">
                                    <img src="https://www.plasticwebs.com/plastic/visual/img/logo.png" />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-size: 1rem; line-height: 1.3em;">'.$content.'</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="border-top: 2px solid #b2da3c; padding: 20px 0; margin: 40px 0 0 0; color: #00AB83;">
                                    <p style="font-size: 1rem; font-weight: bold;">Plastic Webs</p>
                                    <p style="font-size: 0.9rem; font-weight: bold;">
                                        Tel. <a href="tel:+59122712050" style="color: #22AB83; text-decoration: none; font-weight: normal;" >+591 2 2712050</a><br />
                                        Cel. <a href="tel:+59172555443" style="color: #22AB83; text-decoration: none; font-weight: normal;" >+591 725 55443</a><br />
                                        Zona Achumani c.20 manzana "W" #3<br />
                                        La Paz - Bolivia<br /><br />
                                        <a href="mailto:info@plasticwebs.com" style="color: #22AB83; text-decoration: none; font-weight: normal;">info@plasticwebs.com</a><br />
                                        <a href="https://www.plasticwebs.com" style="color: #22AB83; text-decoration: none; font-weight: normal;" target="_blank">www.plasticwebs.com</a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }

}

?>