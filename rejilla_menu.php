<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");
$bd = new bd();
$cadena = "";
$result = "";
$result2 = "";

if (isset($_GET["todos"])) {
    $result = $bd->consultarArray("select * from vw_rejilla_menu");
} else {
    if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") {
        $cadena = $_GET["cadena"];
        $result = $bd->consultarArray("SELECT * from vw_rejilla_menu
                                     where Enlace like '%" . $cadena . "%' 
                                     or Texto like '%" . $cadena . "%'");
        $result2 = $bd->consultar("SELECT * from vw_rejilla_menu
                                     where Enlace like '%" . $cadena . "%' 
                                     or Texto like '%" . $cadena . "%'");
    } else {
        if (!isset($_GET["buscar_cadena"])) {
            $result = $bd->consultarArray("select * from vw_rejilla_menu order by Texto limit 10");
        }
    }
}

/* * ****************** Fin establecer consulta **************** */
?>

<div class="titulo">
    <h3>MENÚ</h3>
</div>

<div class="buscar">
    <form action="index.php" method="get">    
        <input type="text" name="cadena"/>
        <input type="hidden" name="cuerpo" value="rejilla_menu.php" />
        <input class="boton" type="submit" name="buscar_cadena" value="Buscar"/>
    </form>
</div>  

<?php
if ($result) {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_menu.php&", "id", "Texto");
    echo $rejilla->pintar();
    if ($result2 <> "") { /* Incluir  en generador este if */
        $num_registros = mysql_num_rows($result2);
        if ($num_registros == 1) {
            echo '<p>Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p>Se han encontrado ' . $num_registros . ' registros.</p>';
        }
    }
} else { /* Incluir en generador este else */
    if (isset($_GET["buscar_cadena"]) && $cadena == "") {
        echo '<p class="error">Introduzca el dato que desea buscar.</p>';
    } else {
        echo '<p class="error">No se ha encontrado ningún registro.</p>';
    }
}

if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p>Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "") {  //Incluir en Generador                                               
    echo '<p>' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_menu.php" />
        <br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>

