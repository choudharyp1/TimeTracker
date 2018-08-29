<?php
/**
 * Created by PhpStorm.
 * User: pchoudhary
 * Date: 07/06/2018
 * Time: 2:52 PM
 */


// require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailSender
{
    static function sendFile($filename, $email){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet="UTF-8";
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'username@gmail.com';
        $mail->Password = 'enter password';
        $mail->SMTPAuth = true;
        $mail->From = 'no-reply@timetracker.anuko.com';
        $mail->FromName  = 'Anuko Time tracker';
        $file_to_attach = "/tmp/timetracker/" .$filename.'.xlsx';
        $mail->Subject   = 'Weekly Report';
        $mail->Body      = "Please download the excel report attached to this email." ."\n" . "Thanks.". "\n";
        $mail->addAddress($email);
        $mail->addAttachment( $file_to_attach , 'WeeklyReport.xlsx' );
        return $mail->send();
    }

    static function sendReminder($email){
        global $user;
        global $i18n;

        $body = "Please update your hours in the time tracker. \n Here is the link: http://timetracker.alert.local/time.php \n  Thanks.";

        import('mail.Mailer');
        $mailer = new Mailer();
        $mailer->setCharSet(CHARSET);
        $mailer->setContentType('text/html');
        $mailer->setSender(SENDER);
        if (!empty($cc))
            $mailer->setReceiverCC($cc);
        if (!empty($user->bcc_email))
            $mailer->setReceiverBCC($user->bcc_email);
        $mailer->setReceiver($email);
        $mailer->setMailMode(MAIL_MODE);
        if (empty($subject)) $subject = "Reminder";
        if (!$mailer->send($subject, $body))
            return false;

        return true;
    }

}