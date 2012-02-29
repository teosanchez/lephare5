<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");

$bd = new bd();
if (isset($_GET["todos"])) {
    $result = $bd->consultarArray("select * from visita_enfermedad");
} elseif (isset($_GET["buscar"])) {
    $id_visita = $_GET["id_visita"];
    $result = $bd->consultarArray("select * from visita_enfermedad where id_visita='" . $id_visita . "'");
} else {
    $result = $bd->consultarArray("select * from visita_enfermedad order by id_visita limit 10");
}
?>

<div class="titulo">
    <h3>VISITA Y ENFERMEDAD</h3>
</div>

<div class="buscar">
    <form action="index.php" method="get">
        <input type="text" name="id_visita"/>
        <input type="hidden" name="cuerpo" value="rejilla_visita_enfermedad.php" />
        <input class="boton" type="submit" name="buscar" value="Buscar"/>
    </form>
</div>

<?php
if ($result) {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_visita_enfermedad.php&", "id", "id");
    echo $rejilla->pintar();
}

if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                              //Incluir en Generador 
    echo '<p>' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}                                                   //Incluir en Generador

?> 

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_visita_enfermedad.php" />
        <input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>
