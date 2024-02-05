
// object array 
var sort = (function () {  
    function sortArray(data_f,sortBase) {
        data_f = data_f.sort(function (a, b) {
            return a[sortBase] > b[sortBase] ? 1 : -1;
           });
           return data_f
    }
    return {
        sortArray: sortArray
  };
  })()
  