function validateId(Name) {
  let re = /^[a-zA-Z]{3,8}$/;
  // console.log(re.test(Name))
  return re.test(Name);
}


function isSetId(name_f) {
  isPass = true;
  name_f.style.border = '1px solid black';
  name_f.nextElementSibling.style.color="black";

  name_f.nextElementSibling.innerHTML = "";
  if (name_f.value.length < 3 || !validateId(name_f.value)) {
    isPass = false;
    name_f.style.border = '1px solid red';
    name_f.nextElementSibling.style.color = "red"; 
    name_f.nextElementSibling.innerHTML = "請填寫正確的帳號/暱稱(請輸入英文)";
  }
  return isPass;

}

