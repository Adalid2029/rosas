<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
                    <button class="btn btn-success btn-active-success" id="btn-agregar-asignaciones-materia-maestro">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>
                </div>
                <h3 class="panel-title">Asignar Maestro a una Materia</h3>
            </div>

            <div class="panel-body">
                <table id="tbl-asignaciones-materias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Curso</th>
                            <th>Materia</th>
                            <th>Maestro</th>
                            <th>Gestión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignar-materia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="asignar-materia-header" class="modal-header">
                <h5 id="asignar-materia-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="asignar-materia-body" class="modal-body">
                <form id="frm-asignaciones-materia-maestro" method="POST">
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="id_gestion" class="col-md-3 col-form-label">Gestion a Asignar:</label>
                            <div class="col-md-12">
                                <select name="id_gestion" id="id_gestion" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($gestiones as $key => $value) : ?>
                                        <option value="<?= $value['id_gestion'] ?>"><?= $value['gestion'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_maestro" class="col-md-3 col-form-label">Maestro:</label>
                            <div class="col-md-12">
                                <select name="id_maestro" id="id_maestro" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($maestros as $key => $value) : ?>
                                        <option value="<?= $value['id_maestro'] ?>"><?= $value['nombres'] ?> <?= $value['paterno'] ?> <?= $value['materno'] ?> CI.: <?= $value['ci'] ?> <?= $value['exp'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_curso_paralelo" class="col-md-3 col-form-label">Curso:</label>
                            <div class="col-md-12">
                                <select name="id_curso_paralelo" id="id_curso_paralelo" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($cursos_paralelos as $key => $value) : ?>
                                        <option value="<?= $value['id_curso_paralelo'] ?>"><?= $value['nivel'] . ' ' . $value['paralelo'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_materia" class="col-md-3 col-form-label">Materia:</label>
                            <div class="col-md-12">
                                <select name="id_materia" id="id_materia" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($materias as $key => $value) : ?>
                                        <option value="<?= $value['id_materia'] ?>"><?= $value['codigo'] . ' ' . $value['nombre'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-insertar-asignaciones-materia-maestro" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>