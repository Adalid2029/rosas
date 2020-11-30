<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_curso">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Cursos y Paralelos</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_curso" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nivel</th>
                            <th>Paralelo</th>
                            <th>Creado en</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro materia -->
<div class="modal fade" id="agregar-curso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-curso-header" class="modal-header">
                <h5 id="agregar-curso-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-curso-body" class="modal-body">
                <form id="frm_guardar_curso_paralelo" method="POST">
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="id_curso" class="col-md-3 col-form-label">Nivel:</label>
                            <div class="col-md-12">
                                <select name="id_curso" id="id_curso" class="form-control" required>
                                    <?php
                                    foreach ($this->data["niveles"] as $key => $value) {
                                        echo '<option value="' . $value["id_curso"] . '">' . $value["nivel"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_curso_paralelo" id="id_curso_paralelo">
                            <input type="hidden" name="accion" id="accion">
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="id_paralelo" class="col-md-3 col-form-label">Paralelo:</label>
                            <div class="col-md-12">
                                <select name="id_paralelo" id="id_paralelo" class="form-control" required>
                                    <?php
                                    foreach ($this->data["paralelos"] as $key => $value) {
                                        echo '<option value="' . $value["id_paralelo"] . '">' . $value["paralelo"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-curso" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    //Listar Cursos
    $("#tbl_curso").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/curso/ajaxListarCursos",
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
                    '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_curso_p" data-toggle="tooltip" title="Editar">' +
                    '<i class="fa fa-pencil-square-o"></i></a>' +
                    '<a data="' +
                    data[0] +
                    '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_curso_p" data-toggle="tooltip" title="Eliminar">' +
                    '<i class="fa fa-trash-o"></i></a>' +
                    '</div>'
                );
            }
        }]
    });

    // Modal para agregar curso paralelo
    $("#agregar_curso").on("click", function(e) {
        $("#btn-guardar-curso").html("Guardar");
        $("#accion").val("in");
        $("#id_curso").val('').trigger('change');
        $("#id_paralelo").val('').trigger('change');
        parametrosModal(
            "#agregar-curso",
            "Agregar Curso",
            "modal-lg",
            false,
            true
        );
    });

    // Guardar materia paralelo
    $("#frm_guardar_curso_paralelo").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/curso/guardar_curso",
            data: $("#frm_guardar_curso_paralelo").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.warni !== "undefined") {
                mensajeAlert("warning", response.warni, "Advertencia");
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_curso").DataTable().draw();
                $("#agregar-curso").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar la materia", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_curso_paralelo").val("");
        $("#id_curso").val('').trigger('change');
        $("#id_paralelo").val('').trigger('change');
        $("#accion").val("");
    }

    // Select2 nivel
    $("#id_curso").select2({
        placeholder: "-- Seleccione Nivel --",
        allowClear: true,
        dropdownParent: $(`#agregar-curso`),
        width: '100%'
    });

    //Select2 paralelo
    $("#id_paralelo").select2({
        placeholder: "-- Seleccione Paralelo --",
        allowClear: true,
        dropdownParent: $("#agregar-curso"),
        width: '100%'
    });

    $(".btn-cerrar").on("click", function(e) {
        limpiarCampos();
    });

    // Editar curso y paralelo
    $('#tbl_curso').on("click", ".btn_editar_curso_p", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/curso/editar_curso_paralelo",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_curso_paralelo").val(response[0]["id_curso_paralelo"]);
            $("#id_curso").val(response[0]["id_curso"]).trigger('change');
            $("#id_paralelo").val(response[0]["id_paralelo"]).trigger('change');
            $("#accion").val("up");

            $("#btn-guardar-curso").html("Editar");
            parametrosModal(
                "#agregar-curso",
                "Editar Curso y Paralelo",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-curso").modal("hide");
        });

    });

    // Eliminar curso paralelo
    $("#tbl_curso").on("click", ".btn_eliminar_curso_p", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar el curso seleccionado?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/curso/eliminar_curso",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_curso").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });
    // fin script
</script>