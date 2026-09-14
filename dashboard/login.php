<?php
require_once 'clases/class.Funciones.php';
$f = new Funciones();
$navegador = $f->navegador();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Acceso al panel de Invitaciones Digitales">
    <meta name="theme-color" content="#f7f5f0">
    <title>Acceso · Invitaciones Digitales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/login.css?v=2">
</head>
<body>
    <div class="preloader" aria-hidden="true"><div class="login-loader"></div></div>

    <main class="auth-wrapper">
        <div class="login-shell">
            <section class="login-visual" aria-label="Invitaciones para momentos especiales">
                <img src="images/boda.jpg" alt="Celebración de un momento especial">
                <div class="login-visual-shade"></div>
                <div class="visual-brand">
                    <span class="brand-heart"><i class="mdi mdi-heart-outline"></i></span>
                    <span><strong>INVITACIONES</strong><em>Digitales</em></span>
                </div>
                <blockquote>Las mejores historias también se comparten en digital.</blockquote>
            </section>

            <section class="login-panel">
                <div class="mobile-brand" aria-label="Invitaciones Digitales">
                    <span class="brand-heart"><i class="mdi mdi-heart-outline"></i></span>
                    <span><strong>INVITACIONES</strong><em>Digitales</em></span>
                </div>

                <div class="login-copy">
                    <p class="login-eyebrow">Panel administrativo</p>
                    <h1>Bienvenido</h1>
                    <p>Ingresa para administrar tu evento, invitados y confirmaciones.</p>
                </div>

                <form class="login-form" action="#!" autocomplete="on">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <div class="input-wrap"><i class="mdi mdi-account-outline" aria-hidden="true"></i><input id="usuario" class="form-control" type="text" name="usuario" autocomplete="username" placeholder="Escribe tu usuario" autofocus></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrap"><i class="mdi mdi-lock-outline" aria-hidden="true"></i><input id="password" class="form-control" type="password" name="password" autocomplete="current-password" placeholder="Escribe tu contraseña"><button id="togglePassword" class="password-toggle" type="button" aria-label="Mostrar contraseña"><i class="mdi mdi-eye-outline"></i></button></div>
                    </div>

                    <div class="alert alert-danger" role="alert" style="display:none"></div>
                    <div class="alert alert-success" role="alert" style="display:none"></div>
                    <div id="validar"><button class="btn login-btn" type="button">Iniciar sesión <i class="mdi mdi-arrow-right"></i></button></div>
                </form>

                <div class="login-meta"><span>Acceso seguro</span><span>Invitaciones Digitales</span></div>
            </section>
        </div>
    </main>

    <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="loginModalTitle">Revisa tus datos</h5><button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div></div></div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/fn_Login.js?v=2"></script>
    <script src="js/fn_Jquery.js"></script>
    <script>
        $('.preloader').fadeOut();
        $('#togglePassword').on('click', function () {
            var input = $('#password');
            var visible = input.attr('type') === 'text';
            input.attr('type', visible ? 'password' : 'text');
            $(this).attr('aria-label', visible ? 'Mostrar contraseña' : 'Ocultar contraseña');
            $(this).find('i').toggleClass('mdi-eye-outline mdi-eye-off-outline');
        });
    </script>
</body>
</html>
