<nav id="mainnav-container">
	<div id="mainnav">
		<div id="mainnav-menu-wrap">
			<div class="nano has-scrollbar">
				<div class="nano-content" tabindex="0" style="right: -17px;">
					<div id="mainnav-profile" class="mainnav-profile">
						<div class="profile-wrap text-center">
							<div class="pad-btm">
								<?php
								if (isset($user["sexo"])) {
									if ($user["sexo"] == "M") {
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
								<p class="mnp-name"><?= (isset($user["nombres"])) ? $user["nombres"] . " " . $user["paterno"] : "Invitado"; ?></p>
								<span class="mnp-desc"><?= (isset($user["nombre_grupo"])) ? $user["nombre_grupo"] : "INVITADO"; ?></span>
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
						<li class="list-header">Navegación</li>

						<!--Menu list Dashboard -->
						<li class="active-sub active">
							<a class="menu--link" href="<?= base_url('/administrativo'); ?>" data-original-title="" title="">
								<i class="fa fa fa-home"></i>
								<span class="menu-title">Principal</span>
							</a>
						</li>

						<!--Menu list Registrar -->
						<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA'])) : ?>
							<li class="">
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
										<a class="menu--link" href="<?= base_url("/maestro/listarMaestros") ?>">
											<i class="fa fa-circle-o"></i>Maestro
										</a>
									</li>

									<li>
										<a class="menu--link" href="<?= base_url("/estudiante/listarEstudiantes") ?>">
											<i class="fa fa-circle-o"></i>Estudiante
										</a>
									</li>

									<li>
										<a class="menu--link" href="<?= base_url("/tutor/listarTutor") ?>">
											<i class="fa fa-circle-o"></i>Tutor
										</a>
									</li>

								</ul>
							</li>
						<?php endif; ?>
						<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA'])) : ?>
							<!--Menu list Cursos y Areas -->
							<li>
								<a href="#" data-original-title="" title="">
									<i class="fa fa fa-list-alt"></i>
									<span class="menu-title">Cursos y Areas</span>
									<i class="arrow"></i>
								</a>
								<!--Submenu-->
								<ul class="collapse" aria-expanded="false">
									<li>
										<a class="menu--link" href="<?= base_url('/materia/listarMaterias') ?>">
											<i class="fa fa-circle-o"></i>Areas
										</a>
									</li>
									<li>
										<a class="menu--link" href="<?= base_url('/nivel/listarNiveles') ?>">
											<i class="fa fa-circle-o"></i>Crear Curso
										</a>
									</li>
									<li>
										<a class="menu--link" href="<?= base_url('/paralelo/listarParalelos') ?>">
											<i class="fa fa-circle-o"></i>Crear Paralelos
										</a>
									</li>
									<li>
										<a class="menu--link" href="<?= base_url('/curso/listarCursos') ?>">
											<i class="fa fa-circle-o"></i>Asignar Curso
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
						<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA'])) : ?>
							<!--Menu list Asignar maestros y estudiantes -->
							<li class="">
								<a href="#" data-original-title="" title="">
									<i class="fa fa fa-th-list"></i>
									<span class="menu-title">Asignar Maestros y Estudiantes</span>
									<i class="arrow"></i>
								</a>
								<!--Submenu-->
								<ul class="collapse" aria-expanded="false">
									<li>
										<a class="menu--link" href="<?= base_url('/maestro/listarAsignacionesMateriaMaestro') ?>">
											<i class="fa fa-circle-o"></i>Asignar Maestro
										</a>
									</li>

									<li>
										<a class="menu--link" href="<?= base_url('/curso/listarAsignacionesCursoEstudiante') ?>">
											<i class="fa fa-circle-o"></i>Asignar Estudiante
										</a>
									</li>

									<li>
										<a class="menu--link" href="<?= base_url("/responsable/listarTutoresEstudiantes") ?>">
											<i class="fa fa-circle-o"></i>Asignar tutor
										</a>
									</li>

								</ul>

							</li>
						<?php endif; ?>
						<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA', 'MAESTRO', 'ESTUDIANTE'])) : ?>
							<!--Menu list Asistencias y calificación -->
							<li class="">
								<a href="#" data-original-title="" title="">
									<i class="fa fa fa-id-card-o"></i>
									<span class="menu-title">Asistencias y Calificaciones</span>
									<i class="arrow"></i>
								</a>
								<!--Submenu-->
								<ul class="collapse" aria-expanded="false">
									<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA', 'MAESTRO'])) : ?>
										<li><a class="menu--link" href="<?= base_url('/Asistencia') ?>"><i class="fa fa-circle-o"></i> Asistencia</a></li>
									<?php endif ?>
									<li><a class="menu--link" href="<?= base_url('/Notas') ?>"><i class="fa fa-circle-o"></i> Calificaciones</a></li>
								</ul>
							</li>
						<?php endif; ?>

						<?php if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA', 'MAESTRO'])) : ?>
							<!--Menu list Kardex Estudiantil -->
							<li class="">
								<a href="#" data-original-title="" title="">
									<i class="fa fa fa-address-book-o"></i>
									<span class="menu-title">Kardex Estudiantil</span>
									<i class="arrow"></i>
								</a>
								<!--Submenu-->
								<ul class="collapse" aria-expanded="false">
									<li>
										<a class="menu--link" href="<?= base_url('kardex/listarKardex') ?>">
											<i class="fa fa-circle-o"></i>Kardex
										</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
						<!--Menu list Reportes -->
						<li class="">
							<a href="#" data-original-title="" title="">
								<i class="fa fa fa-print"></i>
								<span class="menu-title">Reportes</span>
								<i class="arrow"></i>
							</a>

							<!--Submenu-->
							<ul class="collapse" aria-expanded="false">
								<li>
									<a class="menu--link" href="<?= base_url('asistencia/imprimirAsistencia') ?>">
										<i class="fa fa-circle-o"></i>Asistencia
									</a>
								</li>

								<li>
									<a class="menu--link" href="<?= base_url('reporte/imprimirSeguimiento') ?>">
										<i class="fa fa-circle-o"></i>Seguimiento Acad.
									</a>
								</li>

								<li>
									<a class="menu--link" href="<?= base_url('reporte/imprimirCentralizadorInterno') ?>">
										<i class="fa fa-circle-o"></i>Centralizador Int.
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="nano-pane">
					<div class="nano-slider" style="height: 1719px; transform: translate(0px, 0px);"></div>
				</div>
			</div>
		</div>
	</div>
</nav>