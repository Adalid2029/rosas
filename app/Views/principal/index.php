<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'cabecera_link.php' ?>
</head>

<body>
    <section class="bienvenidos">

        <header class="encabezado navbar-fixed-top" role="banner" id="encabezado">
            <div class="container">
                <a href="<?= base_url("/")?>" class="logo">
                    <img src="<?= base_url("principal/images/logo5.png")?>" alt="Logo del sitio">
                </a>

                <button type="button" class="boton-buscar" data-toggle="collapse" data-target="#bloque-buscar" aria-expanded="false">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
                <button type="button" class="boton-menu hidden-md-up" data-toggle="collapse" data-target="#menu-principal" aria-expanded="false">
                    <i class="fa fa-bars" aria-hidden="true"></i></button>

                <form action="#" id="bloque-buscar" class="collapse">
                    <div class="contenedor-bloque-buscar">
                        <input type="text" placeholder="Buscar...">
                        <input type="submit" value="Buscar">
                    </div>
                </form>

                <nav id="menu-principal" class="collapse">
                    <ul>
                        <li class="active">
                            <a class="menu--link" href="<?= base_url("/")?>"> Inicio</a>
                        </li>
                        <li >
                            <a class="menu--link"  href="<?= base_url("/home/nosotros")?>"> Nosotros</a>
                        </li>
                        <li>
                            <a class="menu--link" href="<?= base_url("/home/contacto")?>"> Contacto</a>
                        </li>
                        <li>
                            <a class="menu--link" href="<?= base_url("/auth/login")?>"> Iniciar Sesión</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </header>


        <div class="texto-encabezado text-xs-center">

            <div class="container" id="titulos">
                <h1 class="display-4 wow bounceIn">Unidad Educativa Las Rosas</h1>
                <p class="wow bounceIn" data-wow-delay=".3s">Cuando enseñar es un arte, aprender en un placer.</p>
                <a href="<?= base_url("/home/contacto")?>" class="btn btn-primary btn-lg">Ponte en contacto</a>
            </div>

        </div>
        <div class="flecha-bajar text-xs-center">
            <a data-scroll href="#agencia"> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
        </div>

    </section>
    <section class="agencia p-y-1" id="agencia">

        <div class="container">


            <div class="row">

                <div class="col-md-8 col-xl-9 wow bounceIn" data-wow-delay=".3s">
                    <h2 class="h3 text-xs-center text-md-left font-weight-bold">Nuestra Historia</h2>
                    <p style="text-align: justify;">La unidad educativa “Las Rosas” fue gestionada para su creación desde la gestión 2000 por la junta de vecinos y se consolidó con inicios de actividades educativas y su correspondiente resolución de funcionamiento el 8 de julio de 2002 en sus niveles inicial y primaria, el 25 de agosto del mismo año se logra su correspondiente resolución ministerial, en la gestión 2009 se complementa con nivel secundaria del cual promociona los primeros bachilleres en la gestión 2014. </p>
                    <p style="text-align: justify;">En la actualidad cuenta con un personal administrativo, maestras y maestros selectos quienes impulsan la educación y fortalecimiento del conocimiento a más de 450 estudiantes en los niveles inicial, primaria y secundaria.</p>

                </div>
                <div class="col-md-4 col-xl-3 wow bounceIn" data-wow-delay=".6s">
                    <img src="<?= base_url("principal/images/logo_oficial.png")?>" alt="Escudo de la Unidad Educativa">
                </div>
            </div>
        </div>

    </section>

    <section class="ultimos-proyectos p-y-1">
        <div class="container">
            <h2 class="text-xs-center font-weight-bold">Fotos de la Unidad Educativa</h2>

            <div class="owl-carousel">
                <a href="#">
                    <h4>Las Rosas</h4>
                    <img src="<?= base_url("principal/images/imagen1.jpg")?>" alt="Las Rosas">
                </a>

                <a href="#">
                    <h4>Plantel Docentes</h4>
                    <img src="<?= base_url("principal/images/imagen2.jpg")?>" alt="Las Rosas">
                </a>

                <a href="#">
                    <h4>Día del Niño(a)</h4>
                    <img src="<?= base_url("principal/images/imagen3.jpg")?>" alt="Las Rosas">
                </a>

                <a href="#">
                    <h4>Promoción 2019</h4>
                    <img src="<?= base_url("principal/images/imagen4.jpg")?>" alt="Las Rosas">
                </a>

                <a href="#">
                    <h4>Las Rosas</h4>
                    <img src="<?= base_url("principal/images/imagen1.jpg")?>" alt="Las Rosas">
                </a>


            </div>
        </div>
    </section>

    <?php require_once 'footer.php' ?>

    <a data-scroll class="ir-arriba" href="#encabezado"><i class="fa  fa-arrow-circle-up" aria-hidden="true"> </i> </a>

    <!-- Carga de archivos  JS -->

    <script src="<?= base_url("principal/js/jquery.min.js")?>"></script>
    <script src="<?= base_url("principal/js/bootstrap.min.js")?>"></script>
    <script src="<?= base_url("principal/js/owl.carousel.min.js")?>"></script>
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            autoWidth: false,
            navText: ['<i class="fa fa-arrow-circle-left" title="Anterior"></i>', '<i class="fa  fa-arrow-circle-right" title="Siguiente"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                500: {
                    items: 2,
                    margin: 20
                },
                800: {
                    items: 3,
                    margin: 20
                },
                1000: {
                    items: 4,
                    margin: 20
                }
            }
        })
    </script>
    <script src="<?= base_url("principal/js/wow.min.js")?>"></script>
    <script src="<?= base_url("principal/js/smooth-scroll.min.js")?>"></script>
    <script src="<?= base_url("principal/js/sitio.js")?>"></script>



</body>

</html>
