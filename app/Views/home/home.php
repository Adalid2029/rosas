<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
                </div>
                <h3 class="panel-title">Página Principal</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="col-lg-3 col-md-6">
                            <!--Tile-->
                            <!--===================================================-->
                            <div class="panel panel-primary panel-colorful">
                                <div class="pad-all text-center">
                                    <span class="text-3x text-thin"><?php echo $administrativos ?></span>
                                    <p>Administrativos</p>
                                    <i class="demo-pli-checked-user icon-lg"></i>
                                    <div style="border: 5px;border-top: 2px solid #ffffff;height:0;margin-bottom: 10px">
                                        <a href="<?= base_url('/administrativo/listarAdministrativos'); ?>" style="">
                                            <i class="fa fa-arrow-right" style="padding: 5px;color: white"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--===================================================-->
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <!--Tile-->
                            <!--===================================================-->
                            <div class="panel panel-warning panel-colorful">
                                <div class="pad-all text-center">
                                    <span class="text-3x text-thin"><?php echo $maestros ?></span>
                                    <p>Maestros</p>
                                    <i class="demo-pli-checked-user icon-lg"></i>
                                    <div style="border: 5px;border-top: 2px solid #ffffff;height:0;margin-bottom: 10px">
                                        <a href="<?= base_url("/maestro/listarMaestros") ?>" style="">
                                            <i class="fa fa-arrow-right" style="padding: 5px;color: white"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--===================================================-->
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <!--Tile-->
                            <!--===================================================-->
                            <div class="panel panel-purple panel-colorful">
                                <div class="pad-all text-center">
                                    <span class="text-3x text-thin"><?php echo $estudiantes ?></span>
                                    <p>Estudiantes</p>
                                    <i class="demo-pli-checked-user icon-lg"></i>
                                    <div style="border: 5px;border-top: 2px solid #ffffff;height:0;margin-bottom: 10px">
                                        <a href="<?= base_url("/estudiante/listarEstudiantes") ?>" style="">
                                            <i class="fa fa-arrow-right" style="padding: 5px;color: white"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--===================================================-->
                        </div>


                        <div class="col-lg-3 col-md-6">
                            <!--Tile-->
                            <!--===================================================-->
                            <div class="panel panel-dark panel-colorful">
                                <div class="pad-all text-center">
                                    <span class="text-3x text-thin"><?php echo $tutores ?></span>
                                    <p>Tutores</p>
                                    <i class="demo-pli-checked-user icon-lg"></i>
                                    <div style="border: 5px;border-top: 2px solid #ffffff;height:0;margin-bottom: 10px">
                                        <a href="<?= base_url("/tutor/listarTutor") ?>" style="">
                                            <i class="fa fa-arrow-right" style="padding: 5px; color: white"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <!--===================================================-->
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
