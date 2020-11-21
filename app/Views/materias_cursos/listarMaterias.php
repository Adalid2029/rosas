<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">

                    <button class="btn btn-success btn-active-success" id="agregar_materia">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>

                </div>
                <h3 class="panel-title">Materias</h3>
            </div>

            <div class="panel-body">
                <table id="tbl_materia" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Código</th>
                            <th>Nombre</th>
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
<div class="modal fade" id="agregar-materia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="agregar-materia-header" class="modal-header">
                <h5 id="agregar-materia-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="agregar-materia-body" class="modal-body">
                <form id="frm_guardar_materia" method="POST">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="codigo">Código <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="id_materia" id="id_materia">
                            <input type="hidden" name="accion" id="accion" value="">
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="nombre">Nombre Materia <span style="color: red;">(*)</span> :</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-guardar-materia" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    //Listar Materias
    $("#tbl_materia").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "/materia/ajaxListarMaterias",
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
                    '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn_editar_materia" data-toggle="tooltip" title="Editar">' +
                    '<i class="fa fa-pencil-square-o"></i></a>' +
                    '<a data="' +
                    data[0] +
                    '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn_eliminar_materia" data-toggle="tooltip" title="Eliminar">' +
                    '<i class="fa fa-trash-o"></i></a>' +
                    '</div>'
                );
            }
        }]
    });

    // Modal para agregar materia
    $("#agregar_materia").on("click", function(e) {
        $("#btn-guardar-materia").html("Guardar");
        $("#accion").val("in");
        parametrosModal(
            "#agregar-materia",
            "Agregar Materia",
            "modal-lg",
            false,
            true
        );
    });

    // verificar codigo repetido
    $("#codigo").on("change", function (e) {
        e.preventDefault();
        let cod = $("#codigo").val();
        $.ajax({
            type: "POST",
            url: "/materia/verificar",
            data: {"cod": cod, "columna": "codigo"},
            dataType: "JSON"
        }).done(function (response) {
            if (typeof response.warning !== "undefined") {
                mensajeAlert("warning", response.warning, "Advertencia");
                $("#codigo").val("");
                $("#codigo").focus();
            }
        });
    });

    // verificar nombre materia repetido
    $("#nombre").on("change", function (e) {
        e.preventDefault();
        let cod = $("#nombre").val();
        $.ajax({
            type: "POST",
            url: "/materia/verificar",
            data: {"cod": cod, "columna": "nombre"},
            dataType: "JSON"
        }).done(function (response) {
            if (typeof response.warning !== "undefined") {
                mensajeAlert("warning", response.warning, "Advertencia");
                $("#nombre").val("");
                $("#nombre").focus();
            }
        });
    });

    // Guardar tutor
    $("#frm_guardar_materia").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/materia/guardar_materia",
            data: $("#frm_guardar_materia").serialize(),
            dataType: "JSON"
        }).done(function(response) {

            if (typeof response.form !== "undefined") {
                mensajeAlert("warning", response.form, "Advertencia");
            }

            if (typeof response.exito !== "undefined") {
                $("#tbl_materia").DataTable().draw();
                $("#agregar-materia").modal("hide");
                mensajeAlert("success", response.exito, "Exito");
                limpiarCampos();
            }

        }).fail(function(e) {
            mensajeAlert("error", "Error al registrar/editar la materia", "Error");
        });
    });

    // Limpiar Campos
    function limpiarCampos() {
        $("#id_materia").val("");
        $("#codigo").val("");
        $("#nombre").val("");
        $("#accion").val("");
    }

    // Editar Materia
    $('#tbl_materia').on("click", ".btn_editar_materia", function(e) {
        let id = $(this).attr("data");
        $.ajax({
            type: "POST",
            url: "/materia/editar_materia",
            data: {
                "id": id
            },
            dataType: "JSON"
        }).done(function(response) {

            $("#id_materia").val(response[0]["id_materia"]);
            $("#codigo").val(response[0]["codigo"]);
            $("#nombre").val(response[0]["nombre"]);
            $("#accion").val("up");

            $("#btn-guardar-materia").html("Editar");
            parametrosModal(
                "#agregar-materia",
                "Editar Materia",
                "modal-lg",
                false,
                true
            );

        }).fail(function(e) {
            $("#agregar-materia").modal("hide");
            limpiarCampos();
        });

    });

    // Eliminar Materi
    $("#tbl_materia").on("click", ".btn_eliminar_materia", function(e) {
        let id = $(this).attr("data");
        bootbox.confirm("¿Estas seguro de eliminar la materia?", function(result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "/materia/eliminar_materia",
                    data: {
                        "id": id
                    },
                    dataType: "JSON"
                }).done(function(response) {

                    if (typeof response.exito !== "undefined") {
                        $("#tbl_materia").DataTable().draw();
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
