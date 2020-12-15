<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'cabecera_link.php' ?>
</head>

<body class="paginas-internas">
    <section class="bienvenidos">

        <header class="encabezado navbar-fixed-top" role="banner" id="encabezado">
            <div class="container">
                <a href="<?= base_url("/") ?>" class="logo">
                    <img src="<?= base_url("principal/images/logo5.png") ?>" alt="Logo del sitio">
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
                        <li>
                            <a class="menu--link" href="<?= base_url("/") ?>"> Inicio</a>
                        </li>
                        <li>
                            <a class="menu--link" href="<?= base_url("/home/nosotros") ?>"> Nosotros</a>
                        </li>
                        <li class="active">
                            <a class="menu--link" href="<?= base_url("/home/contacto") ?>"> Contacto</a>
                        </li>
                        <li>
                            <a class="menu--link" href="<?= base_url("/auth/login") ?>"> Iniciar Sesión</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </header>


        <div class="texto-encabezado text-xs-center">

            <div class="container" style="z-index: 3">
                <h1 class="display-4 wow bounceIn">Contacto</h1>
                <p class="wow bounceIn" data-wow-delay=".3s">Estamos listos para ayudarte</p>

            </div>

        </div>

    </section>
    <section class="ruta p-y-1" style="z-index: 3333">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-xs-right">
                    <a href="<?= base_url("/") ?>">Inicio</a> » Contacto

                </div>
            </div>
        </div>
    </section>
    <main class="p-y-1" style="z-index: 3333">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <h2 class="m-b-2">Formulario de contacto</h2>


                    <form action="#">

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label">Nombre</label>

                            <div class="col-md-8">
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" data-toggle="tooltip" data-placement="top" title="Ingrese su nombre completo">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">Email</label>

                            <div class="col-md-8">
                                <input class="form-control" type="text" id="email" name="email" placeholder="Ingrese su email" data-toggle="tooltip" data-placement="top" title="Ingrese su email">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="mensaje" class="col-md-4 col-form-label">Mensaje</label>

                            <div class="col-md-8">
                                <textarea class="form-control" rows="5" id="mensaje" name="mensaje" placeholder="Ingrese su mensaje" data-toggle="tooltip" data-placement="top" title="Ingrese un mensaje"></textarea>

                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                <button type="reset" class="btn btn-secondary">Limpiar</button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="col-md-4">

                    <h3>Detalles de contacto</h3>
                    <p style="text-align: justify;">
                        El Sistema de Seguimiento y Comunicación Inmediata de la Unidad Educativa Las Rosas, les invita a realizar sugerencias
                        a sus usuarios a través del formulario de contacto, para poder mejorar y fortalecer nuestro sistema, para el mejor
                        servicio de seguimiento de la educación de nuestros educandos. La dirección y la administración de sistema les agradece
                        de antemano por su participación.
                    </p>


                </div>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php' ?>

    <a data-scroll class="ir-arriba" href="#encabezado"><i class="fa  fa-arrow-circle-up" aria-hidden="true"> </i> </a>

    <!-- Carga de archivos  JS -->

    <script src="<?= base_url("principal/js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("principal/js/tether.min.js") ?>"></script>
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <script src="<?= base_url("principal/js/bootstrap.min.js") ?>"></script>
    <script src="<?= base_url("principal/js/wow.min.js") ?>"></script>
    <script src="<?= base_url("principal/js/smooth-scroll.min.js") ?>"></script>
    <script src="<?= base_url("principal/js/sitio.js") ?>"></script>

</body>

</html>