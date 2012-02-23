<?php
include ("clase_rejilla_citas.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd = new bd();

/* * ********* Establecer consulta ************** */
$cadena = "";
$fecha = "";
$result = "";
$result2 = "";
/* * ********* Paginacion ************** */
if (!isset($_GET['ipp']))
    {
    $_GET['ipp'] = '';    
    }
$result2 = $bd->consultarArray("SELECT * FROM vw_rejilla_citas");
$num_registros = count($result2);
$pages = new Paginator;
$pages->items_total = $num_registros;
$pages->paginate();
/* * ********* Fin Paginacion ************** */
if (isset($_GET["fecha"]) && $_GET["fecha"] <> "") {
    $fecha = $_GET["fecha"];
    $result = $bd->consultarArray("select * from vw_rejilla_citas where Fecha='" . $fecha . "' $pages->limit");
    $result2 = $bd->consultarArray("select * from vw_rejilla_citas where Fecha='" . $fecha . "'");
    $num_registros = count($result2);
    $pages->items_total = $num_registros;
    $pages->paginate();
} else {
    if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") {
        $cadena = $_GET["cadena"];
        $result = $bd->consultarArray("SELECT * from vw_rejilla_citas where Paciente like '%" . $cadena . "%' 
                                or Medico like '%" . $cadena . "%'ORDER BY Fecha desc $pages->limit");
        $result2 = $bd->consultarArray("SELECT * from vw_rejilla_citas where Paciente like '%" . $cadena . "%' 
                                or Medico like '%" . $cadena . "%'");
        $num_registros = count($result2);
        $pages->items_total = $num_registros;
        $pages->paginate();        
    } else {
        if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"])) {
            /* paginacion (ordenado por fecha) */
            $result = $bd->consultarArray("SELECT * FROM vw_rejilla_citas ORDER BY Fecha desc $pages->limit");
        }
    }
}
/* * ****************** Fin establecer consulta **************** */

echo '<div class="titulo"><h3>CITAS</h3></div>';
?>
<div class="buscar">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
        <input type="text" name="cadena"/>
        <input class="boton" type="submit" name="buscar_cadena" value="Buscar Datos"/>
    </form>
</div>
<div class="buscar_fecha">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
        <input type="text" name="fecha"/>
        <input class="boton" type="submit" name="buscar_fecha" value="Buscar Fecha"/>
    </form>
</div>
<?php
if ($result) {
    $rejilla = new rejilla_citas($result, "index.php?cuerpo=form_citas.php&", "id", "Paciente");
    echo $rejilla->pintar();
    if ($result2<>"")       /* Incluir  en generador este if */
        {        
        if ($num_registros == 1) {
            echo '<p class="num_registros">Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p class="num_registros">Se han encontrado ' . $num_registros . ' registros.</p>';
        }
        }
    }else{
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
if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p class="error">Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                           
    echo '<p clase="mensaje">' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}                                         //Incluir en Generador
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_citas.php" />
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
    echo '<br/><br/>';
}
if($num_registros==0)
    {
    echo "<p clase='mensaje'>No se ha encontrado ningun registro.</p>";
    } 
/* * ********* Fin Paginacion ************** */
if(isset($_GET["buscar_fecha"]) or isset($_GET["buscar_cadena"]))
    {
    echo '<div class="cancelar">
            <form action="index.php" method="get">
                <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
                <input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
            </form>
        </div>';
    }
?>