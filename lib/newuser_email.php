<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';


function sendEmailNewUser($email) {

    $mail = new PHPMailer();
    $mail->IsSMTP();

	$mailbody = '<h1 style="font-family: Brush Script MT, Brush Script Std, cursive;">Cinetics</h1>
				<h3>Thank you very much for joining our community!</h3>
				<h4>Click on the link below to verify your email address and finish the registration process:</h4>
				<a href="http://localhost/Cinetics/web/newmember.html'.createGetValues($email).
				'">Click here</a>';

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    
    //Credencials del compte GMAIL
    $mail->Username = 'cineticsdenai@gmail.com';
    $mail->Password = 'educem2122';

    //Dades del correu electrònic
    $mail->SetFrom('cinetics-info@cinetics.com','Patatamix');
    $mail->Subject = 'Welcome new user!';
    $mail->MsgHTML($mailbody);
    //$mail->addAttachment("fitxer.pdf");
    
    //Destinatari
    $address = 'aina.cat95@gmail.com';
    $mail->AddAddress($address, 'New User');

    //Enviament
    $result = $mail->Send();
    if(!$result){
        echo '<script>alert("Error: '.$mail->ErrorInfo.'")</script>';
    }else{
        echo '<script>alert("Correu enviat")</script>';
    }
}

function createGetValues($email){

    $getValues = '?code=';

    $randomValue = 'cinetics'.rand(10,10000);
    $randomHash = hash('sha256',$randomValue);

    $getValues .= $randomHash;

    $getValues .= '&mail=';
    $getValues .= $email;
    $getValues .= '"';
    
    return $getValues;
}