
// object array 
var url = (function () {  
    function getUrl() {
        // 取得url
        let urlParams = new URLSearchParams(window.location.search);
        console.log(urlParams.has('q')); // true
        console.log(urlParams.get('txt')); // "abc"
        console.log(urlParams.getAll('action')); // ["abc"]
        console.log(urlParams.toString()); // "q=1234&txt=abc"
        console.log(urlParams.append('page', '1')); // "q=1234&txt=abc&page=1"
        // urlParams.set('order', 'date');
        
    }
    return {
        sortArray: getUrl
  };
  })()
  