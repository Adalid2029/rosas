<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-5 table-toolbar-left">
                            <h3 class="panel-title">Control de Asistencia</h3>
                        </div>
                        <div class="col-sm-7 table-toolbar-right">
                            <div class="form-group ">
                                <select class="selectpicker show-tick show-menu-arrow" data-width="150px" data-style="btn-success" data-live-search="true" id="curso_paralelo" name="curso_paralelo">
                                    <?php
                                    foreach ($this->data["cursos_paralelos"] as $key => $value) {
                                        echo '<option value="' . $value["curso"] . '">' . $value["curso"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="selectpicker show-tick show-menu-arrow" data-style="btn-info" data-live-search="true" id="id_maestro" name="id_maestro">
                                    <option value="">-- seleccione maestro --</option>
                                    <?php
                                    foreach ($this->data["maestros"] as $key => $value) {
                                        echo '<option value="' . $value["id_maestro"] . '">' . $value["nombres_apellidos"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tbl_asistencia" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Id curso estudiante</th>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Gestión</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>