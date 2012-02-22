<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");

include_once ("clase_paginador.php");

$bd = new bd();

/* * ********* Establecer consulta ************** */
$cadena = "";
$fecha = "";
$result = "";
$result2 = "";
/* * ********* Paginacion ************** */
if (!isset($_GET['ipp'])) {
    $_GET['ipp'] = '';
}
$result2 = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas");
$num_registros = count($result2);
$pages = new Paginator;
$pages->items_total = $num_registros;
$pages->paginate();
/* * ********* Fin Paginacion ************** */
if (isset($_GET["fecha"]) && $_GET["fecha"] <> "") {
    $fecha = $_GET["fecha"];
    $result = $bd->consultarArray("select * from vw_rejilla_visitas where Fecha='" . $fecha . "' $pages->limit");
    $result2 = $bd->consultarArray("select * from vw_rejilla_visitas where Fecha='" . $fecha . "'");
    $num_registros = count($result2);
    $pages->items_total = $num_registros;
    $pages->paginate();
} else {
    if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") {
        $cadena = $_GET["cadena"];
        $result = $bd->consultarArray("SELECT * from vw_rejilla_visitas
        where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%' $pages->limit");
        $result2 = $bd->consultarArray("SELECT * from vw_rejilla_visitas
        where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%'");
        $num_registros = count($result2);
        $pages->items_total = $num_registros;
        $pages->paginate();
    } else {
        if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"])) {
            /* paginacion (ordenado por fecha) */

            $result = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas ORDER BY Fecha asc LIMIT $inicio, $registros");

            $bd = new bd();
            /*             * ********* Establecer consulta ************** */
            $cadena = "";
            $fecha = "";
            $hora = "";
            $result = "";
            $result2 = "";
            /*             * ********* Paginacion ************** */
            $registros = 2;
            $inicio = 0;
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
                $inicio = ($pagina - 1) * $registros;
            } else {
                $pagina = 1;
            }
            $resultados = $bd->consultar("SELECT * FROM vw_rejilla_visitas");

            $total_registros = mysql_num_rows($resultados);
            $total_paginas = ceil($total_registros / $registros);
            /*             * ********* Fin Paginacion ************** */

            if (isset($_GET["fecha"]) && $_GET["fecha"] <> "") {
                $fecha = $_GET["fecha"];
                $result = $bd->consultarArray("select * from vw_rejilla_visitas where Fecha='" . $fecha . "'");
                $result2 = $bd->consultar("select * from vw_rejilla_visitas where Fecha='" . $fecha . "'");
            } else {
                if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") {
                    $cadena = $_GET["cadena"];
                    $result = $bd->consultarArray("SELECT * from vw_rejilla_visitas
                where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%'");
                    $result2 = $bd->consultar("SELECT * from vw_rejilla_visitas
                where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%'");
                } else {
                    if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"])) {
                        /* paginacion (ordenado por fecha) */
                        $result = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas ORDER BY Fecha asc LIMIT $inicio, $registros");
                    }
                }
            }

            $result = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas ORDER BY Fecha asc  $pages->limit");
        }
    }
}
echo '<class="titulo"><h3>VISITAS</h3></div>';
?>

<div class="buscar">
    <form action="index.php" method="get">       
        <input type="text" name="cadena"/>
        <input type="hidden" name="cuerpo" value="rejilla_visitas.php" />
        <input class="boton" type="submit" name="buscar_cadena" value="Buscar Datos"/>
    </form>
</div> 

<div class="buscar_fecha">
    <form action="index.php" method="get">        
        <input type="text" name="fecha"/>
        <input type="hidden" name="cuerpo" value="rejilla_visitas.php" />
        <input class="boton" type="submit" name="buscar_fecha" value="Buscar Fecha"/>
    </form>
</div>

<?php
if ($result) {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_visitas.php&", "id", "Paciente");
    echo $rejilla->pintar();
    if ($result2 <> "") /* Incluir  en generador este if */ {
        if ($num_registros == 1) {
            echo '<br/>Se ha encontrado ' . $num_registros . ' registro.';
        } else {
            echo '<br/>Se han encontrado ' . $num_registros . ' registros.';
        }
    }
} else /* Incluir en generador este else */ {
    if (isset($_GET["buscar_fecha"]) && $fecha == "") {
        echo '<p class="error">Introduzca una fecha.</p>';
        $num_registros = '';
    } else {
        if (isset($_GET["buscar_cadena"]) && $cadena == "") {
            echo '<p class="error">Introduzca el dato que desea buscar.</p>';
            $num_registros = '';
        }
    }
}

if (isset($_GET['msj2']) && $_GET['msj2'] != "") {   //Incluir en Generador   
    echo '<p>' . $_GET['msj2'] . '</p>';            //Incluir en Generador
} //Incluir en Generador
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_visitas.php" />
        <input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>

<?php
/* * ********* Paginacion ************** */
if ($num_registros > 10) {
    echo '&nbsp;&nbsp;';
    echo $pages->display_jump_menu();
    echo '&nbsp;&nbsp;';
    echo $pages->display_items_per_page();
    echo '&nbsp;&nbsp;';
    echo "Pagina: $pages->current_page de $pages->num_pages";
}
if ($num_registros == 0) {
    echo "No se ha encontrado ningun registro.";
}
/* * ********* Fin Paginacion ************** */
?>
