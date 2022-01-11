function validateForm() {

    var userField = document.forms["login-form"]["user"].value;
    var pswField = document.forms["login-form"]["psw"].value;

    var elementUser = document.querySelector(".lateral-panel input[type='text']");
    var elementPass = document.querySelector(".lateral-panel input[type='password']");

    if (userField == null || userField == "" && pswField == null || pswField == "") {
        elementUser.classList.add('mystyle');
        elementPass.classList.add('mystyle');
    }else if(userField == null || userField == ""){
        elementUser.classList.add('mystyle');
    } else if (pswField == null || pswField == "") {
        elementPass.classList.add('mystyle');
    }
}