<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
                    <button class="btn btn-success btn-active-success" id="btn-agregar-asignaciones-curso-estudiante">
                        <i class="fa fa-plus-square-o"></i>
                        Registrar
                    </button>
                </div>
                <h3 class="panel-title">Asignar Estudiante a un Curso</h3>
            </div>

            <div class="panel-body">
                <table id="tbl-asignaciones-cursos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Curso</th>
                            <th>Estudiante</th>
                            <th>Gestión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignar-curso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="asignar-curso-header" class="modal-header">
                <h5 id="asignar-curso-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="asignar-curso-body" class="modal-body">
                <form id="frm-asignaciones-curso-estudiante" method="POST">
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
                            <label for="id_estudiante" class="col-md-3 col-form-label">Estudiante:</label>
                            <div class="col-md-12">
                                <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                                    <option value=""></option>
                                    <?php foreach ($estudiantes as $key => $value) : ?>
                                        <option value="<?= $value['id_estudiante'] ?>"><?= $value['nombre_completo'] ?></option>
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

                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-default btn-cerrar" data-dismiss="modal" type="button">Cerrar</button>
                        <button type="submit" id="btn-insertar-asignaciones-curso-estudiante" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>