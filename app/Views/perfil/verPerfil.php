<div id="content-container">
    <div id="page-head">

    </div>
    <!--Page content-->
    <!--===================================================-->
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="fixed-fluid">
                    <div class="fixed-md-200 pull-sm-left fixed-right-border">

                        <!-- Simple profile -->
                        <div class="text-center">
                            <div class="pad-ver">
                                <?php
                                if ($user[0]["sexo"] == "M") {
                                    echo '<img src="' . base_url('img/profile-photos/1.png') . '" class="img-lg img-circle" alt="Profile Picture">';
                                } else {
                                    echo '<img src="' . base_url('img/profile-photos/6.png') . '" class="img-lg img-circle" alt="Profile Picture">';
                                }
                                ?>

                            </div>
                            <h4 class="text-lg text-overflow mar-no" id="perfil_nombre"><?= $user[0]["nombres"] . " " . $user[0]["paterno"]; ?></h4>
                            <p class="text-sm text-muted" id="perfil_persona">Director</p>

                            <div class="pad-ver btn-groups">
                                <a href="#" class="btn btn-icon demo-pli-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body"></a>
                                <a href="#" class="btn btn-icon demo-pli-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body"></a>
                                <a href="#" class="btn btn-icon demo-pli-google-plus icon-lg add-tooltip" data-original-title="Google+" data-container="body"></a>
                                <a href="#" class="btn btn-icon demo-pli-instagram icon-lg add-tooltip" data-original-title="Instagram" data-container="body"></a>
                            </div>
                        </div>
                        <hr>
                        <!-- Profile Details -->
                        <p class="pad-ver text-main text-sm text-uppercase text-bold">Acerca de mí</p>
                        <p><i class="demo-pli-map-marker-2 icon-lg icon-fw" id="perfil_domicilio"></i><?= $user[0]["domicilio"] ?></p>
                        <p><a href="#" class="btn-link"><i class="demo-pli-internet icon-lg icon-fw"></i> https://www.rosas.com</a></p>
                        <p><i class="demo-pli-old-telephone icon-lg icon-fw" id="perfil_telefono"></i><?= $user[0]["telefono"] ?></p>

                    </div>

                    <div class="fluid">
                        <div class="text-right">
                            <button class="btn btn-default">Información del perfil</button>
                        </div>
                        <!-- BEGIN PROFILE CONTENT -->
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <hr>
                                                <span class="caption-subject font-blue-madison bold uppercase"></span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tab_1_3" data-toggle="tab"><i class="fa fa-key"></i> Cambiar contraseña</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- CHANGE PASSWORD TAB -->
                                                <div class="tab-pane active" id="tab_1_3">
                                                    <form id="frm_cambiar_password" method="post">

                                                        <div class="form-group">
                                                            <label class="control-label" for="password_actual">Contraseña actual <span style="color: red;">(*)</span> : </label>
                                                            <input type="password" class="form-control" name="password_actual" id="password_actual" required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label" for="password_nuevo">Nueva Contraseña <span style="color: red;">(*)</span> : </label>
                                                            <input type="password" class="form-control" name="password_nuevo" id="password_nuevo" required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label" for="confirmar_password">Confirmar Contraseña <span style="color: red;">(*)</span> : </label>
                                                            <input type="password" class="form-control" name="confirmar_password" id="confirmar_password" required />
                                                        </div>

                                                        <div class="margin-top-10">
                                                            <button class="btn btn-primary" type="submit"> Cambiar Contraseña </button>
                                                            <button type="reset" class="btn default"> Limpiar </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- END CHANGE PASSWORD TAB -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE CONTENT -->
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    // Cambiar password
    $('#frm_cambiar_password').on("submit", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            type: "POST",
            url: "/perfil/cambiar_password",
            data: $("#frm_cambiar_password").serialize(),
            dataType: "JSON"
        }).done(function(response) {
            if (typeof response.pass !== "undefined") {
                mensajeAlert("warning", response.pass, "Advertencia");
                $("#password_actual").val("");
                $('#password_actual').focus();
            }

            if (typeof response.rep !== "undefined") {
                mensajeAlert("warning", response.rep, "Advertencia");
                $('#confirmar_password').val("");
                $("#confirmar_password").focus();
            }

            if (typeof response.success !== "undefined") {
                mensajeAlert("success", response.success, "Exito");
            }

            if (typeof response.error !== "undefined") {
                mensajeAlert("error", response.error, "Error");
            }

        });
    });
    // fin script
</script>
