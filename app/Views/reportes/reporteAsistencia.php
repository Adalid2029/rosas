<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Reporte Asistencia</h3>
                        </div>
                        <div class="col-sm-7 table-toolbar-right">
                            <div class="form-group ">
                                <select class="selectpicker show-tick show-menu-arrow" data-width="150px" data-style="btn-success"
                                        data-live-search="true" id="curso_paralelo" name="curso_paralelo">
                                    <?php
                                    foreach ($this->data["cursos_paralelos"] as $key => $value) {
                                        echo '<option value="'.$value["curso"].'">'.$value["curso"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

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
                    <center>
                        <button type="button" class="btn btn-default-basic" id="btn_imprimir_asistencia">
                            <i class="fa fa-file-pdf-o" style="color: red"></i>
                            <span style="color: red">Imprimir</span>
                        </button>
                    </center>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- GENERAR REPORTE MODAL -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="imprimir_reporte_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" style="color: white">REPORTE DE ASISTENCIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
            </div>
            <div style="height: 500px; width: 100%;" class="modal-body">
                <iframe id="reporte_pdf" width="100%" height="100%" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary cerrar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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

    $("#btn_imprimir_asistencia").on("click", function (e) {
        $("#reporte_pdf").prop(
            "src",
            "<?= base_url("/")?>" + "/asistencia/imprimir"
        );
        $("#imprimir_reporte_modal").modal("show");
    });
</script>
