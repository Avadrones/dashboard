<?php

session_start();

var_dump($_SESSION);

//ISSET = VERIFICA SE AS VARIAVEIS FORAM CRIADAS
if  (isset($_SESSION["tipo"]) && isset($_SESSION["title"]) &&isset($_SESSION["msg"])) {
    echo "
    <script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        Toast.fire({
            icon: '".$_SESSION["tipo"]."',
            title: '".$_SESSION["title"]."',
            text: '".$_SESSION["msg"]."'
        });

    });
    </script>
    ";

    unset($_SESSION["tipo"]);
    unset($_SESSION["title"]);
    unset($_SESSION["msg"]);
}


?>