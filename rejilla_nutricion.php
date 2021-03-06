<?php
include ("clase_rejilla_nutricion.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd = new bd();
/* * ********* Establecer consulta ************** */
$result = "";
$result2 = "";
/* * ********* Paginacion ************** */
if (!isset($_GET['ipp']))
    {
    $_GET['ipp'] = '';    
    }
$result2 = $bd->consultarArray("SELECT * FROM vw_rejilla_nutricion");
$num_registros = count($result2);
$pages = new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
$result = $bd->consultarArray("select * from vw_rejilla_nutricion ORDER BY Paciente asc  $pages->limit");
/* * ********* Fin Paginacion ************** */

if ($result) {
    echo '<div class="titulo"><h3>NUTRICIÓN</h3></div>';
    $rejilla = new rejilla($result, "index.php?cuerpo=form_nutricion.php&", "id", "Paciente");
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
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_nutricion.php" />
        <input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>

<?php
/* * ********* Paginación ************** */
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
/* * ********* Fin Paginación ************** */
?>
