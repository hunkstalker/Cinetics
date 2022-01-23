<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../vendor/autoload.php';

function sendEmailNewUser($email, $urlActivationCode)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mailbody = '<h1 style="font-family: Brush Script MT, Brush Script Std, cursive;">Cinetics</h1>
            <h3>Thank you very much for joining our community!</h3>
            <h4>Click on the link below to verify your email address and finish the registration process:</h4>
            <a href="localhost/php-gon/Ejercicios/Cinetics/lib/verifyEmail.php'.$urlActivationCode.
            '">Click here</a>';

    // Denis: <a href="localhost/php-gon/Ejercicios/Cinetics/lib/verifyEmail.php'.$urlActivationCode.
    // Aina:  <a href="http://localhost/Cinetics/lib/verifyEmail.php'.createGetValues($email,$urlActivationCode).

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg errors
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    //Credencials del compte GMAIL
    $mail->Username = 'cineticsdenai@gmail.com';
    $mail->Password = 'educem2122';

    //Dades del correu electrònic
    $mail->SetFrom('cinetics-info@cinetics.com', 'Cinetics');
    $mail->Subject = 'Welcome new user!';
    $mail->MsgHTML($mailbody);
    //$mail->addAttachment("fitxer.pdf");

    //Destinatari
    $address = $email;
    $mail->AddAddress($address, 'Verify your email');

    //Enviament
    $mail->Send();
    // $result = $mail->Send();
    // Guardaré esto en el log
    // if ($result) {
    //     echo '<script>alert("Correu enviat")</script>';
    // }
    // echo '<script>alert("Error: ' . $mail->ErrorInfo . '")</script>';
}

function sendEmailResetPsw($email, $urlActivationCode)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mailbody = '<h1 style="font-family: Brush Script MT, Brush Script Std, cursive;">Cinetics</h1>
            <h3>Amo a cambiar el password</h3>
            <h4>Haz click en el enlace de abajo para cambiar la contraseña:</h4>
            <a href="localhost/php-gon/Ejercicios/Cinetics/lib/newPsw.php'.$urlActivationCode.
            '">Click here</a>';

    // Denis: <a href="localhost/php-gon/Ejercicios/Cinetics/lib/newPsw.php'.$urlActivationCode.
    // Aina:  <a href="http://localhost/Cinetics/lib/newPsw.php'.createGetValues($email,$urlActivationCode).

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    //Credencials del compte GMAIL
    $mail->Username = 'cineticsdenai@gmail.com';
    $mail->Password = 'educem2122';

    //Dades del correu electrònic
    $mail->SetFrom('cinetics-info@cinetics.com', 'Cinetics');
    $mail->Subject = 'Welcome new user!';
    $mail->MsgHTML($mailbody);
    //$mail->addAttachment("fitxer.pdf");

    //Destinatari
    $address = $email;
    $mail->AddAddress($address, 'Verify your email');

    //Enviament
    $mail->Send();
    // $result = $mail->Send();
    // Guardaré esto en el log
    // if ($result) {
    //     echo '<script>alert("Correu enviat")</script>';
    // }
    // echo '<script>alert("Error: ' . $mail->ErrorInfo . '")</script>';
}

function emailVerification($usuari)
{
    try{
        $db=conexionBBDD();
        $sql = 'SELECT `active` FROM `users` WHERE `mail` = :mail';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':mail' => $usuari['user']));

        // HAY QUE TESTEAR ESTO, QUERÍA EVITAR EL USO DE FOREACH AHORA ES MÁS PRO
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