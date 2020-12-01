<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Control de Asistencia</h3>
                        </div>
                        <div class="col-sm-7 table-toolbar-right">
                            <div class="form-group ">
                                <select class="selectpicker show-tick show-menu-arrow" data-width="150px" data-style="btn-success" data-live-search="true" id="curso_paralelo" name="curso_paralelo">
                                    <?php
                                    foreach ($this->data["cursos_paralelos"] as $key => $value) {
                                        echo '<option value="' . $value["curso"] . '">' . $value["curso"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="selectpicker show-tick show-menu-arrow" data-style="btn-info" data-live-search="true" id="id_maestro" name="id_maestro">
                                    <option value="">-- seleccione maestro --</option>
                                    <?php
                                    foreach ($this->data["maestros"] as $key => $value) {
                                        echo '<option value="' . $value["id_maestro"] . '">' . $value["nombres_apellidos"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tbl_asistencia" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Id curso estudiante</th>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Gestión</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>


<script>
    $('.selectpicker').selectpicker();
    var curso = $("#curso_paralelo").val();
    var tbl_asistencia;
    listar();
    // cargar el listado de por paralelos
    $("#curso_paralelo").on("change", function(e) {
        curso = $("#curso_paralelo").val();
        $("#tbl_asistencia").dataTable().fnDestroy();
        listar();

    });


    function listar() {
        tbl_asistencia = $("#tbl_asistencia").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "order": [0, 'desc'],
            ajax: '/asistencia/ajaxListarEstudiantesParalelos/?curso=' + curso,
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
                    targets: 1,
                },
                {
                    searchable: false,
                    orderable: false,
                    targets: -1,
                    data: null,
                    render: function(data, type, row, meta) {
                        return '<select id="asistencia' + data[0] + '" data="' + data[0] + '" name="asistencia" class="custom-select asistencia" data-style="btn-info" data-live-search="true">' +
                            '<option value="">--seleccione--</option>' +
                            '<option value="A">ASISTENCIA</option>' +
                            '<option value="F">FALTA</option>' +
                            '<option value="L">LICENCIA</option>' +
                            '<option value="R">RETRASO</option>' +
                            '</select>';

                    }
                }
            ]
        });
    }

    // insertar asistencia del estudiante
    $("#tbl_asistencia").on("change", "select.asistencia", function(e) {

        if ($(`#id_maestro`).val() === "") {
            mensajeAlert("warning", "Por favor seleccione al maestro", "Advertencia!!!")
        } else {
            let id = $(this).attr("data");
            let valor = $("#asistencia" + id).val();
            let id_maestro = $("#id_maestro").val();

            $.ajax({
                type: "POST",
                url: "/asistencia/agregar_asistencia",
                data: {
                    "id": id,
                    "valor": valor,
                    "id_maestro": id_maestro
                },
                dataType: "JSON"
            }).done(function(response) {

                if (typeof response.exito !== "undefined") {
                    mensajeAlert("success", response.exito, "Exito");
                }

                if (typeof response.cambio !== "undefined") {
                    mensajeAlert("success", response.cambio, "Exito");
                }

            }).fail(function(e) {
                mensajeAlert("error", "Error al procesar la peticion", "Error");
            });
        }
    });
</script>