<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Seguimiento Pedagógico</h3>
                        </div>
                        <div class="col-sm-7 table-toolbar-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-default pull-right" id="reportrange">
                                      <span>
                                        <i class="fa fa-calendar"></i>
                                        &nbsp; Fecha&nbsp;
                                      </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php

                        $colores =  array("panel-pink", "panel-success", "panel-info", "panel-mint","panel-primary", "panel-warning", "panel-purple", "panel-dark", "panel-pink", "panel-success", "panel-info", "panel-success", "panel-mint", "panel-primary", "panel-warning", "panel-purple", "panel-dark");
                        foreach ($this->data["cursos_paralelos"] as $key => $value) {
                            echo '<div class="col-lg-4 col-md-6">
                                <!--Tile-->
                                <!--===================================================-->
                                <div class="panel '.$colores[$key].' panel-colorful">
                                    <div class="pad-all text-center">                                            
                                        <span class="text-1x text-thin">Paralelo</span>
                                        <p>'.$value["curso"].'</p>
                                        <a data="'.$value["curso"].'" href="#" id="btn_imprimir_asistencia" class="text-2x" style="color: whitesmoke">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <!--===================================================-->
                            </div>';
                        }?>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!--  Modal listar estudiantes segun paralelo -->
<div class="modal fade" id="agregar-seguimiento" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document" style="width: 70%;">
        <div class="modal-content">
            <div id="agregar-seguimiento-header" class="modal-header bg-primary">
                <h5 id="agregar-seguimiento-title" class="modal-title" style="color: white"></h5>
                <button type="button" id="close-seguimiento" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl_seguimiento_academico" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Curso</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Gestión</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info btn-cerrar-seguimiento" data-dismiss="modal" type="button">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- GENERAR REPORTE MODAL -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="imprimir_seguimiento_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="titulo_reporte_seguimiento" style="color: white"></h5>
                <button type="button" id="seguimiento_cerrar" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
            </div>
            <div style="height: 500px; width: 100%;" class="modal-body">
                <iframe id="seguimiento_pdf" width="100%" height="100%" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary seguimiento_cerrar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>



<script>

    mensajeAlert("info", "Seleccione el rango de fecha que desea imprimir el seguimiento académico de un estudiante y el curso", "Información !!!");

    $('.selectpicker').selectpicker();
    var fechaInicial = moment().format("YYYY-MM-DD");
    var fechaFinal = moment().format("YYYY-MM-DD");

    // Rango de fecha
    $("#reportrange").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    jQuery("#reportrange").daterangepicker(
        {
            ranges: {
                "Hoy": [moment(), moment()],
                "Ayer": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Últimos 7 días": [moment().subtract(6, "days"), moment()],
                "Últimos 30 días": [moment().subtract(29, "days"), moment()],
                "Este mes": [moment().startOf("month"), moment().endOf("month")],
                "Último mes": [
                    moment()
                        .subtract(1, "month")
                        .startOf("month"),
                    moment()
                        .subtract(1, "month")
                        .endOf("month")
                ]
            },
            start: moment(),
            end: moment(),
            locale: {
                separator: " - ",
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                fromLabel: "de",
                toLabel: "hasta",
                customRangeLabel: "Rango personalizado"
            }
        },
        function(start, end) {
            $("#reportrange span").html(
                start.format("DD-MM-YYYY") +
                ' <i class="fa fa-minus"></i> ' +
                end.format("DD-MM-YYYY")
            );

            fechaInicial = start.format("YYYY-MM-DD");

            fechaFinal = end.format("YYYY-MM-DD");
        }
    );

    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        //do something, like clearing an input
        $("#reportrange span").html("Fecha");
        $("#reportrange").val("");

        fechaInicial = moment().format("YYYY-MM-DD");
        fechaFinal = moment().format("YYYY-MM-DD");
    });

    $("a#btn_imprimir_asistencia").on("click", function (e) {
        let paralelo = $(this).attr("data");

        //Listado de falta por estudiante
        $("#tbl_seguimiento_academico").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "order": [ 0, 'desc' ],
            ajax: '/reporte/ajaxListarEstudiantesParalelos/?curso=' +paralelo,
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
                        return (
                            '<div class="btn-group" role="group">' +
                            '<a data="' + data[0] +
                            '" data-name="'+data[2]+'" data-curso="'+data[3]+'" class="btn btn-default btn-sm text-white btn_imprimir_seguimiento" data-toggle="tooltip" title="Imprimir">' +
                            '<i style="color: red" class="fa fa-print"></i></a>' +
                            '</div>'
                        );
                    }
                }
            ]
        });

        parametrosModal(
            "#agregar-seguimiento",
            "Listado de estudiantes: " + paralelo,
            "modal-lg",
            false,
            true
        );

    });

    $(".btn-cerrar-seguimiento, #close-seguimiento, .seguimiento_cerrar, #seguimiento_cerrar").on("click", function (e) {
       let table = $("#tbl_seguimiento_academico").DataTable();
       table.destroy();
    });

    $("#tbl_seguimiento_academico").on("click", ".btn_imprimir_seguimiento", function (e) {
        let id = $(this).attr("data");
        let name = $(this).attr("data-name");
        let curso = $(this).attr("data-curso");

        $("#agregar-seguimiento").modal("hide");

        // imprimir pdf
        $("#titulo_reporte_seguimiento").html("REPORTE DE SEGUIMIENTO ACADÉMICO");
        $("#seguimiento_pdf").prop(
            "src",
            "<?= base_url("/")?>" + "/reporte/imprimirSeguimientoEstudiante/?id="+id+"&fechaInicio="+fechaInicial+"&fechaFinal="+fechaFinal+"&nombre="+ name + "&curso_paralelo=" + curso
        );

        $("#imprimir_seguimiento_modal").modal("show");

    });



</script>
