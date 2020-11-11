<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Unidad Educativa | Las Rosas</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('plugins/font-awesome/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="assets/iniciativa/css/jquery.toast.css">

    <link href="<?php echo base_url('css/bootstrap.min.css') ?>" rel="stylesheet" />

    <link href="<?php echo base_url('css/login.css') ?>" rel="stylesheet" />

    <link rel="shortcut icon" href="assets/iniciativa/img/logo-mmaa.ico" />

</head>

<body>

<div class="oscurecer"></div>

<div class="contenido">

    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="index.php">
            <img alt="logo" class="logo" src="assets/iniciativa/img/logo1.png" style="margin-top: 15px;">
        </a>
    </div>
    <!-- END LOGO -->

    <h4 class="form-title font-blue" style="text-align: center;">INICIAR SESIÓN</h4>
    <br>

    <div class="alert alert-danger hide" id="error_disp">
        <span id="mensaje"> </span>
    </div>

    <form action="<?php echo base_url('/auth/authenticate');?>" method="POST">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                    <input class="form-control form-control-solid placeholder-no-fix"
                           type="text" autocomplete="off" placeholder="Usuario..." name="username" id="username" required />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-key"></i>
                        </span>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password"
                           autocomplete="off" placeholder="Contraseña..." name="password" id="password" required />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="g-recaptcha" data-sitekey="6Lfp5q4ZAAAAADw5arMRXZeT4mrOQiQkbHocI16o"></div>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-info btn-block" type="submit" id="login" class="btn blue">
                <i class="fa fa-check"></i>
                Iniciar Sesión
            </button>

        </div>
    </form>
    <hr>
    <div class="copyright" style="text-align: center; color: gray;"> 2020 © Unidad Educativa "Las Rosas".</div>
</div>

<!-- Recaptcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>
