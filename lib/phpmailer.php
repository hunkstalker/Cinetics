<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../vendor/autoload.php';
require_once 'config.php';

function sendEmailNewUser($email, $urlActivationCode)
{
    $mailbody = file_get_contents('../web/mailbodyVerify.html');
    $mailbody = str_replace("{{PATH}}", PATH, $mailbody);
    $mailbody = str_replace("{{URLCODE}", $urlActivationCode, $mailbody);

    $mail = createMail();
    
    sendMail($mailbody, $mail);
    $address = $email;
    $mail->AddAddress($address, 'Verify your email');

    // Enviament
    $mail->Send();

    // Capturar el error en el log
    // $result = $mail->Send();
    //if ($result) {
    //    echo '<script>alert("Correu enviat")</script>';
    //}
    //echo '<script>alert("Error: ' . $mail->ErrorInfo . '")</script>';
}

function sendEmailResetPsw($email, $urlActivationCode)
{
    $mailbody = file_get_contents('../web/mailbodyRecover.html');
    $mailbody = str_replace("{{PATH}}", PATH, $mailbody);
    $mailbody = str_replace("{{URLCODE}", $urlActivationCode, $mailbody);

    $mail = createMail();

    sendMail($mailbody, $mail);
    $address = $email;
    $mail->AddAddress($address, 'Verify your email');

    // Enviament
    $mail->Send();
    
    // Capturar el error en el log
    // $result = $mail->Send();
    //if ($result) {
    //    echo '<script>alert("Correu enviat")</script>';
    //}
    //echo '<script>alert("Error: ' . $mail->ErrorInfo . '")</script>';
}

function createMail(){

    // Las constantes están en constantes.php
    $mail = new PHPMailer();
    $mail->IsSMTP();

    // Configuració del servidor de Correu
    // Anar a /lib/config.php per cambiar les constants
    // Modificar a 0 per eliminar msg errors
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    return $mail;
}

function sendMail($mailbody, $mail){
    // Credencials del compte GMAIL
    // Anar a /lib/config.php per cambiar les constants
    $mail->Username = ACCOUNT_USER;
    $mail->Password = ACCOUNT_PASS;

    // Dades del correu electrònic
    $mail->SetFrom('cinetics-info@cinetics.com', 'Cinetics');
    $mail->Subject = 'Welcome new user!';
    $mail->MsgHTML($mailbody);
    //$mail->addAttachment("fitxer.pdf");
}

function emailVerification($usuari)
{
    try{
        $db=conexionBBDD();
        $sql = 'SELECT `active` FROM `users` WHERE `mail` = :mail';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':mail' => $usuari['user']));

        if($preparada && $preparada->rowCount()>0){
            $result=$preparada->fetch(PDO::FETCH_ASSOC);
            if($result['active']==1){
                emailVerificationLog($usuari);
                return true;
            }
        }
    }catch(PDOException $e)
    {
        userLogVerifyError($usuari, $e->getMessage());
    }   
}

function createGetValues($mail, &$activationCode)
{
    $getValues = '?code=';

    $randomValue = 'cinetics' . rand(10, 10000);
    $randomHash = hash('sha256', $randomValue);

    $activationCode = $randomHash;
    $getValues .= $randomHash;

    $getValues .= '&mail=';
    $getValues .= $mail;
    $getValues .= '"';

    return $getValues;
}
?>