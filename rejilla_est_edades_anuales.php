<?php
include ("clase_rejilla_est_edades.php");
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include ("clase_annos.php");
include ("clase_meses.php");

$bd=new bd();
$util=new utilidadesIU();
$annos=new annos();
$meses=new meses();

/*********** Cálculo de $anno y $mes  ***************/

$nom_meses=$bd->consultarArray("select nom_mes from t_meses");

if (isset ($_GET["Años"]))
    {
        $anno = $_GET["Años"];
    }
else
    {
        $anno=date("Y");
    }
if (isset ($_GET["Meses"]))
    {
        $indice_mes = $_GET["Meses"]-1;
    }
else
    {
        $indice_mes=date("n")-1;
   }
$mes=$nom_meses[$indice_mes]['nom_mes'];
$id_mes=$indice_mes+1;
/***********  Fin Cálculo de $anno y $mes  ***************/

/*********** Establecer consulta ***************/
$consulta="SELECT Sexo,0a1,2a4,5a14,Resto,Total 
        FROM vw_total_consultantes_nuevos_anuales
        WHERE `Año`='".$anno."'";
//var_dump($consulta);
$result_total_pacientes_nuevos=$bd->consultarArray($consulta);

$consulta="SELECT Sexo,0a1,2a4,5a14,Resto,Total
        FROM vw_total_consultantes_viejos_anuales
        WHERE `Año`='".$anno."'";
//var_dump($consulta);
$result_total_pacientes_viejos=$bd->consultarArray($consulta);

$consulta="SELECT Sexo,0a1,2a4,5a14,Resto,Total
        FROM vw_total_consultantes_anuales
        WHERE `Año`='".$anno."'";
//var_dump($consulta);
$result_total_pacientes=$bd->consultarArray($consulta);



/******************** Fin establecer consulta *****************/

echo '<h3>ESTADÍSTICAS PACIENTES NUEVOS/VIEJOS - ANUALES</h3><br/>';
echo '<h2>AÑO '.$anno.'</h2>';

echo '<h2>Total de pacientes nuevos, clasificados por sexo y edad</h2>';
if($result_total_pacientes_nuevos)
{
    $rejilla_pacientes_nuevos=new rejilla_est_edades($result_total_pacientes_nuevos);
    echo $rejilla_pacientes_nuevos->pintar();
}
else
{
    echo '<p class="error">No se ha encontrado ningún registro.</p>';
}

echo '<h2>Total de pacientes viejos, clasificados por sexo y edad</h2>';
if($result_total_pacientes_viejos)
{
    $rejilla_pacientes_viejos=new rejilla_est_edades($result_total_pacientes_viejos);
    echo $rejilla_pacientes_viejos->pintar();
}
else
{
    echo '<p class="error">No se ha encontrado ningún registro.</p>';
}

echo '<h2>Total de pacientes, clasificados por sexo y edad</h2>';
if($result_total_pacientes)
{
    $rejilla_pacientes=new rejilla_est_edades($result_total_pacientes);
    echo $rejilla_pacientes->pintar();
}
else
{
    echo '<p class="error">No se ha encontrado ningún registro.</p>';
}
    

if(isset ($_GET['msj'])&& $_GET['msj']!="")
{
    echo '<p>Error: '.$_GET['msj'].'</p>';
}
    
if(isset ($_GET['msj2'])&& $_GET['msj2']!="")//Incluir en Generador
{                                            //Incluir en Generador   
    echo '<p>'.$_GET['msj2'].'</p>';             //Incluir en Generador   
} //Incluir en Generador 

?>

</br></br></br>
<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="criterios_est_edades.php"/>
    <input class="boton" type="submit" name="volver" value="Volver"/>
</form>