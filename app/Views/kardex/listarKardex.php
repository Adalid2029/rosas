<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_kardex">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Registros Kardex</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_kardex" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Curso</th>
                            <th>Estudiante</th>
                            <th>Gestión</th>
                            <th>Faltas</th>
                            <th>Creado en</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro kardex -->
<div class="modal fade" id="agregar-kardex" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-kardex-header" class="modal-header">
                <h5 id="agregar-kardex-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-kardex-body" class="modal-body">
                <form id="frm_guardar_kardex" method="POST">
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="id_curso_paralelo" class="col-md-3 col-form-label">Curso:</label>
                            <div class="col-md-12">
                                <select name="id_curso_paralelo" id="id_curso_paralelo" class="form-control" required>
                                    <?php
                                        foreach ($this->data["cursos"] as $key => $value) {
                                            echo '<option value="'.$value["id_curso_paralelo"].'">'.$value["curso"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_kardex" id="id_kardex">
                            <input type="hidden" name="accion" id="accion">
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="id_estudiante" class="col-md-3 col-form-label">Estudiante:</label>
                            <div class="col-md-12">
                                <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                                    <?php
                                        foreach ($this->data["estudiantes"] as $key => $value) {
                                            echo '<option value="'.$value["id_estudiante"].'">'.$value["nombres_apellidos"].' - ' . $value["ci"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="gestion">Gestión <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="gestion" id="gestion" class="form-control" pattern="^\d{4}$" maxlength="4" minlength="4" required />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-kardex" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  Modal de registro falta -->
<div class="modal fade" id="agregar-falta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-falta-header" class="modal-header">
                <h5 id="agregar-falta-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-falta-body" class="modal-body">
                <form id="frm_guardar_falta" method="POST">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="tipo">Tipo <span style="color: red;">(*)</span> :</label>
                                    <select name="tipo" id="tipo" class="form-control" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="Disciplinario">Disciplinario</option>
                                        <option value="Pedagógico">Pedagógico</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id_tipo_falta" id="id_tipo_falta">
                            <input type="hidden" name="id_kardex_falta" id="id_kardex_falta">
                            <input type="hidden" name="accion_falta" id="accion_falta">
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="descripcion">Descripción <span style="color: red;">(*)</span> :</label>
                                    <textarea name="descripcion" id="descripcion"  rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="fecha">Fecha <span style="color: red;">(*)</span> :</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="registrante">Registrante <span style="color: red;">(*)</span> :</label>
                                    <textarea name="registrante" id="registrante"  rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar-falta" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-falta" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  Modal de ver faltas -->
<div class="modal fade" id="agregar-faltas" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document" style="width: 70%;">
        <div class="modal-content">
            <div id="agregar-faltas-header" class="modal-header">
                <h5 id="agregar-faltas-title" class="modal-title"></h5>
                <button type="button" id="close-faltas" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl_faltas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Kardex</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Registrante</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info btn-cerrar-faltas" data-dismiss="modal" type="button">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--  Modal de ver citaciones -->
<div class="modal fade" id="agregar-citacion" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document" style="width: 70%;">
        <div class="modal-content">
            <div id="agregar-citacion-header" class="modal-header">
                <h5 id="agregar-citacion-title" class="modal-title"></h5>
                <button type="button" id="close-citacion" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl_citacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>kardex</th>
                        <th>Estudiante</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info btn-cerrar-citacion" data-dismiss="modal" type="button">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script>
    //Listar Cursos
    $("#tbl_kardex").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/kardex/ajaxListarKardex",
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
            targets: -1,
            data: null,
            render: function(data, type, row, meta) {
                return (
                    '<div class="btn-group" role="group">' +
                    '<a data="' + data[0] +
                    '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_kardex" data-toggle="tooltip" title="Editar">' +
                    '<i class="fa fa-pencil-square-o"></i></a>' +
                    '<a data="' + data[0] +
                    '" nombre="'+data[2]+'" class="btn btn-info-basic btn-sm mdi mdi-tooltip-edit text-white btn_agregar_falta" data-toggle="tooltip" title="Agregar falta">' +
                    '<i class="fa fa-warning"></i></a>' +
                    '<a data="' + data[0] +
                    '" nombre="'+data[2]+'" class="btn btn-success btn-sm mdi mdi-tooltip-edit text-white btn_ver_faltas" data-toggle="tooltip" title="Ver faltas">' +
                    '<i class="fa fa-eye"></i></a>' +
                    '<a data="' + data[0] +
                    '" nombre="'+data[2]+'" class="btn btn-primary btn-sm mdi mdi-tooltip-edit text-white btn_ver_citacion" data-toggle="tooltip" title="Ver citación">' +
                    '<i class="fa fa-file-archive-o"></i></a>' +
                    '<a data="' +
                    data[0] +
                    '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_kardex" data-toggle="tooltip" title="Eliminar">' +
                    '<i class="fa fa-trash-o"></i></a>' +
                    '</div>'
                );
            }
        }]
    });

    // Modal para agregar kardex
    $("#agregar_kardex").on("click", function(e) {
        $("#btn-guardar-kardex").html(`Guardar`);
        $("#accion").val("in");
        $("#id_curso_paralelo").val('').trigger('change');
        $("#id_estudiante").val('').trigger('change');

        let anio = (new Date).getFullYear();
        $("#gestion").val(anio);
        // $(".yearpicker").yearpicker({
        //     year: anio,
        //     startYear: 2012,
        //     endYear: 2030,
        //     zIndex: 2346546,
        // });



        parametrosModal(
            "#agregar-kardex",
            "Agregar a Kardex",
            "modal-lg",
            false,
            true
        );
    });

    // Select2 curso
    $("#id_curso_paralelo").select2({
        placeholder: "-- Seleccione Curso --",
        allowClear: true,
        dropdownParent: $(`#agregar-kardex`),
        width: '100%'
    });

    //Select2 paralelo
    $("#id_estudiante").select2({
        placeholder: "-- Seleccione Estudiante --",
        allowClear: true,
        dropdownParent: $("#agregar-kardex"),
        width: '100%'
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_kardex").val("");
        $("#id_curso_paralelo").val('').trigger('change');
        $("#id_estudiante").val('').trigger('change');
        $("#gestion").val("");
        $("#accion").val("");
    }

    $(".btn-cerrar").on("click", function (e) {
        limpiarCampos();
    });

    // Guardar kardex
    $("#frm_guardar_kardex").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/kardex/guardar_kardex",
            data: $("#frm_guardar_kardex").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.warni !== "undefined") {
                mensajeAlert("warning", response.warni, "Advertencia");
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_kardex").DataTable().draw();
                $("#agregar-kardex").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar la materia", "Error");
        });
    });

    // Editar kardex
    $('#tbl_kardex').on("click", ".btn_editar_kardex", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/kardex/editar_kardex",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_kardex").val(response[0]["id_kardex"]);
            $("#id_curso_paralelo").val(response[0]["id_curso_paralelo"]).trigger('change');
            $("#id_estudiante").val(response[0]["id_estudiante"]).trigger('change');
            $("#gestion").val(response[0]["gestion"]);
            $("#accion").val("up");

            $("#btn-guardar-kardex").html("Editar");
            parametrosModal(
                "#agregar-kardex",
                "Editar Kardex",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-kardex").modal("hide");
        });

    });

    // Eliminar kardex
    $("#tbl_kardex").on("click", ".btn_eliminar_kardex", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estás seguro de eliminar el registro del kardex?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/kardex/eliminar_kardex",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_kardex").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });
    // fin script kardex
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // script de faltas
    // Modal para falta
    $('#tbl_kardex').on("click", ".btn_agregar_falta", function(e) {
        let id = $(this).attr("data");
        let nom = $(this).attr("nombre");
        $("#id_kardex_falta").val(id);
        $("#btn-guardar-falta").html(`Guardar`);
        $("#accion_falta").val("in");
        $("#id_curso_paralelo").val('').trigger('change');
        $("#id_estudiante").val('').trigger('change');

        parametrosModal(
            "#agregar-falta",
            "Agregar Falta a: " + nom,
            "modal-lg",
            false,
            true
        );
    });

    $(".btn-cerrar-falta").on("click", function (e) {
        limpiarCamposFalta();
    });

    // Limpiar Campos
    function limpiarCamposFalta() {
        $("#id_tipo_falta").val("");
        $("#id_kardex_falta").val('');
        $("#tipo").val('');
        $("#descripcion").val("");
        $("#fecha").val("");
        $("#registrante").val("");
        $("#accion_falta").val("");
    }

    // Guardar falta
    $("#frm_guardar_falta").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/falta/guardar_falta",
            data: $("#frm_guardar_falta").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_falta").DataTable().draw();
                $("#tbl_kardex").DataTable().draw();
                $("#agregar-falta").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCamposFalta();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar la falta", "Error");
        });
    });

    // modal para mostrar faltas cometidas por estudiante
    $("#tbl_kardex").on("click", ".btn_ver_faltas", function(e) {
        let id = $(this).attr("data");
        let nom = $(this).attr("nombre");

        //Listado de falta por estudiante
        $("#tbl_faltas").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "order": [ 0, 'desc' ],
            ajax: '/falta/ajaxListarFaltas/?id_kardex=' +id,
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
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    visible: false,
                    targets: 1,
                },
                {
                    searchable: false,
                    orderable: false,
                    targets: 6,
                    data: null,
                    render: function(data, type, row, meta) {
                        return data[6] === '0' ? '<a data="'+data[0]+'" class="btn btn-active-danger btn-dark-basic btn-sm text-white btn-revisar" data-value="1" data-toggle="tooltip" title="Marcar revisado"><i class="fa fa-window-close-o"></i> No revisado</a>'
                            : '<a data="'+data[0]+'" class="btn btn-success btn-sm text-white btn-revisar" data-toggle="tooltip" data-value="0" title="Marcar no revisado"><i class="fa fa-check-square-o"></i> Revisado</a>';
                    }
                },
                {
                searchable: false,
                orderable: false,
                targets: -1,
                data: null,
                render: function(data, type, row, meta) {
                    return  data[6] === '0' ?
                            '<div class="btn-group" role="group">' +
                            '<a data="' + data[0] +
                            '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_faltas" data-toggle="tooltip" title="Editar">' +
                            '<i class="fa fa-pencil-square-o"></i></a>' +
                            '<a data="' + data[0] +
                            '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_faltas" data-value="'+data[1]+'" data-toggle="tooltip" title="Eliminar">' +
                            '<i class="fa fa-trash-o"></i></a>' +
                            '</div>':'<div class="btn-group" role="group">' +
                        '<a data="' + data[0] +
                        '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_faltas" data-toggle="tooltip" title="Editar">' +
                        '<i class="fa fa-pencil-square-o"></i></a>' +
                        '</div>';

                }
            }]
        });

        parametrosModal(
            "#agregar-faltas",
            "Faltas del Estudiante: " + nom,
            "modal-lg",
            false,
            true
        );
    });

    $("#close-faltas").on("click", function (e) {
        let table = $('#tbl_faltas').DataTable();
        table.destroy();
    });

    $(".btn-cerrar-faltas").on("click", function (e) {
        let table = $('#tbl_faltas').DataTable();
        table.destroy();
    });

    // Marcar revisado o no revisado de las faltas cometidas
    $('#tbl_faltas').on("click", ".btn-revisar", function(e) {
        let id = $(this).attr("data");
        let value = $(this).attr("data-value");
        let msg = value==="0"? "¿Estas seguro de marcar como no visto por sus tutores?" : "¿Estas seguro de marcar como visto por sus tutores?";
        bootbox.confirm(msg, function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/falta/editar_visto",
                    data: {
                        "id_tipo_falta": id,
                        "visto": value
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_faltas").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }


                }).fail(function(e) {
                    mensajeAlert("error", "Error al cambiar de estado de la falta cometida", "Error");
                });
            }
        });

    });

    // Editar faltas
    $('#tbl_faltas').on("click", ".btn_editar_faltas", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/falta/editar_falta",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_tipo_falta").val(response[0]["id_tipo_falta"]);
            $("#id_kardex_falta").val(response[0]["id_kardex"]);
            $("#tipo").val(response[0]["tipo"]);
            $("#descripcion").val(response[0]["descripcion"]);
            $("#fecha").val(response[0]["fecha"]);
            $("#registrante").val(response[0]["registrante"]);
            $("#accion_falta").val("up");

            $("#btn-guardar-falta").html("Editar");
            parametrosModal(
                "#agregar-falta",
                "Editar Falta",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-falta").modal("hide");
        });

    });

    // Eliminar faltas
    $("#tbl_faltas").on("click", ".btn_eliminar_faltas", function(e) {
        let id = $(this).attr("data");
        let kardex = $(this).attr("data-value");
        bootbox.confirm("¿Estás seguro de eliminar la falta, esta acción no se puede revertir?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/falta/eliminar_falta",
                    data: {
                        "id": id,
                        "kardex": kardex
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_faltas").DataTable().draw();
                        $("#tbl_kardex").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });


    // CITACIONES
    // modal para mostrar faltas cometidas por estudiante
    $("#tbl_kardex").on("click", ".btn_ver_citacion", function(e) {
        let id = $(this).attr("data");
        let nom = $(this).attr("nombre");

        //Listado de falta por estudiante
        $("#tbl_citacion").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "order": [ 0, 'desc' ],
            ajax: '/falta/ajaxListarCitacion/?id_kardex=' +id,
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
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    visible: false,
                    targets: 1,
                },
                {
                    searchable: false,
                    orderable: false,
                    targets: -1,
                    data: null,
                    render: function(data, type, row, meta) {
                        return ('<a data-name="'+data[2]+'" data-fecha="'+data[3]+'" data="'+data[0]+'" ' +
                            'class="btn btn-active-danger btn-dark-basic btn-sm text-white btn_imprimir_citacion" ' +
                            'data-value="1" data-toggle="tooltip" title="Imprimir citación">' +
                            '<i class="fa fa-file-pdf-o"></i>Imprimir</a>')

                    }
                }]
        });

        parametrosModal(
            "#agregar-citacion",
            "Citaciones del Estudiante: " + nom,
            "modal-lg",
            false,
            true
        );
    });

    $("#close-citacion").on("click", function (e) {
        let table = $('#tbl_citacion').DataTable();
        table.destroy();
    });

    $(".btn-cerrar-citacion").on("click", function (e) {
        let table = $('#tbl_citacion').DataTable();
        table.destroy();
    });

    // imprimir citacion
    $("#tbl_citacion").on("click", ".btn_imprimir_citacion", function (e) {
        let name = $(this).attr("data-name");
        let fecha = $(this).attr("data-fecha");
        window.location.href = "/falta/imprimirCitacion/?name=" + name + "&fecha=" + fecha;
    });
</script>
