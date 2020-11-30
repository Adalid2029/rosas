<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="<?= base_url("/") ?>" class="navbar-brand">
                <img src="<?= base_url('img/images/escudo_rosas.png') ?>" alt="Logo" class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">Las Rosas</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->

        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="demo-pli-view-list"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->
            </ul>
            <ul class="nav navbar-top-links pull-right">
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="ic-user pull-right">
                            <!--<img class="img-circle img-user media-object" src="img/profile-photos/1.png" alt="Profile Picture">-->
                            <i class="demo-pli-male"></i>
                        </span>
                        <div class="username hidden-xs"><?= (isset($user["nombres"])) ? $user["nombres"] . " " . $user["paterno"] : "Invitado"; ?></div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">
                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
                                <a class="menu--link" href="<?= base_url("perfil/perfil") ?>">
                                    <i class="demo-pli-male icon-lg icon-fw"></i>
                                    Mi perfil
                                </a>
                            </li>
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="<?= base_url('auth/logout'); ?>" class="btn btn-primary">
                                <i class="demo-pli-unlock"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
            </ul>
            <ul class="nav navbar-top-links pull-right">
                <li id="dropdown-user" class="dropdown tgl-menu-btn">
                    <?php if (isset($access)) : ?>
                        <?php if (count($access) >= 1) : ?>
                            <form method="post" action="<?= base_url('auth/access'); ?>">
                                <select class="form-control" name="nombre_grupo" onchange="submit()">
                                    <?php foreach ($access as $key => $value) : ?>
                                        <option value="<?= $value['nombre_grupo']; ?>" <?= ($value['nombre_grupo'] === (\Config\Services::session())->get('nombre_grupo') ? 'selected' : ''); ?>>
                                            Rol: <?= $value['nombre_grupo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->
    </div>
</header>
<!-- Fin header -->