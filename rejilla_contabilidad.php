<<<<<<< HEAD
<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");

	$bd=new bd();
	$result=$bd->consultarArray("select * from vw_rejilla_contabilidad");
if($result)
{   
    echo '<div class="titulo">';
    echo '<h3>CONTABILIDAD<br></h3>';
    echo '</div>';
	$rejilla=new rejilla($result,"index.php?cuerpo=form_contabilidad.php&","id","Fecha");
	echo $rejilla->pintar();
}
?>
<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_contabilidad.php" />
<input type="submit" name="nuevo" value="Nuevo Asiento"/>
</form>

 <?php
  
  /*********** Paginación ***************/
 
$registros=REGISTROS_PAGINA;
$inicio=0;
if(isset($_GET['pagina']))
    {
    $pagina=$_GET['pagina'];
    $inicio=($pagina-1)*$registros;        
    }
else 
    {
    $pagina=1;
    }
$resultados=$bd->consultar("SELECT * FROM contabilidad");

$total_registros=mysql_num_rows($resultados);
$total_paginas=ceil($total_registros / $registros);

if(($pagina-1) > 0) 
       {
       echo "<a href='index.php?cuerpo=rejilla_contabilidad.php&pagina=".($pagina-1)."'>< Anterior</a> ";    
       }    
   for ($i=1; $i<=$total_paginas; $i++)
       {
       if ($pagina == $i)
           {    
           echo "<b>".$pagina."</b> ";
           }
        else 
           {
           echo "<a href='index.php?cuerpo=rejilla_contabilidad.php&pagina=$i'>$i</a>&nbsp;";
           } 
        }   
   if(($pagina + 1)<=$total_paginas)
       {
       echo " <a href='index.php?cuerpo=rejilla_contabilidad.php&pagina=".($pagina+1)."'>Siguiente ></a>";
       }
 /*********** Fin Paginación ***************/   
   ?>
=======
<?php
include ("clase_rejilla.php");
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
$result2 = $bd->consultarArray("SELECT * FROM vw_rejilla_contabilidad");
$num_registros = count($result2);
$pages = new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
$result = $bd->consultarArray("select * from vw_rejilla_contabilidad ORDER BY Fecha desc  $pages->limit");
/* * ********* Fin Paginacion ************** */
if ($result) {
    echo '<div class="titulo"><h3>CONTABILIDAD</h3></div>';
    $rejilla = new rejilla($result, "index.php?cuerpo=form_contabilidad.php&", "id", "Fecha");
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
        <input type="hidden" name="cuerpo" value="form_contabilidad.php" />
        <input type="submit" name="nuevo" value="Nuevo"/>
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
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
