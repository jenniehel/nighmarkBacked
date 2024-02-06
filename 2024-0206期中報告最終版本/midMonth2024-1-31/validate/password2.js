
function validatePassword(password) {
  //     至少有一個數字
  // 至少有一個小寫英文字母
  // 至少有一個大寫英文字母
  // 字串長度在 5 ~ 30 個字母之間
  let re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,30}$/;
  // console.log(re.test)
  return re.test(password.value);
}

function issetPassword(password_f) {
  isPass = true;
  resetPdata(password_f);
  if (password_f.value.length < 6 || !validatePassword(password_f)) {
    isPass = false;
    password_f.style.border = '1px solid red';
    password_f.nextElementSibling.style.color = "red";
    password_f.nextElementSibling.innerHTML = "至少一個大、小寫英文、中文，且至少6個字喔!!!";
  }
  return isPass;

}
function  PasswordErr(password_f) {

    password_f.nextElementSibling.style.color = "red";
    password_f.nextElementSibling.innerHTML = "密碼不一致";

}


function resetPdata(password_f) {
  // 沒有外觀的表單 
  console.log("dddd")
  password_f.style.border = "1px solid #ccc";
  password_f.nextElementSibling.style.color = "black";
  password_f.nextElementSibling.innerHTML = "";
}
