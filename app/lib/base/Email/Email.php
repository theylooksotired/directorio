<?php
/**
* @class Email
*
* This is a helper class to send emails
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Email {

    /**
    * Format headers to send an email
    */
    static public function send($mailTo, $subject, $htmlMail, $replyTo='') {
        require_once BASE_FILE."helpers/mailer/PHPMailer.php";
        require_once BASE_FILE."helpers/mailer/SMTP.php";
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('info@plasticwebs.com', 'Plastic Webs');
        $mail->addReplyTo('info@plasticwebs.com', 'Plastic Webs');
        $mail->addAddress($mailTo);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlMail;
        $mail->AltBody = strip_tags($htmlMail);
        @$mail->send();
    }
    
}
?>