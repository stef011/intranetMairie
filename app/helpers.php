<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPMailerException;

use function PHPSTORM_META\map;

function view($view, $data = null)
{
    $view = str_replace('.', '/', $view);

    if($data != null){
        foreach ($data as $key => $value) {
            $$key = $value;
        }
    }
    require 'ressources/views/' . $view . '.php';
    $str = ob_get_contents();
    ob_end_clean();
    echo $str;
}

function assets($path)
{
    trim($path, '/');
    return '/ressources/assets/' . $path;
}

function route($name, $params=[])
{
    $router = $_SERVER['router'];
    return $router->url($name, $params);
}

if (!function_exists('dd')) {
    function dd()
    {
        array_map(function($x) { 
            dump($x); 
        }, func_get_args());
        die;
    }
 }

/**
 * Send mail easily with parameters in .env file.
 * 
 * @param string $to 
 *      The mail's recipient
 * @param string $subject 
 *      The mail's subject
 * @param string $bodyText
 *      Mail's raw body text, alternative to hmtl for clients that can't display HTML mail
 * @param string $bodyHtml
 *      Body in HTMl, facultative
 * @return bool 
 */
function sendMail($to, $subject, $bodyText, $bodyHtml = null)
{
    $mail = new PHPMailer(true);

    if (!is_array($to)) {
        $to = array($to);
    }

    try {
        $mail->isSMTP();
        $mail->Host         = $_ENV['MAIL_HOST'];
        $mail->Port         = $_ENV['MAIL_PORT'];
        $mail->SMTPAuth     = true;
        $mail->SMTPSecure   = 'tls';
        $mail->Username     = $_ENV['MAIL_USERNAME'];
        $mail->Password     = $_ENV['MAIL_PASSWORD'];
        $mail->CharSet      = 'UTF-8';
        
        
        foreach ($to as $recipient) {
            $mail->addAddress($recipient);
        }
        
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);

        if (null != $bodyHtml) {
            $mail->isHTML(true);
            $mail->Body     = $bodyHtml;
            $mail->AltBody  = $bodyText;
        }else{
            $mail->Body     = $bodyText;
        }
        $mail->Subject      = $subject;
        $mail->Send();
        return true;
    }
    catch(PHPMailerException $e){
        echo "Une erreur est survenue. {$e->errorMessage()}", PHP_EOL;
        exit();
    }
    catch(Exception $e){
        echo "Email non envoyé. {$mail->ErrorInfo}", PHP_EOL;
        exit();
    }
}
