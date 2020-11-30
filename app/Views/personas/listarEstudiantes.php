<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_estudiante">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Estudiantes</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_estudiante" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Id est</th>
                        <th>RUDE</th>
                        <th>CI</th>
                        <th>Nombres y Apellidos</th>
                        <th>Correo</th>
                        <th>Fecha Nac.</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Ingreso en</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro estudiante -->
<div class="modal fade" id="agregar-estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-estudiante-header" class="modal-header">
                <h5 id="agregar-estudiante-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-estudiante-body" class="modal-body">
                <form id="frm_guardar_estudiante">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="rude">RUDE <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="rude" id="rude" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="ci">CI <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="ci" id="ci" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="exp">Expedido <span style="color: red;">(*)</span> :</label>
                                    <select name="exp" id="exp" class="form-control" required>
                                        <option value="">-- Expedido en --</option>
                                        <option value="CH">CH</option>
                                        <option value="LP">LP</option>
                                        <option value="CB">CB</option>
                                        <option value="OR">OR</option>
                                        <option value="PT">PT</option>
                                        <option value="SC">SC</option>
                                        <option value="PA">PA</option>
                                        <option value="TJ">TJ</option>
                                        <option value="BN">BN</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="nombres">Nombres <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="id_persona" id="id_persona">
                            <input type="hidden" name="id_estudiante" id="id_estudiante">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="accion" id="accion" value="">
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="paterno">Paterno <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="paterno" id="paterno" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="materno">Materno:</label>
                                    <input type="text" name="materno" id="materno" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="correo">Correo:</label>
                                    <input type="email" name="correo" id="correo" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="nacimiento">Nacimiento <span style="color: red;">(*)</span> :</label>
                                    <input type="date" name="nacimiento" id="nacimiento" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="telefono">Teléfono <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="sexo">Sexo <span style="color: red;">(*)</span> :</label>
                                    <select name="sexo" id="sexo" class="form-control" required>
                                        <option value="">-- seleccione --</option>
                                        <option value="F">F</option>
                                        <option value="M">M</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="gestion_ingreso">Gestión ingreso <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="gestion_ingreso" id="gestion_ingreso" class="form-control" placeholder="yyyy"  required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="domicilio">Direción:</label>
                                    <textarea name="domicilio" id="domicilio" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-right">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-estudiante" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    //Listar datatable
    $("#tbl_estudiante").DataTable(
        {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/estudiante/ajaxListarEstudiantes",
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo:
                    "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
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
                    sSortAscending:
                        ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending:
                        ": Activar para ordenar la columna de manera descendente"
                }
            },
            columnDefs: [
                {
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
                    render: function (data, type, row, meta) {
                        return (
                            '<div class="btn-group" role="group">' +
                            '<a data="' + data[0] +
                            '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_estudiante" data-toggle="tooltip" title="Editar">' +
                            '<i class="fa fa-pencil-square-o"></i></a>' +
                            '<a data="' +
                            data[0] +
                            '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_estudiante" data-toggle="tooltip" title="Eliminar">' +
                            '<i class="fa fa-trash-o"></i></a>' +
                            '</div>'
                        );
                    }
                }
            ]
        }
    );

    // Modal para agregar estudiante
    $("#agregar_estudiante").on("click", function (e) {
        $("#btn-guardar-estudiante").html("Guardar");
        $("#accion").val("in");
        parametrosModal(
            "#agregar-estudiante",
            "Agregar Estudiante",
            "modal-lg",
            false,
            true
        );

    });

    // Guardar estudiante
    $("#frm_guardar_estudiante").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/estudiante/guardar_estudiante",
            data: $("#frm_guardar_estudiante").serialize(),
            dataType: "JSON"
        }).done(function(response){

            if (typeof response.warning !== "undefined") {
                mensajeAlert("warning", response.warning, "Advertencia");
                $("#ci").focus();
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_estudiante").DataTable().draw();
                $("#agregar-estudiante").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function (e) {
            mensajeAlert("error", "Error al registrar/editar el estudiante", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos()
    {
        $("#id_persona").val("");
        $("#id_estudiante").val("");
        $("#id_usuario").val("");
        $("#rude").val("");
        $("#ci").val("");
        $("#exp").val("");
        $("#nombres").val("");
        $("#paterno").val("");
        $("#correo").val("");
        $("#materno").val("");
        $("#nacimiento").val("");
        $("#telefono").val("");
        $("#sexo").val("");
        $("#domicilio").val("");
        $("#gestion_ingreso").val("");
        $("#accion").val("");
    }

    // Editar Estudiante
    $('#tbl_estudiante').on("click", ".btn_editar_estudiante", function(e){
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/estudiante/editar_estudiante",
            data: {"id":id},
            dataType: "JSON"
        }).done(function (response) {

            $("#id_persona").val(response[0]["id_persona"]);
            $("#id_estudiante").val(response[0]["id_estudiante"]);
            $("#id_usuario").val(response[0]["id_usuario"]);
            $("#rude").val(response[0]["rude"]);
            $("#ci").val(response[0]["ci"]);
            $("#exp").val(response[0]["exp"]);
            $("#nombres").val(response[0]["nombres"]);
            $("#paterno").val(response[0]["paterno"]);
            $("#materno").val(response[0]["materno"]);
            $("#correo").val(response[0]["correo"]);
            $("#nacimiento").val(response[0]["nacimiento"]);
            $("#telefono").val(response[0]["telefono"]);
            $("#sexo").val(response[0]["sexo"]);
            $("#domicilio").val(response[0]["domicilio"]);
            $("#gestion_ingreso").val(response[0]["gestion_ingreso"]);
            $("#accion").val("up");

            $("#btn-guardar-estudiante").html("Editar");
            parametrosModal(
                "#agregar-estudiante",
                "Editar Estudiante",
                "modal-lg",
                false,
                true
            );

        }).fail(function (e) {
            $("#agregar-estudiante").modal("hide");
        });

    });

    // Eliminar Estudiante
    $("#tbl_estudiante").on("click", ".btn_eliminar_estudiante", function(e){
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar al estudiante?", function(result){
            if (result){
                $.ajax({
                    type: "POST",
                    url: "/estudiante/eliminar_estudiante",
                    data: {"id":id},
                    dataType: "JSON"
                }).done(function (response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_estudiante").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function (e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });
    // fin script

</script>
