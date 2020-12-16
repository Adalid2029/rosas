<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-danger-basic btn-active-success" id="imprimir_administrativo" >
                        <i class="fa fa-file-pdf-o"></i>
                        Imprimir
                    </button>

                    <button class="btn btn-success btn-active-success" id="agregar_administrativo">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Administrativos</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_administrativo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Id adm</th>
                            <th>CI</th>
                            <th>Nombres y Apellidos</th>
                            <th>Correo</th>
                            <th>Fecha Nac.</th>
                            <th>Telefono</th>
                            <th>Sexo</th>
                            <th>Cargo</th>
                            <th>Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro administrativo -->
<div class="modal fade" id="agregar-administrativo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-administrativo-header" class="modal-header">
                <h5 id="agregar-administrativo-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-administrativo-body" class="modal-body">
                <form id="frm_agregar_administrativo" method="post">

                    <div class="form-group row">
                        <label for="ci" class="col-md-8 col-form-label">CI: <span style="color: red;">(*)</span></label>
                        <label for="exp" class="col-md-4 col-form-label">EXP: <span style="color: red;">(*)</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="ci" id="ci" placeholder="ci..." required>
                        </div>
                        <div class="col-md-4">
                            <select name="exp" id="exp" class="form-control" required>
                                <option value="">-- Expedido en --</option>
                                <option value="LP">LP</option>
                                <option value="OR">OR</option>
                                <option value="PT">PT</option>
                                <option value="TJ">TJ</option>
                                <option value="PD">PD</option>
                                <option value="BE">BE</option>
                                <option value="SC">SC</option>
                                <option value="CB">CB</option>
                                <option value="CH">CH</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="nombre" class="col-md-12 col-form-label">Nombre: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre..." required>
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="paterno" class="col-md-12 col-form-label">Paterno: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" name="paterno" id="paterno" class="form-control" placeholder="Apellido paterno..." required>
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="materno" class="col-md-12 col-form-label">Materno: </label>
                        <div class="col-md-12">
                            <input type="text" name="materno" id="materno" class="form-control" placeholder="Apellido materno...">
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="correo" class="col-md-12 col-form-label">Correo: </label>
                        <div class="col-md-12">
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo ">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="nacimiento" class="col-md-6 col-form-label">Fecha Nacimiento: <span style="color: red;">(*)</span></label>
                        <label for="telefono" class="col-md-3 col-form-label">Teléfono: <span style="color: red;">(*)</span></label>
                        <label for="sexo" class="col-md-3 col-form-label">Sexo: <span style="color: red;">(*)</span></label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="nacimiento" id="nacimiento" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="telefono...">
                        </div>
                        <div class="col-md-3">
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="domicilio" class="col-md-12 col-form-label">Dirección: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="domicilio" name="domicilio" rows="2" placeholder="Ingrese su dirección"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cargo" class="col-md-6 col-form-label">Cargo: <span style="color: red;">(*)</span></label>
                        <label for="gestion_ingreso" class="col-md-6 col-form-label">Gestion ingreso: <span style="color: red;">(*)</span></label>
                        <div class="col-md-6">
                            <select name="cargo" id="cargo" required class="form-control">
                                <option value="">-- Seleccione cargo --</option>
                                <option value="Director">Director</option>
                                <option value="Secretaria">Secretaria</option>
                                <option value="Regente">Regente</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Portera">Portera</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="gestion_ingreso" id="gestion_ingreso" class="form-control" placeholder="yyyy">
                        </div>
                    </div>

                    <br>
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                            <button type="submit" id="btn-guardar-administrativo" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- GENERAR REPORTE MODAL -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="imprimir_administrativos_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="titulo_reporte_administrativos" style="color: white"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
            </div>
            <div style="height: 500px; width: 100%;" class="modal-body">
                <iframe id="administrativos_pdf" width="100%" height="100%" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary cerrar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!--  Modal de editar administrativo -->
