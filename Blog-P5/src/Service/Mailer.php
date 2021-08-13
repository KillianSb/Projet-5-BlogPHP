<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * return an array with mail information
 */
class Mailer
{
    public $mail;

    public function __construct()
    {
        $Host       = 'smtp.exemple.com';                     //Set the SMTP server to send through
        $Username   = 'exemple@exemple.com';                     //SMTP username
        $Password   = 'exemple';                               //SMTP password
        $Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      
        $this->mail = new PHPMailer();      // Cree un nouvel objet PHPMailer
        $this->mail->IsSMTP();              // activation du SMTP
        $this->mail->SMTPDebug = 0;         // debogage: 1 = Erreurs et messages, 2 = messages seulement
        $this->mail->AuthType = "PLAIN";
        $this->mail->SMTPAuth = true;       // Authentification SMTP activé
        $this->mail->SMTPSecure = 'ssl';    // Gmail REQUIERT Le transfert securisé avec SSL
        $this->mail->Host = $Host;
        $this->mail->Port = $Port;
        $this->mail->Username = $Username;
        $this->mail->isHTML(true);   
        $this->mail->Password = $Password;   //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    }

    public function sendMail($to, $from, $from_name, $body, $subject){
        $this->mail->SetFrom($from, $from_name);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AddAddress($to);
        if(!$this->mail->Send()) {
            return 'Mail error: '.$this->mail->ErrorInfo;
        }
        else{
            return true;
        }    
    }
}