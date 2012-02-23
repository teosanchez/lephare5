<?php
include_once ("clase_bd.php");
$bd=new bd();

if (isset ($_GET["anios"]))
    {
        $anio = $_GET["anios"];
    }
else
    {
        $anio=date("Y");
    }
if (isset ($_GET["Meses"]))
    {
        $indice_mes = $_GET["Meses"];
    }
else
    {
        $indice_mes=date("n");
   }
if(isset($_GET["est_mensuales"])) 
{
    header('Location: index.php?cuerpo=rejilla_est_edades_mensuales.php&anios='.$anio.
            "&Meses=".$indice_mes);//Incluir en Generador
}

if(isset($_GET["est_anuales"])) 
{
    header('Location: index.php?cuerpo=rejilla_est_edades_anuales.php&anios='.$anio.
            "&Meses=".$indice_mes);//Incluir en Generador
}
?>