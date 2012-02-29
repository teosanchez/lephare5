<?php
include ("clase_rejilla_historial.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd=new bd();
/*********** Paginacion ***************/
if(!isset($_GET['ipp']))
    {
    $_GET['ipp']='';
    }
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_historial");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/

if(isset ($_GET["id_paciente"]))
    {
    $id_paciente=$_GET["id_paciente"];
    $result=$bd->consultarArray("select * from vw_rejilla_historial where id_paciente='".$id_paciente."'
                                $pages->limit");
    $result2=$bd->consultarArray("select * from vw_rejilla_historial where id_paciente='".$id_paciente."'");
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }    
//-----------------Comienzo Rejilla--------------------------
echo '<div class="titulo"><h3>HISTORIAL</h3></div>';
echo '<div class="titulo"><h3>Historial de '.$_GET['nombre_paciente']."</h3></div>";

if($result)
    {    
    $rejilla=new rejilla($result,"index.php?cuerpo=form_visitas.php&","id","Fecha");
    echo $rejilla->pintar();      
    if ($result2<>"")       /* Incluir  en generador este if */
        {        
        if ($num_registros == 1) {
            echo '<p class="num_registros">Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p class="num_registros">Se han encontrado ' . $num_registros . ' registros.</p>';
        }
        }
    }
 /*********** Paginacion ***************/
if($num_registros>10)
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
?>
<div class="cancelar">
    <form action="index.php" method="get">
		<input type="hidden" name="cuerpo" value="rejilla_pacientes.php" />
		<input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
    </form>
</div>