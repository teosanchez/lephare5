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
$pages->items_total=$num_registros;
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
            /* paginacion (ordenado por fecha) */
            $result = $bd->consultarArray("SELECT * FROM vw_rejilla_visitas ORDER BY Fecha asc  $pages->limit");
            }
        }
    }
<<<<<<< HEAD
echo '<div class="titulo">';    
echo '<h3>LISTADO VISITAS</h3><br/>';    
echo '</div>';
=======
echo '<div class="titulo"><h3>VISITAS</h3></div>';
?>
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba

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
if ($result) 
    {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_visitas.php&", "id", "Paciente");
    echo $rejilla->pintar();
    if ($result2 <> "") /* Incluir  en generador este if */
        {
        if ($num_registros == 1) {
            echo '<p class="num_registros">Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p class="num_registros">Se han encontrado ' . $num_registros . ' registros.</p>';
        }
        }
    } 
    else /* Incluir en generador este else */ 
        {
        if (isset($_GET["buscar_fecha"]) && $fecha == "")
            {
            echo '<p class="error">Introduzca una fecha.</p>';
            $num_registros = '';
            } 
        else
            {
            if (isset($_GET["buscar_cadena"]) && $cadena == "")
                {
                echo '<p class="error">Introduzca el dato que desea buscar.</p>';
                $num_registros = '';
                }
            }
        }
if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p>Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "")
    {   //Incluir en Generador   
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
/*********** Paginacion ***************/
if ($num_registros > 10)
    {
    echo '&nbsp;&nbsp;';
    echo $pages->display_jump_menu();
    echo '&nbsp;&nbsp;';
    echo $pages->display_items_per_page();
    echo '&nbsp;&nbsp;';
    echo "Pagina: $pages->current_page de $pages->num_pages";
    }
if($num_registros==0)
    {
    echo "<p clase='mensaje'>No se ha encontrado ningun registro.</p>";
    }   
/*********** Fin Paginacion ***************/
if(isset($_GET["buscar_fecha"]) or isset($_GET["buscar_cadena"]))
    {
    echo '<div class="cancelar">
            <form action="index.php" method="get">
                <input type="hidden" name="cuerpo" value="rejilla_visitas.php" />
                <input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
            </form>
        </div>';
    }
?>
