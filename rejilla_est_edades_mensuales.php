<?php
include ("clase_rejilla_est_edades.php");
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include ("clase_annos.php");
include ("clase_meses.php");

$bd = new bd();
$util = new utilidadesIU();
$anios = new anios();
$meses = new meses();

/* * ********* C�lculo de $anio y $mes  ************** */

$nom_meses = $bd->consultarArray("select nom_mes from t_meses");

if (isset($_GET["anios"])) {
    $anio = $_GET["anios"];
} else {
    $anio = date("Y");
}
if (isset($_GET["Meses"])) {
    $indice_mes = $_GET["Meses"] - 1;
} else {
    $indice_mes = date("n") - 1;
}
$mes = $nom_meses[$indice_mes]['nom_mes'];
$id_mes = $indice_mes + 1;
/* * *********  Fin C�lculo de $anio y $mes  ************** */

/* * ********* Establecer consulta ************** */
$consulta = "SELECT Sexo,0a1,2a4,5a14,Resto,Total 
        FROM vw_total_consultantes_nuevos_mensuales
        WHERE `anio`='" . $anio . "' and Mes='" . $id_mes . "'";
//var_dump($consulta);
$result_total_pacientes_nuevos = $bd->consultarArray($consulta);

$consulta = "SELECT Sexo,0a1,2a4,5a14,Resto,Total
        FROM vw_total_consultantes_viejos_mensuales
        WHERE `anio`='" . $anio . "' and Mes='" . $id_mes . "'";
//var_dump($consulta);
$result_total_pacientes_viejos = $bd->consultarArray($consulta);

$consulta = "SELECT Sexo,0a1,2a4,5a14,Resto,Total
        FROM vw_total_consultantes_mensuales
        WHERE `anio`='" . $anio . "' and Mes='" . $id_mes . "'";
//var_dump($consulta);
$result_total_pacientes = $bd->consultarArray($consulta);



/* * ****************** Fin establecer consulta **************** */

echo '<div class="titulo"><h3>ESTAD�STICAS PACIENTES NUEVOS/VIEJOS - MENSUALES</h3></div>';
echo '<div class="titulo"><h2>' . $mes . " " . $anio . '</h2></div>';

echo '<h2>Total de pacientes nuevos, clasificados por sexo y edad</h2>';
if ($result_total_pacientes_nuevos) {
    $rejilla_pacientes_nuevos = new rejilla_est_edades($result_total_pacientes_nuevos);
    echo $rejilla_pacientes_nuevos->pintar();
} else {
    echo '<p class="error">No se ha encontrado ning�n registro.</p>';
}

echo '<h2>Total de pacientes viejos, clasificados por sexo y edad</h2>';
if ($result_total_pacientes_viejos) {
    $rejilla_pacientes_viejos = new rejilla_est_edades($result_total_pacientes_viejos);
    echo $rejilla_pacientes_viejos->pintar();
} else {
    echo '<p class="error">No se ha encontrado ning�n registro.</p>';
}

echo '<h2>Total de pacientes, clasificados por sexo y edad</h2>';
if ($result_total_pacientes) {
    $rejilla_pacientes = new rejilla_est_edades($result_total_pacientes);
    echo $rejilla_pacientes->pintar();
} else {
    echo '<p class="error">No se ha encontrado ning�n registro.</p>';
}


if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p>Error: ' . $_GET['msj'] . '</p>';
}

if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                            //Incluir en Generador   
    echo '<p>' . $_GET['msj2'] . '</p>';             //Incluir en Generador   
} //Incluir en Generador 
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="criterios_est_edades.php"/>
        <input class="boton" type="submit" name="volver" value="Volver"/>
    </form>
</div>