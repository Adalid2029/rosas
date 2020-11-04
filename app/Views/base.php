<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rosas</title>
    <!--Open Sans Font [ OPTIONAL ]-->
    <link href="<?php echo base_url('css/opensans.css') ?>" rel="stylesheet" />
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url('css/bootstrap.min.css') ?>" rel="stylesheet" />
    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="<?php echo base_url('css/nifty.min.css') ?>" rel="stylesheet" />
    <!--Nifty Premium Icon [ DEMONSTRATION ]-->
    <link href="<?php echo base_url('css/demo/nifty-demo-icons.min.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('css/animate.min.css') ?>" rel="stylesheet" />
    <!--Demo [ DEMONSTRATION ]-->
    <link href="<?php echo base_url('css/demo/nifty-demo.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('plugins/font-awesome/css/font-awesome.min.css') ?>" />
    <!--Morris.js [ OPTIONAL ]-->
    <link href="<?php echo base_url('plugins/morris-js/morris.min.css') ?>" rel="stylesheet" />
    <!--Magic Checkbox [ OPTIONAL ]-->
    <link href="<?php echo base_url('plugins/magic-check/css/magic-check.min.css') ?>" rel="stylesheet" />
    <!--Bootstrap Validator [ OPTIONAL ]-->
    <link href="<?php echo base_url('plugins/bootstrap-validator/bootstrapValidator.min.css') ?>" rel="stylesheet" />
    <!--DataTables [ OPTIONAL ]-->
    <link href="<?php echo base_url('plugins/datatables/media/css/dataTables.bootstrap.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('plugins/select2/css/select2.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('plugins/sweetalert/sweetalert.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('plugins/chosen/chosen.min.css') ?>" />
    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="<?php echo base_url('plugins/pace/pace.min.css') ?>" rel="stylesheet" />


    <script src="<?php echo base_url('plugins/pace/pace.min.js') ?>"></script>
    <!--jQuery [ REQUIRED ]-->
    <script src="<?php echo base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/rosas.js') ?>"></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="<?php echo base_url('js/bootstrap.min.js') ?>"></script>
    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="<?php echo base_url('js/nifty.min.js') ?>"></script>
    <!--Demo script [ DEMONSTRATION ]-->
    <script src="<?php echo base_url('js/demo/nifty-demo.min.js') ?>"></script>
    <!--Bootstrap Wizard [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') ?>"></script>
    <!--Bootstrap Validator [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/bootstrap-validator/bootstrapValidator.min.js') ?>"></script>
    <!--DataTables [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/datatables/media/js/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('plugins/datatables/media/js/dataTables.bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') ?>"></script>
    <!--Masked Input [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/masked-input/jquery.maskedinput.min.js') ?>"></script>
    <!--Morris.js [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/morris-js/morris.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/morris-js/raphael-js/raphael.min.js') ?>"></script>
    <!--Sparkline [ OPTIONAL ]-->
    <script src="<?php echo base_url('plugins/sparkline/jquery.sparkline.min.js') ?>"></script>
    <!--Specify page [ SAMPLE ]-->
    <script src="<?php echo base_url('plugins/sweetalert/sweetalert.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/chosen/chosen.jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/bootstrap-select/bootstrap-select.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/momentjs/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/bootstrap-datepicker/bootstrap-datepicker.es.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/select2/js/select2.min.js') ?>"></script>
    <script src="<?php echo base_url('plugins/disableautofill/jquery.disableAutoFill.min.js') ?>"></script>
    <script src="<?php echo base_url('js/wow.min.js') ?>"></script>
    <script src="<?php echo base_url('js/demo/dashboard.js') ?>"></script>
    <link href="<?php echo base_url('img/favicon.ico') ?>" rel="shortcut icon" />
    <link href="<?php echo base_url('img/favicon.png') ?>" rel="icon" />
    <link href="<?php echo base_url('img/favicon.png') ?>" rel="apple-touch-icon" />
</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
    <div id="container" class="effect aside-float aside-bright mainnav-lg navbar-fixed footer-fixed wow fadeIn">
        <!--NAVBAR-->
        <!--===================================================-->
        <?= $header ?>
        <!--===================================================-->
        <!--END NAVBAR-->

        <div class="boxed">
            <div class="content">
                <?= $content ?>
            </div>
            <!--MAIN NAVIGATION-->
            <!--===================================================-->
            <?= $menu ?>
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->
        </div>

        <!-- FOOTER -->
        <!--===================================================-->
        <footer id="footer">
            <p class="pad-lft">&#0169; 2020 Colegio Las Rosas, Todos los derechos reservados.</p>
        </footer>
        <!--===================================================-->
        <!-- END FOOTER -->

        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
    <div id="preloader"></div>
    <div id="preload"></div>
</body>

</html>
