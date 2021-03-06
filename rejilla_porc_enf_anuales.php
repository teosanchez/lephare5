<?php
include ("clase_rejilla_est_enfermedades.php");
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include ("clase_annos.php");
include ("clase_meses.php");

$bd = new bd();
$util = new utilidadesIU();
$anios = new anios();
$meses = new meses();

/* * ********* C�lculo de $anio  ************** */

if (isset($_GET["anios"])) {
    $anio = $_GET["anios"];
} else {
    $anio = date("Y");
}

/* * *********  Fin C�lculo de $anio ************** */

/* * ********* Establecer consulta ************** */
$cadena = "";
$result = "";
$result2 = "";    /* Incluir en generador el c�lculo de $result2 */
if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") { //Evalua si existe esta variable y si viene con algun contenido, la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    $cadena = $_GET["cadena"];
    $result = $bd->consultarArray("SELECT Enfermedad,Sexo,`%0a1`,`%2a4`,`%5a14`,`%Resto`
                from vw_porc_total_consultas_por_enfermedad_y_edad
                where Enfermedad like '%" . $cadena . "%'
                or Mes like '%" . $cadena . "%'
                and `anio`='" . $anio . "'");
    $result2 = $bd->consultar("SELECT Enfermedad,Sexo,`%0a1`,`%2a4`,`%5a14`,`%Resto`
                from vw_porc_total_consultas_por_enfermedad_y_edad
                where Enfermedad like '%" . $cadena . "%'
                or Mes like '%" . $cadena . "%'
                and `anio`='" . $anio . "'");
} else {
    if (!isset($_GET["cadena"])) {
        $result = $bd->consultarArray("SELECT Enfermedad,Sexo,`%0a1`,`%2a4`,`%5a14`,`%Resto`  
                FROM vw_porc_total_consultas_por_enfermedad_y_edad
                WHERE `anio`='" . $anio . "'");
        $result_total_edad = $bd->consultarArray("SELECT `%0a1`,`%2a4`,`%5a14`,`%Resto` 
                FROM vw_porc_total_consultas_por_edad_anuales
                WHERE `anio`='" . $anio . "'");
    }
}

/* * ****************** Fin establecer consulta **************** */

echo '<div class="titulo"><h3>ESTAD�STICAS ENFERMEDADES - PORCENTAJES ANUALES</h3></div>';
echo '<div class="titulo"><h2>' . "anio " . $anio . '</h2></div>';
?>

<div class="buscar">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="criterios_est_enf.php"/>
        <input type="text" name="cadena"/>
        <input class="boton" type="submit" name="buscar" value="Buscar"/>
    </form>
</div>

<?php
if ($result) {
    $rejilla = new rejilla_est_enfermedades($result);
    echo $rejilla->pintar2();

    if ($result2 <> "") /* Incluir  en generador este if */ {
        $num_registros = mysql_num_rows($result2);
        if ($num_registros == 1) {
            echo '<p>Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p>Se han encontrado ' . $num_registros . ' registros.</p>';
        }
    }
    echo '<h2>Porcentajes anuales de enfermedades, clasificados por edad</h2>';
    $rejilla_total_edad = new rejilla_est_enfermedades($result_total_edad);
    echo $rejilla_total_edad->pintar2();
} else /* Incluir en generador este else */ {
    if (isset($_GET["buscar_cadena"]) && $cadena == "") {
        echo '<p class="error">Introduzca el dato que desea buscar.</p>';
    } else {
        echo '<p class="error">No se ha encontrado ning�n registro.</p>';
    }
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
        <input type="hidden" name="cuerpo" value="criterios_est_enf.php"/>
        <input class="boton" type="submit" name="volver" value="Volver"/>
    </form>
</div>