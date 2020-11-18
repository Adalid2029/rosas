<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_paralelo">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Paralelos</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_paralelo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Paralelo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro materia -->
<div class="modal fade" id="agregar-paralelo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-paralelo-header" class="modal-header">
                <h5 id="agregar-paralelo-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-paralelo-body" class="modal-body">
                <form id="frm_guardar_paralelo" method="POST">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="nivel">Paralelo <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="paralelo" id="paralelo" required class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="id_paralelo" id="id_paralelo">
                            <input type="hidden" name="accion" id="accion" value="">
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-paralelo" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //Listar Paralelos
    $("#tbl_paralelo").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/paralelo/ajaxListarParalelos",
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
                    '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_paralelo" data-toggle="tooltip" title="Editar">' +
                    '<i class="fa fa-pencil-square-o"></i></a>' +
                    '<a data="' +
                    data[0] +
                    '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_paralelo" data-toggle="tooltip" title="Eliminar">' +
                    '<i class="fa fa-trash-o"></i></a>' +
                    '</div>'
                );
            }
        }]
    });

    // Modal para agregar paralelo
    $("#agregar_paralelo").on("click", function(e) {
        $("#btn-guardar-paralelo").html("Guardar");
        $("#accion").val("in");
        parametrosModal(
            "#agregar-paralelo",
            "Agregar Paralelo",
            "modal-lg",
            false,
            true
        );
    });

    // Guardar paralelo
    $("#frm_guardar_paralelo").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/paralelo/guardar_paralelo",
            data: $("#frm_guardar_paralelo").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.error !== "undefined") {
                mensajeAlert("error", response.error, "Error");
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_paralelo").DataTable().draw();
                $("#agregar-paralelo").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar el paralelo", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_paralelo").val("");
        $("#paralelo").val("");
        $("#accion").val("");
    }

    // Editar Materia
    $('#tbl_paralelo').on("click", ".btn_editar_paralelo", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/paralelo/editar_paralelo",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_paralelo").val(response[0]["id_paralelo"]);
            $("#paralelo").val(response[0]["paralelo"]);
            $("#accion").val("up");

            $("#btn-guardar-paralelo").html("Editar");
            parametrosModal(
                "#agregar-paralelo",
                "Editar Paralelo",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-paralelo").modal("hide");
            limpiarCampos();
        });

    });

    // Eliminar Paralelo
    $("#tbl_paralelo").on("click", ".btn_eliminar_paralelo", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar el paralelo seleccionado?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/paralelo/eliminar_paralelo",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_paralelo").DataTable().draw();
                        mensajeAlert("success", response.exito, "Exito");
                    }

                    if (typeof response.error !== "undefined") {
                        mensajeAlert("error", response.error, "Error");
                    }

                }).fail(function(e) {
                    mensajeAlert("error", "Error al procesar la peticion", "Error");
                });
            }
        });

    });

</script>

