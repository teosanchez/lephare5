<?php
include ("clase_rejilla_nutricion.php");
include_once ("clase_bd.php");

$bd=new bd();
$result=$bd->consultarArray("select * from vw_rejilla_nutricion");

/*********** Paginacion ***************/
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
$resultados=$bd->consultar("SELECT * FROM vw_rejilla_nutricion");
$total_registros=mysql_num_rows($resultados);
$total_paginas=ceil($total_registros / $registros);
/*********** Fin Paginacion ***************/

if($result)
{echo '<p><h3>Nutricion<br></h3></p>';
	$rejilla=new rejilla($result,"index.php?cuerpo=form_nutricion.php&","id","Paciente");
	echo $rejilla->pintar();
}


/*********** Paginacion ***************/
if(($pagina-1) > 0) 
       {
       echo "<a href='index.php?cuerpo=rejilla_nutricion.php&pagina=".($pagina-1)."'>< Anterior</a> ";    
       }    
   for ($i=1; $i<=$total_paginas; $i++)
       {
       if ($pagina == $i)
           {    
           echo "<b>".$pagina."</b> ";
           }
        else 
           {
           echo "<a href='index.php?cuerpo=rejilla_nutricion.php&pagina=$i'>$i</a>&nbsp;";
           } 
        }   
   if(($pagina + 1)<=$total_paginas)
       {
       echo " <a href='index.php?cuerpo=rejilla_nutricion.php&pagina=".($pagina+1)."'>Siguiente ></a>";
       }
 /*********** Fin Paginacion ***************/      
?>

<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_nutricion.php" />
<input type="submit" name="nuevo" value="Nuevo"/>
</form>