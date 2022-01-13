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

var checkPass = function() {
    if (document.getElementById('password').value ==
      document.getElementById('confirm_password').value) {
      document.getElementById('message').style.color = 'green';
      document.getElementById('message').innerHTML = 'matching';
    } else {
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'not matching';
    }
  }