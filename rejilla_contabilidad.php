<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");

	$bd=new bd();
	$result=$bd->consultarArray("select * from vw_rejilla_contabilidad");
if($result)
{echo '<p><h3>contabilidad<br></h3></p>';
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