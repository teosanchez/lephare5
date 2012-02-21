<?php
include ("clase_rejilla_control_peso.php");
include_once ("clase_bd.php");

$bd=new bd();
$result_paciente=$bd->consultarArray("SELECT concat(pacientes.nombre,', ', pacientes.apellidos) AS Paciente 
FROM nutricion
JOIN pacientes on pacientes.id=id_paciente WHERE nutricion.id='".$_GET['id_nutricion']."'");
$result2=$result_paciente[0];
$paciente=$result2['Paciente'];

/*********** Paginacion ***************/
$registros=PAGINACION;
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
$resultados=$bd->consultar("SELECT concat(pacientes.nombre,', ', pacientes.apellidos) AS Paciente 
FROM nutricion
JOIN pacientes on pacientes.id=id_paciente WHERE nutricion.id='".$_GET['id_nutricion']."'");
$total_registros=mysql_num_rows($resultados);
$total_paginas=ceil($total_registros / $registros);
/*********** Fin Paginacion ***************/

if(isset($_GET["id_nutricion"]))
{
    $id_nutricion=$_GET["id_nutricion"];
    $result=$bd->consultarArray("select * from t_control_peso WHERE id_nutricion='.$id_nutricion.'");
}
else
{
    $result=$bd->consultarArray("select * from t_control_peso");
    $id_nutricion="";
}
if($result)
{
        echo '<p><h1>Contro de peso<br></h1></p>';
        echo "Paciente: ".$paciente;
	$rejilla=new rejilla($result,"index.php?cuerpo=form_t_control_peso.php&paciente=".$paciente."&","id","fecha");
	echo $rejilla->pintar();
}

/*********** Paginacion ***************/
if(($pagina-1) > 0) 
       {
       echo "<a href='index.php?cuerpo=rejilla_t_control_peso.php&pagina=".($pagina-1)."'>< Anterior</a> ";    
       }    
   for ($i=1; $i<=$total_paginas; $i++)
       {
       if ($pagina == $i)
           {    
           echo "<b>".$pagina."</b> ";
           }
        else 
           {
           echo "<a href='index.php?cuerpo=rejilla_t_control_peso.php&pagina=$i'>$i</a>&nbsp;";
           } 
        }   
   if(($pagina + 1)<=$total_paginas)
       {
       echo " <a href='index.php?cuerpo=rejilla_t_control_peso.php&pagina=".($pagina+1)."'>Siguiente ></a>";
       }
 /*********** Fin Paginacion ***************/      

?>
<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_t_control_peso.php"/>
<input type="hidden" name="id_nutricion" value="<?php echo $id_nutricion; ?>"/>
<input type="submit" name="nuevo" value="Nuevo"/>
</form>