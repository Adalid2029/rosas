<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Centralizador de Areas</h3>
                        </div>
                        <div class="col-sm-7 table-toolbar-right">
                            <div class="form-group ">
                                <select class="selectpicker show-tick show-menu-arrow" data-width="150px" data-style="btn-success" data-live-search="true" id="gestion" name="gestion">
                                    <?php
                                    foreach ($this->data["gestiones"] as $key => $value) {
                                        echo '<option value="' . $value["gestion"] . '">' . $value["gestion"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php

                        $colores =  array("panel-purple", "panel-dark", "panel-pink", "panel-success", "panel-info", "panel-mint", "panel-primary", "panel-warning", "panel-purple", "panel-dark","panel-pink", "panel-success", "panel-info", "panel-mint","panel-primary", "panel-warning");
                        foreach ($this->data["cursos_paralelos"] as $key => $value) {
                            echo '<div class="col-lg-4 col-md-6">
                                <!--Tile-->
                                <!--===================================================-->
                                <div class="panel '.$colores[$key].' panel-colorful">
                                    <div class="pad-all text-center">                                            
                                        <span class="text-1x text-thin">Paralelo</span>
                                        <p>'.$value["curso"].'</p>
                                        <a data="'.$value["curso"].'" href="#" id="btn_imprimir_centralizador" class="text-2x" style="color: whitesmoke">
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

<!-- GENERAR REPORTE MODAL -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="imprimir_centralizador_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="titulo_centralizador" style="color: white"></h5>
                <button type="button" id="centralizador_cerrar" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
            </div>
            <div style="height: 500px; width: 100%;" class="modal-body">
                <iframe id="centralizador_pdf" width="100%" height="100%" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary centralizador_cerrar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
            </div>
        </div>
    </div>


<script>
    $('.selectpicker').selectpicker();

    $("a#btn_imprimir_centralizador").on("click", function (e) {
        let paralelo = $(this).attr("data");
        let gestion = $("#gestion").val();

        // imprimir pdf
        $("#titulo_centralizador").html("CENTRALIZADOR DE AREAS");
        $("#centralizador_pdf").prop(
            "src",
            "<?= base_url("/")?>" + "/reporte/imprimirCentralizadorAreas/?paralelo="+paralelo+"&gestion="+ gestion
        );

        $("#imprimir_centralizador_modal").modal("show");

    });
</script>
