<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once './vendor/autoload.php';
require_once 'connectionDB.php';
require_once 'logs.php';

function registroUsuario($usuari, &$emailDuplicat, &$usuariDuplicat)
{
    $emailDuplicat = true;
    $usuariDuplicat = true;
    try
    {
        $mail = $usuari['email'];
        $username = $usuari['username'];
        $hash = password_hash($usuari['pss'], PASSWORD_BCRYPT);
        $fname = $usuari['fname'];
        $sname = $usuari['sname'];

        $db = conexionBBDD();

        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        try {
            $preparada1 = $db->prepare($sql);
            $preparada1->execute(array(':mail' => $mail));
        } catch (PDOException $e) {
            fatalError("preparada1", $e->getMessage());
        }

        $sql = 'SELECT username FROM `users` WHERE `username` = :username';
        try {
            $preparada2 = $db->prepare($sql);
            $preparada2->execute(array(':username' => $username));
        } catch (PDOException $e) {
            fatalError("preparada2", $e->getMessage());
        }

        if ($preparada1->rowCount() == 0) {
            $emailDuplicat = false;
        }

        if ($preparada2->rowCount() == 0) {
            $usuariDuplicat = false;
        }

        if ($emailDuplicat === false && $usuariDuplicat === false) {

            $activationCode="";
            // Todo es correcto, así que podemos guardar todos los datos en la bbdd
            $urlActivationCode = createGetValues($mail, $activationCode);
            // Nos guardamos el mail y el TOKEN del usuario en su sesión para no tener que consultar de nuevo en bbdd a la hora de verificar la cuenta
            session_start();
            $_SESSION['username']=$username;
            $_SESSION['mail']=$mail;
            $_SESSION['userStatusCode']=3;

            // Registramos el usuario, se registará como inactivo y guardamos el TOKEN en bbdd
            $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`,`activationCode`)
                    VALUES(:mail, :username, :pass, :fname, :sname, :activationCode)";
            $preparada3 = $db->prepare($sqlinsert);
            $preparada3->execute(array(':mail' => $mail, ':username' => $username, ':pass' => $hash,
                ':fname' => $fname, ':sname' => $sname, ':activationCode' => $activationCode));
            
            // Mandamos el mail con el TOKEN para que el usuario haga la verificación
            sendEmailNewUser($mail, $urlActivationCode);
            return true;
        }
        return false;

    } catch (PDOException $e) {
        userRegisterError($usuari, $e->getMessage());
    }
}

function sendEmailNewUser($email, $urlActivationCode)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mailbody = '<h1 style="font-family: Brush Script MT, Brush Script Std, cursive;">Cinetics</h1>
            <h3>Thank you very much for joining our community!</h3>
            <h4>Click on the link below to verify your email address and finish the registration process:</h4>
            <a href="localhost/php-gon/Ejercicios/Cinetics/lib/verifyEmail.php' . $urlActivationCode .
            '">Click here</a>';

    // Denis: <a href="localhost/php-gon/Ejercicios/Cinetics/lib/verifyEmail.php' . $activationCode .
    // Aina:  <a href="http://localhost/Cinetics/lib/verifyEmail.php'.createGetValues($email,$activationCode) .

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

function sendEmailResetPsw($email, $urlActivationCode)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mailbody = '<h1 style="font-family: Brush Script MT, Brush Script Std, cursive;">Cinetics</h1>
            <h3>Thank you very much for joining our community!</h3>
            <h4>Click on the link below to verify your email address and finish the registration process:</h4>
            <a href="http://localhost/Cinetics/lib/verifyEmail.php'.createGetValues($email,$activationCode) .
            '">Click here</a>';

    // Denis: <a href="localhost/php-gon/Ejercicios/Cinetics/lib/verifyEmail.php' . $activationCode .
    // Aina:  <a href="http://localhost/Cinetics/lib/verifyEmail.php'.createGetValues($email,$activationCode) .

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