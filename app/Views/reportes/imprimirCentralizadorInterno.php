<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Seguimiento Académico</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $colores =  array("panel-pink", "panel-success", "panel-info", "panel-mint", "panel-primary", "panel-warning", "panel-purple", "panel-dark", "panel-pink", "panel-success", "panel-info", "panel-success", "panel-mint", "panel-primary", "panel-warning", "panel-purple", "panel-dark");
                        foreach ($materiasCurso as $key => $value) : ?>
                            <div class="col-lg-4 col-md-6 text-center">
                                <div class="panel <?= $colores[rand(0, count($colores))] ?> panel-colorful">
                                    <div class="pad-all">
                                        <span class="text-1x text-thin">Paralelo <?= $value['paralelo'] ?></span>
                                        <p><?= $value['nivel'] ?></p>
                                        <div class="list-group bg-trans mar-no">
                                            <?php foreach ($value['materiasCurso'] as $key => $value) : ?>
                                                <a class="list-group-item list-item-sm seleccion-materia" data-id-materia="1" data-id-maestro="43" data-id-curso-paralelo="7">
                                                    <span class="label label-danger pull-right"><?= $value['codigo'] ?> <i class="fa fa-print"></i></span>
                                                    <?= $value['nombre'] ?>
                                                </a>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
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