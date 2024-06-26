<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("gestion ordenes", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

$email = $varsession;
// ---- Alarmas activas
require_once "../includes/config/db-config.php";

$sqlAlarmas = "SELECT COUNT(*) AS total_alarmas FROM alarmas WHERE estado = 'A'";
$resultAlarmas = $conexion->query($sqlAlarmas);

$totalAlarmas;

if ($resultAlarmas) {
  $row = $resultAlarmas->fetch_assoc();
  $totalAlarmas = $row['total_alarmas'];
}

// ---- Roles dinamicos

$sql = "SELECT * FROM usuarios WHERE email= '$varsession'";
$result = $conexion->query($sql);
$id;

while ($row = $result->fetch_assoc()) {

  $id = $row["id"];
}

$sql = "SELECT acceso FROM roles WHERE id_usuario = '$id'";
$result = $conexion->query($sql);

$roles = array();
while ($row = $result->fetch_assoc()) {
  $roles[] = $row['acceso'];
}

// --- Fin roles dinamicos

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../images/favicon.png ">
  <title>Logistics freedom</title>
  <link rel="stylesheet" href="../styles/alta-productos.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/orden.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>



<body>
  <nav class="navbar bg-body-tertiary fixed-top" style="padding: 0;">

    <div class="container-fluid">

      <div>
        <a class="navbar-brand" href="#">
          <img class="imageNav" src="../images/favicon.png" alt="logo">
        </a>

        <a class="btn btn-warning m-1" href="../includes/api/auth-api/logout.php"> Cerrar session </a>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <?php

if (in_array("alta productos", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" aria-current="page" href="/tp2/alta-productos">Alta de productos</a>
</li>';
}

if (in_array("gestion usuarios", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/gestion-usuarios/">Gestión de usuarios</a>
</li>';
}

if (in_array("reportes", $roles)) {
  echo '  <li class="nav-item">
<a class="nav-link" href="/tp2/reportes/">Reportes</a>
</li>';
}

if (in_array("stock", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/stock/">Stock</a>
</li>';
}

if (in_array("contacto", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/contacto/">Contacto</a>
</li>';
}

if (in_array("revisar contacto", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/revisar-contacto/">Revisar contacto</a>
</li>';
}

if (in_array("gestion alarmas", $roles) && $totalAlarmas == 0) {
  echo '<li class="nav-item">
        <a class="nav-link" href="/tp2/alarmas-reposicion/">Gestión de alarmas</a>
    </li>';
}

if (in_array("gestion alarmas", $roles) && $totalAlarmas > 0) {
  echo '<li class="nav-item">
        <a class="nav-link" href="/tp2/alarmas-reposicion/">
        Gestión de alarmas
        <span class="badge rounded-pill bg-danger">
        ' . $totalAlarmas . '+
        <span class="visually-hidden">unread messages</span>
        </span>

        </a>
      </li>';
}



if (in_array("visualizar alarmas", $roles) && $totalAlarmas == 0) {
  echo '<li class="nav-item">
        <a class="nav-link" href="/tp2/visualizar-alarmas/">Visualizar alarmas</a>
    </li>';
}

if (in_array("visualizar alarmas", $roles) && $totalAlarmas > 0) {
  echo '<li class="nav-item">
      <a class="nav-link" href="/tp2/visualizar-alarmas/">
      Visualizar de alarmas
      <span class="badge rounded-pill bg-danger">
      ' . $totalAlarmas . '+
      <span class="visually-hidden">unread messages</span>
      </span>

      </a>
    </li>';
}

if (in_array("gestion ordenes", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link active" href="/tp2/gestion-ordenes/">Gestión de órdenes</a>
</li>';
}

if (in_array("recepcion ordenes", $roles)) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/recepcion-ordenes/">Recepción de órdenes</a>
</li>';
}

if (in_array("ventas", $roles)) {
  echo '<li class="nav-item">
        <a class="nav-link" href="/tp2/ventas/ventas.php"> Ventas </a>
        </li>';
}


?>
            <li class="nav-item">
              <a class="nav-link" href="/tp2/historia/">Historia</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <dbody class="cardSection">

    <h1 class="title" style="margin-top: 3%;"> Alta Orden de Compra</h1>

    <h4 style="margin-left:3%; "> Administrador : <?php echo $email ?> </h4>

    <form class="formulario " action="../gestion-ordenes/altaOrden.php" method="post">
      <div>
        <label style="margin-left: 100px;" for="date" class="form-label"> Fecha:</label>
        <input type="date" name="date" id="date" placeholder=" aaaa/mm/dd" required autocomplete="off">
      </div>

      <div class="mb-1">
        <label style="margin-left: 100px;" for="cuit" class="form-label mt-3 mb-2"> CUIT:</label>
        <input type="text" class="form-label" name="cuit" id="cuit" placeholder=" CUIT Razón Social." required
          autocomplete="off" minlength="11" maxlength="11">
      </div>

      <div class="mb-3">
        <br>
        <label style="margin-left: 10px;" for="prov" class="form-label "> Nombre proveedor:</label>
        <input type="text" class="form-control mb-4" name="prov" id="prov" placeholder=" Ingrese proveedor." required
          autocomplete="off">
      </div>

      <div id='container'>

        <div>
          <div>
            <span style="margin-left: 7px;">SN. del producto:</span>
            <input type="text" name="producto[]" id="producto" placeholder=" Ingrese sn." required autocomplete="off"
              minlength="13" maxlength="13">
          </div>

          <div>
            <span style="margin-left: 7px;">Cantidad de prod:</span>
            <input name="cantidad[]" id="cantidad" placeholder=" Ingrese unidad." required autocomplete="off"
              type="number" min="0" step="1"
              onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
          </div>

        </div>

      </div>


      <input class="btn btn-warning" style="background-color:dodgerblue; margin-left: 5px;" type="button"
        value="agregar prod." id="agregar" />
      <br>
      <input type="submit" class="btn btn-success mt-3" style="margin-left: 7px;" value="Crear Orden"> </input>
      <br>

    </form>

    <input class="btn btn-warning mt-2" style="margin-left: 11px; margin-bottom: 10px; " type="button" name="cancelar"
      value="Cancelar" onclick="location.href='../gestion-ordenes/index.php'">

    <!--
    <a class="btn btn-success" style="margin-left: 10%; margin-bottom: 5px; "
      href="../gestion-ordenes/baja-ordenes/index.php"> Baja
      Orden </a>
          -->

    <a class="btn btn-success" style="margin-left: 10%; margin-bottom: 3px;"
      href="../gestion-ordenes/modificar-ordenes/index.php">
      Modificar / Eliminar</a>
  </dbody>

  <script src="../gestion-ordenes/js/codigo.js"></script>
  <script src="../gestion-ordenes/js/dom.js"></script>
  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>