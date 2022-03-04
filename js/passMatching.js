function check() {
  var valuePsw = document.getElementById('psw').value;
  var valuePsw2 = document.getElementById('psw2').value;

  if (valuePsw == valuePsw2) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('psw').style.borderColor = 'white';
    document.getElementById('psw2').style.borderColor = 'white';
    document.getElementById('message').innerHTML = 'Matching passwords';
  } else if (valuePsw != valuePsw2) {
    document.getElementById('message').style.color = 'red';
    document.getElementById('psw').style.borderColor = 'red';
    document.getElementById('psw2').style.borderColor = 'red';
    document.getElementById('message').innerHTML = 'Not matching passwords';
  }
}