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
								<img class="img-circle img-md" src="img/personas/persona.gif" alt="Profile Picture">
							</div>
							<a href="index.html#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
								<span class="pull-right dropdown-toggle">
									<i class="dropdown-caret"></i>
								</span>
								<p class="mnp-name">Aaron Chavez</p>
								<span class="mnp-desc">aaron.cha@themeon.net</span>
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
								<span class="menu-title">Registro persona</span>
							</a>
						</li>

                        <li class="">
                            <a href="#" data-original-title="" title="">
                                <i class="demo-dpi-home"></i>
                                <span class="menu-title">Dashboard</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse" aria-expanded="false">

                                <li class="active-link">
                                    <a class="menu--link" href="<?= base_url('/home/preview') ?>">Dashboard 1</a>
                                </li>

                                <li><a href="dashboard-2.html">Dashboard 2</a></li>
                                <li><a href="dashboard-3.html">Dashboard 3</a></li>
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
