<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_responsable">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Responsables Asignados</h3>
            </div>

            <div class="panel-body">

                <table id="tbl_responsable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Estudiante</th>
                            <th>CI Est.</th>
                            <th>Teléfono</th>
                            <th>Tutor</th>
                            <th>CI tutor</th>
                            <th>Teléfono</th>
                            <th>Parentesco</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>
    </div>
</div>

<!--  Modal de registro responsable -->
<div class="modal fade" id="agregar-responsable" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-responsable-header" class="modal-header">
                <h5 id="agregar-responsable-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-responsable-body" class="modal-body">
                <form id="frm_guardar_responsable" method="POST">
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="id_tutor" class="col-md-3 col-form-label">Tutor(a):</label>
                            <div class="col-md-12">
                                <select name="id_tutor" id="id_tutor" class="form-control" required>
                                    <?php
                                        foreach ($this->data["tutores"] as $key => $value) {
                                            echo '<option value="'.$value["id_tutor"].'">'.$value["nombres_apellidos"].' - '.$value["ci"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="accion" id="accion">
                            <input type="hidden" name="id_responsable" id="id_responsable">
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="id_estudiante" class="col-md-3 col-form-label">Estudiante:</label>
                            <div class="col-md-12">
                                <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                                        <?php
                                        foreach ($this->data["estudiantes"] as $key => $value) {
                                            echo '<option value="'.$value["id_estudiante"].'">'.$value["nombres_apellidos"].' - '.$value["ci"].'</option>';
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-responsable" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    //Listar tutores y estudiantes
    $("#tbl_responsable").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/responsable/ajaxListarEstudianteTutor",
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
                targets: -1,
                data: null,
                render: function(data, type, row, meta) {
                    return (
                        '<div class="btn-group" role="group">' +
                        '<a data="' + data[0] +
                        '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_responsable" data-toggle="tooltip" title="Editar">' +
                        '<i class="fa fa-pencil-square-o"></i></a>' +
                        '<a data="' +
                        data[0] +
                        '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_responsable" data-toggle="tooltip" title="Eliminar">' +
                        '<i class="fa fa-trash-o"></i></a>' +
                        '</div>'
                    );
                }
            }
        ]
    });

    // Modal para agregar tutor
    $("#agregar_responsable").on("click", function(e) {
        $("#btn-guardar-responsable").html("Guardar");
        $("#accion").val("in");
        $( "#id_tutor" ).val('').trigger('change');
        $( "#id_estudiante" ).val('').trigger('change');
        parametrosModal(
            "#agregar-responsable",
            "Agregar Responsable",
            "modal-lg",
            false,
            true
        );
    });

    // Select2 tutores
    $("#id_tutor").select2({
        placeholder: "-- Seleccione Tutor(a) --",
        allowClear: true,
        dropdownParent: $(`#agregar-responsable`),
        width: '100%'
    });

    //Select2 estudiantes
    $("#id_estudiante").select2({
        placeholder: "-- Seleccione Estudiante --",
        allowClear: true,
        dropdownParent: $("#agregar-responsable"),
        width: '100%'
    });

    // Guardar responsable
    $("#frm_guardar_responsable").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/responsable/guardar_responsable",
            data: $("#frm_guardar_responsable").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_responsable").DataTable().draw();
                $("#agregar-responsable").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar el tutor(a)", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_responsable").val("");
        $("#id_tutor").val("");
        $("#id_estudiante").val("");
        $("#accion").val("");
        $( "#id_tutor" ).val('').trigger('change');
        $( "#id_estudiante" ).val('').trigger('change');
    }

    $(".btn-cerrar").on("click", function () {
        limpiarCampos();
    });

    // Editar responsable
    $('#tbl_responsable').on("click", ".btn_editar_responsable", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/responsable/editar_responsable",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_responsable").val(response[0]["id_responsable"]);
            $("#id_tutor").val(response[0]["id_tutor"]).trigger('change');
            $("#id_estudiante").val(response[0]["id_estudiante"]).trigger('change');
            $("#accion").val("up");

            $("#btn-guardar-responsable").html("Editar");
            parametrosModal(
                "#agregar-responsable",
                "Editar Responsable",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-responsable").modal("hide");
        });

    });

    // Eliminar responsable
    $("#tbl_responsable").on("click", ".btn_eliminar_responsable", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar al tutor designado?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/responsable/eliminar_responsable",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_responsable").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });


</script>
