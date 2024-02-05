
function validateName(Name) {
  let re = /^[\u4E00-\u9FA5A-Za-z\s]+(·[\u4E00-\u9FA5A-Za-z]+)*$/g;
  return re.test(Name);
  // return true
}


function isSetName(name_f) { 
  isPass = true;
  name_f.style.border = '1px solid black '; 
  name_f.nextElementSibling.style.color="black";

  name_f.nextElementSibling.innerHTML = "";
  if (name_f.value.length < 2 || !validateName(name_f.value) ) { 
    isPass = false;
    name_f.style.border = '1px solid red'; 
    name_f.nextElementSibling.style.color="red";
    name_f.nextElementSibling.innerHTML = "請填寫正確的姓名!!!";
    
  } 
  return isPass;
}

 