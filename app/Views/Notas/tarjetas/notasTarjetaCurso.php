<div class="col-lg-3">
    <div class="panel widget">
        <div class="widget-header bg-warning text-center">
            <h4 class="text-light mar-no pad-top"><?= $curso[0]['nivel'] ?></h4>
            <p class="mar-btm">Administrator</p>
        </div>
        <div class="widget-body">
            <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="<?= base_url('img/profile-photos/4.png') ?>">

            <div class="list-group bg-trans mar-no">
                <?php foreach ($curso as $key => $value) : ?>
                    <a class="list-group-item list-item-sm seleccion-materia" data-id-materia="<?= $value['id_materia'] ?>" data-id-maestro="<?= $value['id_maestro'] ?>" data-id-curso="<?= $value['id_curso'] ?>">
                        <span class="label label-danger pull-right"><?= $value['codigo'] ?></span>
                        <?= $value['nombre'] ?>
                    </a>
                <?php endforeach ?>


            </div>
        </div>
    </div>
</div>