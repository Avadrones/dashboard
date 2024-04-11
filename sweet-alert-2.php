<?php

session_start();

//ISSET = VERIFICA SE AS VARIAVEIS FORAM CRIADAS
if  (isset($_SESSION["tipo"]) && isset($_SESSION["msg"])) {
    echo "
    <script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            positition: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        Toast.fire({
            icon: '".$_SESSION["tipo"]."',
            title: '".$_SESSION["msg"]."'
        }):

    });
    </script>
    ";
}


?>