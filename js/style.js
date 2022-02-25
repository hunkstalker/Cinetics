let nav = document.getElementById('navbar');
let centralPanel = document.getElementById('central-panel');

if (screen.width > 576) {
  nav.classList.remove('fixed-bottom');
  nav.classList.remove('justify-content-around');
} else {
  nav.classList.add('fixed-bottom');
  nav.classList.add('justify-content-around');
}

window.onresize = function () {
  if (screen.width > 576) {
    nav.classList.remove('fixed-bottom');
    nav.classList.remove('justify-content-around');
  } else {
    nav.classList.add('fixed-bottom');
    nav.classList.add('justify-content-around');
  }
}