<div class="modal fade" id="editar-administrativo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="editar-administrativo-header" class="modal-header">
                <h5 id="editar-administrativo-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="editar-administrativo-body" class="modal-body">
                <form id="frm_editar_administrativo" method="post">

                    <div class="form-group row">
                        <label for="edit_ci" class="col-md-8 col-form-label">CI: <span style="color: red;">(*)</span></label>
                        <label for="edit_exp" class="col-md-4 col-form-label">EXP: <span style="color: red;">(*)</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="edit_ci" id="edit_ci" required>
                        </div>
                        <div class="col-md-4">
                            <select name="edit_exp" id="edit_exp" class="form-control" required>
                                <option value="">-- Expedido en --</option>
                                <option value="LP">LP</option>
                                <option value="OR">OR</option>
                                <option value="PT">PT</option>
                                <option value="TJ">TJ</option>
                                <option value="PD">PD</option>
                                <option value="BE">BE</option>
                                <option value="SC">SC</option>
                                <option value="CB">CB</option>
                                <option value="CH">CH</option>
                            </select>
                        </div>
                        <input type="hidden" name="edit_id_persona" id="edit_id_persona">
                        <input type="hidden" name="edit_id_grupo_usuario" id="edit_id_grupo_usuario">
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="edit_nombre" class="col-md-12 col-form-label">Nombre: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" name="edit_nombre" id="edit_nombre" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="edit_paterno" class="col-md-12 col-form-label">Paterno: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" name="edit_paterno" id="edit_paterno" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="edit_materno" class="col-md-12 col-form-label">Materno: </label>
                        <div class="col-md-12">
                            <input type="text" name="edit_materno" id="edit_materno" class="form-control">
                        </div>
                    </div>

                    <div class="form-group m-t-10 row">
                        <label for="edit_correo" class="col-md-12 col-form-label">Correo: </label>
                        <div class="col-md-12">
                            <input type="text" name="edit_correo" id="edit_correo" class="form-control">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="edit_nacimiento" class="col-md-6 col-form-label">Fecha Nacimiento: <span style="color: red;">(*)</span></label>
                        <label for="edit_telefono" class="col-md-3 col-form-label">Teléfono: <span style="color: red;">(*)</span></label>
                        <label for="edit_sexo" class="col-md-3 col-form-label">Sexo: <span style="color: red;">(*)</span></label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="edit_nacimiento" id="edit_nacimiento" required>
                            <input type="hidden" id="edit_id_usuario" name="edit_id_usuario">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="edit_telefono" id="edit_telefono" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <select name="edit_sexo" id="edit_sexo" class="form-control" required>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_domicilio" class="col-md-12 col-form-label">Dirección: <span style="color: red;">(*)</span></label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="edit_domicilio" name="edit_domicilio" rows="2"></textarea>
                        </div>
                        <input type="hidden" id="edit_id_administrativo" name="edit_id_administrativo">
                    </div>

                    <div class="form-group row">
                        <label for="edit_cargo" class="col-md-6 col-form-label">Cargo: <span style="color: red;">(*)</span></label>
                        <label for="edit_gestion_ingreso" class="col-md-6 col-form-label">Gestion ingreso: <span style="color: red;">(*)</span></label>
                        <div class="col-md-6">
                            <select name="edit_cargo" id="edit_cargo" required class="form-control">
                                <option value="">-- Seleccione cargo --</option>
                                <option value="Director">Director</option>
                                <option value="Secretaria">Secretaria</option>
                                <option value="Regente">Regente</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Portera">Portera</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="edit_gestion_ingreso" id="edit_gestion_ingreso" class="form-control">
                        </div>
                    </div>

                    <br>
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                            <button type="submit" id="btn-editar-administrativo" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal para agregar usuario
    $("#agregar_administrativo").on("click", function(e) {
        parametrosModal(
            "#agregar-administrativo",
            "Agregar administrativo",
            "modal-lg",
            false,
            true
        );
    });

    //Listar datatable
    $("#tbl_administrativo").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/administrativo/ajaxListarAdministrativos",
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
        columnDefs: [{
                searchable: false,
                orderable: false,
                visible: false,
                targets: 1
            },
            {
                searchable: false,
                orderable: false,
                targets: -1,
                data: null,
                render: function(data, type, row, meta) {
                    return (
                        '<div class="btn-group" role="group">' +
                        '<a data="' + data[0] +
                        '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_administrativo" data-toggle="tooltip" title="Editar">' +
                        '<i class="fa fa-pencil-square-o"></i></a>' +
                        '<a data="' +
                        data[0] +
                        '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_administrativo" data-toggle="tooltip" title="Eliminar">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div>'
                    );
                }
            }
        ]
    });

    // Guardar administrativo
    $("#frm_agregar_administrativo").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/administrativo/insertar_administrativo",
            data: $("#frm_agregar_administrativo").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.warning !== "undefined") {
                mensajeAlert("warning", response.warning, "Advertencia");
                $("#ci").focus();
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_administrativo").DataTable().draw();
                $("#agregar-administrativo").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCamposAgregar();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar el administrativo", "Error");
        });
    });

    function limpiarCamposAgregar() {
        $("#id").val("");
        $("#id_administrativo").val("");
        $("#ci").val("");
        $("#exp").val("");
        $("#nombre").val("");
        $("#paterno").val("");
        $("#materno").val("");
        $("#correo").val("");
        $("#nacimiento").val("");
        $("#telefono").val("");
        $("#sexo").val("");
        $("#domicilio").val("");
        $("#cargo").val("");
        $("#gestion_ingreso").val("");
    }

    function limpiarCamposEditar() {
        $("#edit_id").val("");
        $("#edit_id_administrativo").val("");
        $("#edit_ci").val("");
        $("#edit_exp").val("");
        $("#edit_nombre").val("");
        $("#edit_paterno").val("");
        $("#edit_materno").val("");
        $("#edit_correo").val("");
        $("#edit_nacimiento").val("");
        $("#edit_telefono").val("");
        $("#edit_sexo").val("");
        $("#edit_domicilio").val("");
        $("#edit_cargo").val("");
        $("#edit_gestion_ingreso").val("");
        $("#edit_id_usuario").val("");
    }
    // Editar Administrativo
    $('#tbl_administrativo').on("click", ".btn_editar_administrativo", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/administrativo/editar_administrativo",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#edit_id_persona").val(response[0]["id_persona"]);
            $("#edit_ci").val(response[0]["ci"]);
            $("#edit_exp").val(response[0]["exp"]);
            $("#edit_correo").val(response[0]["correo"]);
            $("#edit_paterno").val(response[0]["paterno"]);
            $("#edit_materno").val(response[0]["materno"]);
            $("#edit_nombre").val(response[0]["nombres"]);
            $("#edit_nacimiento").val(response[0]["nacimiento"]);
            $("#edit_sexo").val(response[0]["sexo"]);
            $("#edit_telefono").val(response[0]["telefono"]);
            $("#edit_domicilio").val(response[0]["domicilio"]);
            $("#edit_id_grupo_usuario").val(response[0]["id_grupo_usuario"]);
            $("#edit_id_administrativo").val(response[0]["id_administrativo"]);
            $("#edit_cargo").val(response[0]["cargo"]);
            $("#edit_gestion_ingreso").val(response[0]["gestion_ingreso"]);

            $("#edit_id_usuario").val(response[0]["id_usuario"]);

            parametrosModal(
                "#editar-administrativo",
                "Editar administrativo",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {});

    });

    // Actualizar administrativo
    $("#frm_editar_administrativo").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/administrativo/actualizar_administrativo",
            data: $("#frm_editar_administrativo").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.warning !== "undefined") {
                mensajeAlert("warning", response.warning, "Advertencia");
                $("#ci").focus();
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_administrativo").DataTable().draw();
                $("#editar-administrativo").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCamposEditar();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al editar el administrativo seleccionado", "Error");
        });
    });

    // Eliminar Administrativo
    $("#tbl_administrativo").on("click", ".btn_eliminar_administrativo", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar al administrativo?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/administrativo/eliminar_administrativo",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_administrativo").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });

    $("#imprimir_administrativo").on("click", function (e) {
        $("#titulo_reporte_administrativos").html("REPORTE DE ADMINISTRATIVOS");
        $("#administrativos_pdf").prop(
            "src",
            "<?= base_url("/")?>" + "/administrativo/imprimir"
        );
        $("#imprimir_administrativos_modal").modal("show");
    });
    // fin script
</script>
