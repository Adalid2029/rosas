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
            <!-- Visible when footer positions are fixed -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div class="show-fixed pad-rgt pull-right">
                You have <a href="index.html#" class="text-main"><span class="badge badge-danger">3</span> pending action.</a>
            </div>

            <!-- Visible when footer positions are static -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div class="hide-fixed pull-right pad-rgt">14GB of <strong>512GB</strong> Free.</div>

            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- Remove the class "show-fixed" and "hide-fixed" to make the content always appears. -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

            <p class="pad-lft">&#0169; 2017 Your Company</p>
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

    <!-- SETTINGS - DEMO PURPOSE ONLY -->
    <!--===================================================-->

    <div id="demo-set" class="demo-set">
        <div id="demo-set-body" class="demo-set-body">
            <div id="demo-set-alert"></div>
            <div class="pad-hor bord-btm clearfix">
                <div class="pull-right pad-top">
                    <button id="demo-btn-close-settings" class="btn btn-trans">
                        <i class="pci-cross pci-circle icon-lg"></i>
                    </button>
                </div>
                <div class="media">
                    <div class="media-left"></div>
                    <div class="media-body">
                        <span class="text-semibold text-lg text-uppercase">Costomize</span>
                        <p class="text-muted text-xs">Customize Nifty's layout, sidebars, and color schemes.</p>
                    </div>
                </div>
            </div>
            <div class="demo-set-content clearfix">
                <div class="col-xs-6 col-md-3">
                    <div class="pad-all">
                        <p class="text-bold text-uppercase">Layout</p>
                        <p class="text-semibold text-uppercase text-xs text-muted">Boxed Layout</p>
                        <hr class="new-section-xs" />
                        <div class="mar-btm">
                            <div class="pull-right">
                                <input id="demo-box-lay" class="toggle-switch" type="checkbox" />
                                <label for="demo-box-lay"></label>
                            </div>
                            Boxed Layout
                        </div>
                        <div class="mar-btm">
                            <div class="pull-right">
                                <input id="demo-box-img" class="toggle-switch" type="checkbox" disabled />
                                <label for="demo-box-img"></label>
                            </div>
                            Background Images
                        </div>

                        <hr class="new-section-xs bord-no" />
                        <p class="text-semibold text-uppercase text-xs text-muted">Animations</p>
                        <hr class="new-section-xs" />
                        <div class="mar-btm">
                            <div class="pull-right">
                                <input id="demo-anim" class="toggle-switch" type="checkbox" checked />
                                <label for="demo-anim"></label>
                            </div>
                            Enable Animations
                        </div>
                        <div class="mar-btm clearfix">
                            <div class="select pull-right">
                                <select id="demo-ease">
                                    <option value="effect" selected>ease (Default)</option>
                                    <option value="easeInQuart">easeInQuart</option>
                                    <option value="easeOutQuart">easeOutQuart</option>
                                    <option value="easeInBack">easeInBack</option>
                                    <option value="easeOutBack">easeOutBack</option>
                                    <option value="easeInOutBack">easeInOutBack</option>
                                    <option value="steps">Steps</option>
                                    <option value="jumping">Jumping</option>
                                    <option value="rubber">Rubber</option>
                                </select>
                            </div>
                            Transitions
                        </div>

                        <hr class="new-section-xs bord-no" />

                        <p class="text-semibold text-uppercase text-xs text-muted">Header / Navbar</p>
                        <hr class="new-section-xs" />
                        <div>
                            <div class="pull-right">
                                <input id="demo-navbar-fixed" class="toggle-switch" type="checkbox" />
                                <label for="demo-navbar-fixed"></label>
                            </div>
                            Fixed Position
                        </div>

                        <hr class="new-section-xs bord-no" />

                        <p class="text-semibold text-uppercase text-xs text-muted">Footer</p>
                        <hr class="new-section-xs" />
                        <div class="pad-btm">
                            <div class="pull-right">
                                <input id="demo-footer-fixed" class="toggle-switch" type="checkbox" />
                                <label for="demo-footer-fixed"></label>
                            </div>
                            Fixed Position
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 pos-rel">
                    <div class="row">
                        <div class="col-lg-4 bg-gray-light">
                            <div class="pad-all">
                                <p class="text-bold text-uppercase text-main">Sidebars</p>
                                <p class="text-semibold text-uppercase text-xs text-muted">Navigation</p>
                                <hr class="new-section-xs" />
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-nav-fixed" class="toggle-switch" type="checkbox" />
                                        <label for="demo-nav-fixed"></label>
                                    </div>
                                    Fixed Position
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-nav-profile" class="toggle-switch" type="checkbox" checked />
                                        <label for="demo-nav-profile"></label>
                                    </div>
                                    Widget Profil
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-nav-shortcut" class="toggle-switch" type="checkbox" checked />
                                        <label for="demo-nav-shortcut"></label>
                                    </div>
                                    Shortcut Buttons
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-nav-coll" class="toggle-switch" type="checkbox" />
                                        <label for="demo-nav-coll"></label>
                                    </div>
                                    Collapsed Mode
                                </div>

                                <div class="clearfix">
                                    <div class="pad-btm pull-right">
                                        <div class="select">
                                            <select id="demo-nav-offcanvas">
                                                <option value="none" selected disabled="disabled">-- Select Mode --</option>
                                                <option value="push">Push</option>
                                                <option value="slide">Slide in on top</option>
                                                <option value="reveal">Reveal</option>
                                            </select>
                                        </div>
                                    </div>
                                    Off-Canvas
                                </div>
                                <hr class="new-section-xs bord-no" />

                                <p class="text-semibold text-uppercase text-xs text-muted">Aside</p>
                                <hr class="new-section-xs" />
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-asd-vis" class="toggle-switch" type="checkbox" />
                                        <label for="demo-asd-vis"></label>
                                    </div>
                                    Visible
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-asd-fixed" class="toggle-switch" type="checkbox" checked />
                                        <label for="demo-asd-fixed"></label>
                                    </div>
                                    Fixed Position
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-asd-float" class="toggle-switch" type="checkbox" checked />
                                        <label for="demo-asd-float"></label>
                                    </div>
                                    Floating
                                </div>
                                <div class="mar-btm">
                                    <div class="pull-right">
                                        <input id="demo-asd-align" class="toggle-switch" type="checkbox" />
                                        <label for="demo-asd-align"></label>
                                    </div>
                                    Left Side
                                </div>
                                <div>
                                    <div class="pull-right">
                                        <input id="demo-asd-themes" class="toggle-switch" type="checkbox" />
                                        <label for="demo-asd-themes"></label>
                                    </div>
                                    Dark Version
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="demo-theme">
                                <p class="text-bold text-uppercase text-left">Color Schemes</p>
                                <hr class="new-section-xs" />
                                <div class="clearfix">
                                    <div class="col-md-6">
                                        <div class="media v-middle">
                                            <div class="media-left demo-single-theme">
                                                <a href="index.html#" class="demo-theme demo-theme-light add-tooltip" data-theme="theme-light" data-type="full" data-title="Light"></a>
                                            </div>
                                            <div class="media-body">
                                                <p class="text-semibold text-main mar-no text-uppercase text-sm">Light</p>
                                                <small class="text-muted text-xs">Completely Light theme</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="media v-middle">
                                            <div class="media-left demo-single-theme">
                                                <a href="javascript:void(0)" class="demo-theme demo-theme-dark add-tooltip disabled" data-title="Coming soon"></a>
                                            </div>
                                            <div class="media-body">
                                                <p class="text-semibold text-main mar-no text-uppercase text-sm">Dark <small class="label label-danger">Soon</small></p>
                                                <small class="text-muted text-xs">Completely Dark theme</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="new-section-xs" />
                                <div class="clearfix pad-top text-center">
                                    <div class="demo-theme-btn col-md-3 pad-ver">
                                        <p class="text-semibold text-uppercase text-xs text-muted">Header</p>
                                        <hr class="new-section-xs" />
                                        <div class="mar-btm">
                                            <img src="img/color-schemes-a.png" class="img-responsive" />
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-gray add-tooltip" data-theme="theme-gray" data-type="a" data-title="(A). Gray"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-navy add-tooltip" data-theme="theme-navy" data-type="a" data-title="(A). Navy Blue"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-ocean add-tooltip" data-theme="theme-ocean" data-type="a" data-title="(A). Ocean"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-lime add-tooltip" data-theme="theme-lime" data-type="a" data-title="(A). Lime"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-purple add-tooltip" data-theme="theme-purple" data-type="a" data-title="(A). Purple"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dust add-tooltip" data-theme="theme-dust" data-type="a" data-title="(A). Dust"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-mint add-tooltip" data-theme="theme-mint" data-type="a" data-title="(A). Mint"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-yellow add-tooltip" data-theme="theme-yellow" data-type="a" data-title="(A). Yellow"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-well-red add-tooltip" data-theme="theme-well-red" data-type="a" data-title="(A). Well Red"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-coffee add-tooltip" data-theme="theme-coffee" data-type="a" data-title="(A). Coffee"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-prickly-pear add-tooltip" data-theme="theme-prickly-pear" data-type="a" data-title="(A). Prickly pear"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dark add-tooltip" data-theme="theme-dark" data-type="a" data-title="(A). Dark"></a>
                                        </div>
                                    </div>
                                    <div class="demo-theme-btn col-md-3 pad-ver">
                                        <p class="text-semibold text-uppercase text-xs text-muted">Brand</p>
                                        <hr class="new-section-xs" />
                                        <div class="mar-btm">
                                            <img src="img/color-schemes-b.png" class="img-responsive" />
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-gray add-tooltip" data-theme="theme-gray" data-type="b" data-title="(B). Gray"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-navy add-tooltip" data-theme="theme-navy" data-type="b" data-title="(B). Navy Blue"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-ocean add-tooltip" data-theme="theme-ocean" data-type="b" data-title="(B). Ocean"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-lime add-tooltip" data-theme="theme-lime" data-type="b" data-title="(B). Lime"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-purple add-tooltip" data-theme="theme-purple" data-type="b" data-title="(B). Purple"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dust add-tooltip" data-theme="theme-dust" data-type="b" data-title="(B). Dust"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-mint add-tooltip" data-theme="theme-mint" data-type="b" data-title="(B). Mint"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-yellow add-tooltip" data-theme="theme-yellow" data-type="b" data-title="(B). Yellow"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-well-red add-tooltip" data-theme="theme-well-red" data-type="b" data-title="(B). Well red"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-coffee add-tooltip" data-theme="theme-coffee" data-type="b" data-title="(B). Coofee"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-prickly-pear add-tooltip" data-theme="theme-prickly-pear" data-type="b" data-title="(B). Prickly pear"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dark add-tooltip" data-theme="theme-dark" data-type="b" data-title="(B). Dark"></a>
                                        </div>
                                    </div>
                                    <div class="demo-theme-btn col-md-3 pad-ver">
                                        <p class="text-semibold text-uppercase text-xs text-muted">Navigation</p>
                                        <hr class="new-section-xs" />
                                        <div class="mar-btm">
                                            <img src="img/color-schemes-c.png" class="img-responsive" />
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-gray add-tooltip" data-theme="theme-gray" data-type="c" data-title="(C). Gray"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-navy add-tooltip" data-theme="theme-navy" data-type="c" data-title="(C). Navy Blue"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-ocean add-tooltip" data-theme="theme-ocean" data-type="c" data-title="(C). Ocean"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-lime add-tooltip" data-theme="theme-lime" data-type="c" data-title="(C). Lime"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-purple add-tooltip" data-theme="theme-purple" data-type="c" data-title="(C). Purple"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dust add-tooltip" data-theme="theme-dust" data-type="c" data-title="(C). Dust"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-mint add-tooltip" data-theme="theme-mint" data-type="c" data-title="(C). Mint"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-yellow add-tooltip" data-theme="theme-yellow" data-type="c" data-title="(C). Yellow"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-well-red add-tooltip" data-theme="theme-well-red" data-type="c" data-title="(C). Well Red"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-coffee add-tooltip" data-theme="theme-coffee" data-type="c" data-title="(C). Coffee"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-prickly-pear add-tooltip" data-theme="theme-prickly-pear" data-type="c" data-title="(C). Prickly pear"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dark add-tooltip" data-theme="theme-dark" data-type="c" data-title="(C). Dark"></a>
                                        </div>
                                    </div>
                                    <div class="demo-theme-btn col-md-3 pad-ver">
                                        <p class="text-semibold text-uppercase text-xs text-muted">Full Top Bar</p>
                                        <hr class="new-section-xs" />
                                        <div class="mar-btm">
                                            <img src="img/color-schemes-d.png" class="img-responsive" />
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-gray add-tooltip" data-theme="theme-gray" data-type="d" data-title="(D). Gray"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-navy add-tooltip" data-theme="theme-navy" data-type="d" data-title="(D). Navy Blue"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-ocean add-tooltip" data-theme="theme-ocean" data-type="d" data-title="(D). Ocean"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-lime add-tooltip" data-theme="theme-lime" data-type="d" data-title="(D). Lime"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-purple add-tooltip" data-theme="theme-purple" data-type="d" data-title="(D). Purple"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dust add-tooltip" data-theme="theme-dust" data-type="d" data-title="(D). Dust"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-mint add-tooltip" data-theme="theme-mint" data-type="d" data-title="(D). Mint"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-yellow add-tooltip" data-theme="theme-yellow" data-type="d" data-title="(D). Yellow"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-well-red add-tooltip" data-theme="theme-well-red" data-type="d" data-title="(D). Well Red"></a>
                                        </div>
                                        <div class="demo-justify-theme">
                                            <a href="index.html#" class="demo-theme demo-theme-coffee add-tooltip" data-theme="theme-coffee" data-type="d" data-title="(D). Coffee"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-prickly-pear add-tooltip" data-theme="theme-prickly-pear" data-type="d" data-title="(D). Prickly pear"></a>
                                            <a href="index.html#" class="demo-theme demo-theme-dark add-tooltip" data-theme="theme-dark" data-type="d" data-title="(D). Dark"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="demo-bg-boxed" class="demo-bg-boxed">
                        <div class="demo-bg-boxed-content">
                            <p class="text-semibold text-main text-lg mar-no">Background Images</p>
                            <p class="text-sm text-muted">Add an image to replace the solid background color</p>
                            <div class="row">
                                <div class="col-lg-4 text-justify">
                                    <p class="text-semibold text-main">Blurred</p>
                                    <div id="demo-blurred-bg" class="text-justify">
                                        <!--Blurred Backgrounds-->
                                    </div>
                                </div>
                                <div class="col-lg-4 text-justify">
                                    <p class="text-semibold text-main">Polygon &amp; Geometric</p>
                                    <div id="demo-polygon-bg" class="text-justify">
                                        <!--Polygon Backgrounds-->
                                    </div>
                                </div>
                                <div class="col-lg-4 text-justify">
                                    <p class="text-semibold text-main">Abstract</p>
                                    <div id="demo-abstract-bg" class="text-justify">
                                        <!--Abstract Backgrounds-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="demo-bg-boxed-footer">
                            <button id="demo-close-boxed-img" class="btn btn-primary">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="demo-set-btn" class="btn"><i class="demo-psi-gear fa-spin"></i></button>

    <!--===================================================-->
    <!-- END SETTINGS -->

    <div id="preloader"></div>
    <div id="preload"></div>
</body>

</html>