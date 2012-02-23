<?php
include ("clase_rejilla_control_peso.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd = new bd();
/* * ********* Paginacion ************** */
if (!isset($_GET['ipp']))
    {
    $_GET['ipp'] = '';    
    }
$result_paciente = $bd->consultarArray("SELECT concat(pacientes.nombre,', ', pacientes.apellidos) AS Paciente 
FROM nutricion
JOIN pacientes on pacientes.id=id_paciente WHERE nutricion.id='" . $_GET['id_nutricion'] . "'");
$result2 = $result_paciente[0];
$paciente = $result2['Paciente'];
$num_registros = count($result_paciente);
$pages = new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
$result = $bd->consultarArray("select * from vw_rejilla_nutricion ORDER BY Paciente asc  $pages->limit");
/* * ********* Fin Paginacion ************** */

if (isset($_GET["id_nutricion"])) {
    $id_nutricion = $_GET["id_nutricion"];
    $result = $bd->consultarArray("select * from t_control_peso WHERE id_nutricion='.$id_nutricion.' $pages->limit");
    $result2 = $bd->consultarArray("select * from t_control_peso WHERE id_nutricion='.$id_nutricion.'");
    $num_registros = count($result2);
    $pages->items_total=$num_registros;
    $pages->paginate();
} else {
    $result = $bd->consultarArray("select * from t_control_peso ORDER BY fecha asc  $pages->limit");
    $id_nutricion = "";
}
if ($result) {
    echo '<div class="titulo"><h3>CONTROL DE PESO</h3></div>';
    echo "Paciente: " . $paciente;
    $rejilla = new rejilla($result, "index.php?cuerpo=form_t_control_peso.php&paciente=" . $paciente . "&", "id", "fecha");
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
        <input type="hidden" name="cuerpo" value="form_t_control_peso.php"/>
        <input type="hidden" name="id_nutricion" value="<?php echo $id_nutricion; ?>"/>
        <input type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>

<div class="cancelar">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_nutricion.php" />
        <input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
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