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
                                                <a class="list-group-item list-item-sm seleccion-materia" data-id-materia="<?= $value['id_materia'] ?>" data-id-maestro="<?= $value['id_maestro'] ?>" data-id-curso-paralelo="<?= $value['id_curso_paralelo'] ?>">
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="centralizador-interno" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div id="centralizador-interno-dialog" class="modal-dialog modal-dialog-centered" role="document">
        <div id="centralizador-interno-content" class="modal-content">
            <div id="centralizador-interno-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="centralizador-interno-title" class="modal-title">Modal title</h4>
            </div>
            <div id="centralizador-interno-body" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary seguimiento_cerrar" data-dismiss="modal" aria-label="Close">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>