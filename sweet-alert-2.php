<?php

session_start();

//ISSET = VERIFICA SE AS VARIAVEIS FORAM CRIADAS
if ($_SESSION["tipo"]) && isset($_SESSION["msg"]) {
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
            icon: 'info',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        }):

    });
    </script>
    ";
}


?>