<?php
    require_once('./lib/conexiones.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(count($_POST)==3){
            if(isset($_POST['user']) && isset($_POST['pass'])){
                $userPOST = strtolower(filter_input(INPUT_POST, 'user'));
                $passPOST = filter_input(INPUT_POST, 'pass');

                verificarUsuario($userPOST, $passPOST);
            }else{
                echo 'Error isset';
            }
        }else if(count($_POST)==4){
            $userPOST = strtolower(filter_input(INPUT_POST, 'user'));
            $emailPOST = strtolower(filter_input(INPUT_POST, 'email'));
            $passSignUpOnePOST = filter_input(INPUT_POST, 'passSignUpOne');
            $passSignUpRepPOST = filter_input(INPUT_POST, 'passSignUpRep');
            
            if($passSignUpOnePOST==$passSignUpRepPOST){
                $hashPass=password_hash($passSignUpOnePOST, PASSWORD_DEFAULT);
                $passSignUpRepPOST='';
                $passSignUpOnePOST='';

                transaction($emailPOST, $userPOST, $hashPass);
            }else{
                $passSignUpRepPOST='';
                $passSignUpOnePOST='';
                echo 'Las contraseñas no coinciden';
            }
        }else{
            echo 'Faltan campos que rellenar';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinematics</title>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="col-xs-4 col-md-6 col-lg-5 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                    <div class="login-snip"> <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Login</label> <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
                        <div class="login-space">
                            <form class="login" id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <div class="group">
                                    <label for="user" class="label">Username</label>
                                    <input name="user" type="text" id="user" class="input" placeholder="Enter your username"> </div>
                                <div class="group">
                                    <label for="pass" class="label">Password</label>
                                    <input name="pass" type="password" id="pass" class="input" data-type="password" placeholder="Enter your password"> </div>
                                <div class="group">
                                    <input name="check" type="checkbox" id="check" class="check" checked>
                                    <label for="check"><span class="icon"></span> Keep me Signed in</label></div>
                                
                                <div class="group"><a type="submit" name="action" class="btn" onclick="document.getElementById('login').submit();">
                                    <svg width="358" height="62">
                                        <defs><linearGradient id="grad1"><stop offset="0%" stop-color="#FF8282"/><stop offset="100%" stop-color="#E178ED" /></linearGradient></defs>
                                        <rect x="5" y="5" rx="25" fill="none" stroke="url(#grad1)" width="348" height="50"></rect></svg>
                                        <span>login</span>
                                    </a></div>

                                <div class="hr"></div>
                                <div class="foot"> <a href="#">Forgot Password?</a> </div>
                            </form>

                            <form class="sign-up-form" id="sign-up-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <div class="group">
                                    <label for="user" class="label">Username</label>
                                    <input name="user" type="text" id="user" class="input" placeholder="Enter your Username"> </div>
                                <div class="group">
                                    <label for="passSignUpOne" class="label">Password</label>
                                    <input name="passSignUpOne" type="password" id="pass" class="input" data-type="password" placeholder="Create your password"> </div>
                                <div class="group">
                                    <label for="passSignUpRep" class="label">Repeat Password</label>
                                    <input name="passSignUpRep" type="password" id="pass" class="input" data-type="password" placeholder="Repeat your password"> </div>
                                <div class="group">
                                    <label for="email" class="label">Email Address</label>
                                    <input name="email" type="email" id="email" class="input" placeholder="Enter your email address"> </div>

                                <div class="group"><a type="submit" name="action" class="btn" onclick="document.getElementById('sign-up-form').submit();">
                                <svg width="358" height="62">
                                    <defs><linearGradient id="grad1"><stop offset="0%" stop-color="#FF8282"/><stop offset="100%" stop-color="#E178ED" /></linearGradient></defs>
                                    <rect x="5" y="5" rx="25" fill="none" stroke="url(#grad1)" width="348" height="50"></rect></svg>
                                    <span>sign up</span>
                                </a></div>

                                <div class="hr"></div>
                                <div class="foot"> <label for="tab-1">Already Member?</label> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>