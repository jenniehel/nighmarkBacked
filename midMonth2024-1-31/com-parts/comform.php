<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
     

        .alert {
            display: none;
            position: fixed !important;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            width: 30%; 

        }

        .fa {
            margin-right: .5em;
        }
    </style>
</head>

<body>
    <!-- <button type="button" class="btn btn-success sendButton" onclick="isSusccess('got')">Success</button> -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <p class="isSusccess" id="isSusccess"></p>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(".alert").hide('medium');

    function isSusccess(text) {
        document.querySelector("#isSusccess").innerHTML = text;
        $(".alert").show('medium');
        setTimeout(function() {
            $(".alert").hide('medium');
        }, 5000);
    }

    // $(".sendButton .close").click(function(){
    //     $(".alert").hide('medium');
    // });
</script>

</html>