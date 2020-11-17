<nav id="mainnav-container">
	<div id="mainnav">
		<!--Menu-->
		<!--================================-->
		<div id="mainnav-menu-wrap">
			<div class="nano has-scrollbar">
				<div class="nano-content" tabindex="0" style="right: -17px;">
					<!--Profile Widget-->
					<!--================================-->
					<div id="mainnav-profile" class="mainnav-profile">
						<div class="profile-wrap text-center">
							<div class="pad-btm">
								<?php
								if (isset($user[0]["sexo"])) {
									if ($user[0]["sexo"] == "M") {
										echo '<img src="' . base_url('img/profile-photos/1.png') . '" class="img-lg img-circle" alt="Profile Picture">';
									} else {
										echo '<img src="' . base_url('img/profile-photos/6.png') . '" class="img-lg img-circle" alt="Profile Picture">';
									}
								}
								?>
							</div>
							<a href="index.html#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
								<span class="pull-right dropdown-toggle">
									<i class="dropdown-caret"></i>
								</span>
								<p class="mnp-name"><?= (isset($user[0]["nombres"])) ? $user[0]["nombres"] . " " . $user[0]["paterno"] : "Invitado"; ?></p>
								<span class="mnp-desc">Director</span>
							</a>
						</div>
						<div id="profile-nav" class="collapse list-group bg-trans">
							<a href="<?= base_url('auth/logout'); ?>" class="list-group-item">
								<i class="demo-pli-unlock icon-lg icon-fw"></i>
								Cerrar sesión
							</a>
						</div>
					</div>

					<ul id="mainnav-menu" class="list-group">
						<!--Category name-->
						<li class="list-header">Navigación</li>

						<!--Menu list item-->
						<li class="active-sub active">
							<a href="#" data-original-title="" title="">
								<i class="fa fa-user"></i>
								<span class="menu-title">Registrar</span>
								<i class="arrow"></i>
							</a>
							<!--Submenu-->
							<ul class="collapse" aria-expanded="false">
								<li class="">
									<a class="menu--link" href="<?= base_url('/administrativo/listarAdministrativos'); ?>">
										<i class="fa fa-circle-o"></i>Administrativo
									</a>
								</li>
								<li>
									<a class="menu--link" href="<?= base_url("/estudiante/listarEstudiantes") ?>">
										<i class="fa fa-circle-o"></i>Estudiante
									</a>
								</li>
								<li>
									<a class="menu--link" href="<?= base_url("/maestro/listarMaestros") ?>">
										<i class="fa fa-circle-o"></i>Maestro
									</a>
								</li>
								<li>
									<a class="menu--link" href="<?= base_url("/tutor/listarTutor") ?>">
										<i class="fa fa-circle-o"></i>Tutor
									</a>
								</li>
                                <li>
                                    <a class="menu--link" href="<?= base_url("/responsable/listarTutoresEstudiantes") ?>">
                                        <i class="fa fa-circle-o"></i>Asignar tutor
                                    </a>
                                </li>
							</ul>
						</li>

						<li class="">
							<a href="#" data-original-title="" title="">
								<i class="fa fa fa-id-card-o"></i>
								<span class="menu-title">Kardex Estudiantil</span>
								<i class="arrow"></i>
							</a>
							<!--Submenu-->
							<ul class="collapse" aria-expanded="false">
								<li><a class="menu--link" href="<?= base_url('/notas/listarEstudiantes') ?>"><i class="fa fa-circle-o"></i>Cursos</a></li>

								<li><a class="menu--link" href="<?= base_url('/Notas') ?>">Cursos</a></li>
							</ul>
						</li>

						<li class="">
							<a href="#" data-original-title="" title="">
								<i class="fa fa fa-th-list"></i>
								<span class="menu-title">Materias y cursos</span>
								<i class="arrow"></i>
							</a>
							<!--Submenu-->
							<ul class="collapse" aria-expanded="false">
								<li>
									<a class="menu--link" href="<?= base_url('/materia/listarMaterias') ?>">
										<i class="fa fa-circle-o"></i>Materias
									</a>
								</li>
								<li>
									<a class="menu--link" href="<?= base_url('/curso/listarCursos') ?>">
										<i class="fa fa-circle-o"></i>Cursos
									</a>
								</li>
							</ul>
						</li>
					</ul>

				</div>
				<div class="nano-pane" style="display: none;">
					<div class="nano-slider" style="height: 1719px; transform: translate(0px, 0px);"></div>
				</div>
			</div>
		</div>
		<!--================================-->
		<!--End menu-->
	</div>
</nav>
