var feature = (function () {



  function resetData(data_f) {
    // 沒有外觀的表單 
    data_f.style.border = "1px solid black";
    data_f.nextElementSibling.style.color = "black";

    data_f.nextElementSibling.innerHTML = "";
  }
  return {
    resetData: resetData
};
})()
