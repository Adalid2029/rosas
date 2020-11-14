<div id="content-container">
    <div id="page-content">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Estudianteskkka</h3>
            </div>
            <div class="panel-body">
                <table id="tbl_listar_estudiantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nombres y Apellidos</th>
                            <th>F. Nacimiento</th>
                            <th>CI</th>
                            <th>Nota 1</th>
                            <th>Nota 2</th>
                            <th>Nota 3</th>
                            <th>Nota Final</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div id="modal-dialog" class="modal-dialog" role="document">
        <div id="modal-content" class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="modal-title" class="modal-title">Modal title</h4>
            </div>
            <div id="modal-body" class="modal-body">
                <form id="frm-nota" method="post" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-sm-3">
                            <label for="nota1" class="control-label">Nota 1</label>
                            <input type="number" id="nota1" name="nota1" class="form-control">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3">
                            <label for="nota2" class="control-label">Nota 2</label>
                            <input type="number" id="nota2" name="nota2" class="form-control">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3">
                            <label for="nota3" class="control-label">Nota 3</label>
                            <input type="number" id="nota3" name="nota3" class="form-control">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-3">
                            <label for="nota3" class="control-label">Nota Final</label>
                            <input type="number" id="nota_final" name="nota_final" class="form-control">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
                                <button type="submit" class="btn btn-primary"></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div id="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>