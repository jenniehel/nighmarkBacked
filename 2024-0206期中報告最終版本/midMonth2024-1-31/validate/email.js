
function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  return re.test(email.value);
}

function isSetEmail(email_f) {
  email_f.style.border = '1px solid black';
  email_f.nextElementSibling.innerHTML = "";
  isPass = true;
  if (email_f.value.length < 2 || !validateEmail(email_f)) {
    isPass = false;
    email_f.style.border = '1px solid red';
    email_f.nextElementSibling.style.color = "red";
    email_f.nextElementSibling.innerHTML = "信箱有誤，請重新輸入";
  } else {
    email_f.style.border = '1px solid black';
    email_f.nextElementSibling.style.color = "black";

    email_f.nextElementSibling.innerHTML = "";
  }
  return isPass;
}



function changeEmail(email_f) { 
  email_f.style.border = '1px solid red';
  email_f.nextElementSibling.style.color = "red";
  email_f.nextElementSibling.innerHTML = "信箱已存在，請重新輸入";

  return false;
}
function resetEmail(email_f) {
  email_f.style.border = '1px solid black';
  email_f.nextElementSibling.innerHTML = "";
}
