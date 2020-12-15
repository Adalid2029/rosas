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
          <img src="<?= base_url("principal/images/logo5.png") ?>" alt="Logo del sitio" />
        </a>

        <button type="button" class="boton-buscar" data-toggle="collapse" data-target="#bloque-buscar" aria-expanded="false">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
        <button type="button" class="boton-menu hidden-md-up" data-toggle="collapse" data-target="#menu-principal" aria-expanded="false">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <form action="#" id="bloque-buscar" class="collapse">
          <div class="contenedor-bloque-buscar">
            <input type="text" placeholder="Buscar..." />
            <input type="submit" value="Buscar" />
          </div>
        </form>

        <nav id="menu-principal" class="collapse">
          <ul>
            <li>
              <a class="menu--link" href="<?= base_url("/") ?>"> Inicio</a>
            </li>
            <li class="active">
              <a class="menu--link" href="<?= base_url("/home/nosotros") ?>"> Nosotros</a>
            </li>
            <li>
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
      <div class="container">
        <h1 class="display-4">Nosotros</h1>
        <p class="wow bounceIn" data-wow-delay=".3s">
          ¿Quienes somos? y ¿Que hacemos?.
        </p>
      </div>
    </div>
  </section>
  <section class="ruta p-y-1">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 text-xs-right">
          <a href="<?= base_url("/") ?>">Inicio</a> » Nosotros
        </div>
      </div>
    </div>
  </section>
  <main class="p-y-1">
    <div class="container">
      <div class="row">
        <article class="col-md-8">
          <h2>Trabajamos en la educación de tus hijos(as)</h2>
          <p>
            NETWORK apuesta por la simplicidad, la actualidad y la
            originalidad. Creemos que la innovación creativa es la única vía
            para promover y fomentar contenidos de calidad que fortalezcan la
            confianza de los usuarios en las posibilidades y nuevos usos de
            los productos digitales.
          </p>
          <p>
            Nuestro objetivo es conseguir que clientes y usuarios se sientan
            conectados en el nuevo mundo de la información con servicios y
            contenidos que no dificulten su relación, sino que la simplifiquen
            y la conviertan en un hecho cotidiano, agradable y satisfactorio
          </p>

          <div id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <h4 class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#tab-mision">
                  MISIÓN
                </a>
              </h4>
              <div id="tab-mision" class="panel-collapse collapse in">
                <p>
                  La Unidad Educativa forma estudiantes íntegros, con valores
                  humanos, académicos y solidarios, preparación académica, con
                  la participación de docentes y padres de familia,
                  comprometida con una educación, desde la realidad.
                </p>
              </div>
            </div>

            <div class="panel panel-default">
              <h4 class="panel-heading">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#tab-vision">VISIÓN</a>
              </h4>
              <div id="tab-vision" class="panel-collapse collapse">
                <p>
                  La Unidad Educativa es una institución, legalmente
                  constituida, forma personas íntegras, con valores humanos,
                  sólida preparación académica y vocación de servicio, con la
                  participación de docentes y padres de familia comprometidos
                  con una educación desde la realidad, con la fuerza de su
                  carisma.
                </p>
              </div>
            </div>

            <div class="panel panel-default">
              <h4 class="panel-heading">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#tab-valores">
                  VALORES
                </a>
              </h4>
              <div id="tab-valores" class="panel-collapse collapse">
                <p>
                  La Unidad Educativa formando personas comprometidas con las virtudes y valores
                  que deben formar parte de la vida en sociedad, tales como: solidaridad, responsabilidad,
                  reciprocidad, respeto, complementariedad, tolerancia, honestidad, equilibrio, justicia, equidad,
                  igualdad de oportunidades, compromiso y disciplina.
                </p>
              </div>
            </div>
          </div>
        </article>
        <aside class="col-md-4">
          <img src="<?= base_url("principal/images/nosotros.svg") ?>" alt="Nosotros" />
        </aside>
      </div>
    </div>
  </main>

  <?php require_once 'footer.php' ?>

  <a data-scroll class="ir-arriba" href="#encabezado"><i class="fa  fa-arrow-circle-up" aria-hidden="true"> </i>
  </a>

  <!-- Carga de archivos  JS -->

  <script src="<?= base_url("principal/js/jquery.min.js") ?>"></script>
  <script src="<?= base_url("principal/js/bootstrap.min.js") ?>"></script>
  <script src="<?= base_url("principal/js/wow.min.js") ?>"></script>
  <script src="<?= base_url("principal/js/smooth-scroll.min.js") ?>"></script>
  <script src="<?= base_url("principal/js/sitio.js") ?>"></script>
</body>

</html>