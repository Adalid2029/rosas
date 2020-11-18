<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_nivel">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Niveles</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_nivel" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nivel</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!--  Modal de registro materia -->
<div class="modal fade" id="agregar-nivel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-nivel-header" class="modal-header">
                <h5 id="agregar-nivel-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-nivel-body" class="modal-body">
                <form id="frm_guardar_nivel" method="POST">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="nivel">Nivel <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="nivel" id="nivel" required class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="id_curso" id="id_curso">
                            <input type="hidden" name="accion" id="accion" value="">
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-nivel" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //Listar Niveles
    $("#tbl_nivel").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/nivel/ajaxListarNiveles",
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
                    '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_nivel" data-toggle="tooltip" title="Editar">' +
                    '<i class="fa fa-pencil-square-o"></i></a>' +
                    '<a data="' +
                    data[0] +
                    '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_nivel" data-toggle="tooltip" title="Eliminar">' +
                    '<i class="fa fa-trash-o"></i></a>' +
                    '</div>'
                );
            }
        }]
    });

    // Modal para agregar Nivel
    $("#agregar_nivel").on("click", function(e) {
        $("#btn-guardar-nivel").html("Guardar");
        $("#accion").val("in");
        parametrosModal(
            "#agregar-nivel",
            "Agregar Nivel",
            "modal-lg",
            false,
            true
        );
    });

    // Guardar nivel
    $("#frm_guardar_nivel").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/nivel/guardar_nivel",
            data: $("#frm_guardar_nivel").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.error !== "undefined") {
                mensajeAlert("error", response.error, "Error");
            }

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_nivel").DataTable().draw();
                $("#agregar-nivel").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar el nivel", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_curso").val("");
        $("#nivel").val("");
        $("#accion").val("");
    }

    // Editar Materia
    $('#tbl_nivel').on("click", ".btn_editar_nivel", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/nivel/editar_nivel",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_curso").val(response[0]["id_curso"]);
            $("#nivel").val(response[0]["nivel"]);
            $("#accion").val("up");

            $("#btn-guardar-nivel").html("Editar");
            parametrosModal(
                "#agregar-nivel",
                "Editar Nivel",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-nivel").modal("hide");
            limpiarCampos();
        });

    });

    // Eliminar Nivel
    $("#tbl_nivel").on("click", ".btn_eliminar_nivel", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar el nivel seleccionado?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/nivel/eliminar_nivel",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_nivel").DataTable().draw();
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

