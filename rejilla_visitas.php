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
if (!isset($_GET['ipp'])) 
    {
        $_GET['ipp'] = '';
    }
    
$result2 = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas");
$num_registros = count($result2);
$pages = new Paginator;
$pages->items_total = $num_registros;
$pages->paginate();

/* * ********* Fin Paginacion ************** */
if (isset($_GET["fecha"]) && $_GET["fecha"] <> "") 
    {
        $fecha = $_GET["fecha"];
        $result = $bd->consultarArray("select * from vw_rejilla_visitas where Fecha='" . $fecha . "' $pages->limit");
        $result2 = $bd->consultarArray("select * from vw_rejilla_visitas where Fecha='" . $fecha . "'");
        $num_registros = count($result2);
        $pages->items_total = $num_registros;
        $pages->paginate();
    } 
else 
    {

        if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") 
            {
        
                $cadena = $_GET["cadena"];
                $result = $bd->consultarArray("SELECT * from vw_rejilla_visitas
                where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%' $pages->limit");
                $result2 = $bd->consultarArray("SELECT * from vw_rejilla_visitas
                where Paciente like '%" . $cadena . "%' or Medico like '%" . $cadena . "%'");
                $num_registros = count($result2);
                $pages->items_total = $num_registros;
                $pages->paginate();
    } 
    
    else 
        {
   
            if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"])) 
                {
                    $result = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas ORDER BY Fecha asc LIMIT $inicio, $registros");
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

