<<<<<<< HEAD
<<<<<<< HEAD
<?php
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include ("clase_annos.php");
include ("clase_meses.php");

$bd=new bd();
$util=new utilidadesIU();
$annos=new annos();
$meses=new meses();
/*********** C�lculo de $anno y $mes  ***************/

$nom_meses=$bd->consultarArray("select nom_mes from t_meses");

if (isset ($_GET["A�os"]))
    {
        $anno = $_GET["A�os"];
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

/***********  Fin C�lculo de $anno y $mes  ***************/

?>
<div class="titulo">
<h3>ESTAD�STICAS PACIENTES NUEVOS/VIEJOS <br/> CRITERIOS DE SELECCI�N</h3>
</div>

<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="procesar_est_edades.php"/>
    Seleccione un Mes:
    <?php
        $datosLista=$bd->consultar("select * from t_meses");
        echo $util->pinta_selection($datosLista,"Meses","nom_mes",$id_mes);
    ?>
        Seleccione un A�o:
    <?php
        $datosLista=$bd->consultar("select * from vw_lista_anios");
        echo $util->pinta_selection2($datosLista,"A�os","A�o",$anno);
    ?>
    </br></br></br>

    
    <input class="boton" type="submit" name="est_mensuales" value="Ver Estad�sticas Mensuales"/>
    </br></br>
    <input class="boton" type="submit" name="est_anuales" value="Ver Estad�sticas Anuales"/>
</form>



=======
=======
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
<?php
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include ("clase_annos.php");
include ("clase_meses.php");

$bd = new bd();
$util = new utilidadesIU();
$anios = new anios();
$meses = new meses();
/* * ********* C�lculo de $anio y $mes  ************** */

$nom_meses = $bd->consultarArray("select nom_mes from t_meses");

if (isset($_GET["anios"])) {
    $anio = $_GET["anios"];
} else {
    $anio = date("Y");
}

if (isset($_GET["Meses"])) {
    $indice_mes = $_GET["Meses"] - 1;
} else {
    $indice_mes = date("n") - 1;
}
$mes = $nom_meses[$indice_mes]['nom_mes'];
$id_mes = $indice_mes + 1;

/* * *********  Fin C�lculo de $anio y $mes  ************** */
?>

<div class="titulo">
    <h3>ESTAD�STICAS PACIENTES NUEVOS/VIEJOS - CRITERIOS DE SELECCI�N</h3>
</div>
<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="procesar_est_edades.php"/>
    Seleccione un Mes:
    <?php
    $datosLista = $bd->consultar("select * from t_meses");
    echo $util->pinta_selection($datosLista, "Meses", "nom_mes", $id_mes);
    ?>
    <br/>Seleccione un A�o:
    <?php
    $datosLista = $bd->consultar("select * from vw_lista_anios");
    echo $util->pinta_selection2($datosLista, "anios", "anio", $anio);
    ?>
    <br/><br/>
    <input class="boton" type="submit" name="est_mensuales" value="Ver Estad�sticas Mensuales"/>    
    <input class="boton" type="submit" name="est_anuales" value="Ver Estad�sticas Anuales"/>
</form>



<<<<<<< HEAD
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
=======
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
