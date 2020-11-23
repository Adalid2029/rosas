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
    // fin script

</script>
