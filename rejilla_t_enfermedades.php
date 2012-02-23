<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd = new bd();
/* * ********* Establecer consulta ************** */
$cadena = "";
$result = "";
$result2 = "";    /* Incluir en generador el cálculo de $result2 */
/* * ********* Paginacion ************** */
if(!isset($_GET['ipp']))
    {
    $_GET['ipp']='';
    }
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_enfermedades");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/* * ********* Fin Paginacion ************** */
if (isset($_GET["cadena"]) && $_GET["cadena"] <> "")
    { //Evalua si existe esta variable y si viene con algun contenido, la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    $cadena = $_GET["cadena"];
    $result = $bd->consultarArray("SELECT * from vw_rejilla_enfermedades where Enfermedad like '%" . $cadena . "%'
                                $pages->limit");
    $result2 = $bd->consultarArray("SELECT * from vw_rejilla_enfermedades where Enfermedad like '%" . $cadena . "%'");
    //echo "ENTRA IF 2";
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
else
    {
    if (!isset($_GET["cadena"]))
        {
        //$result=$bd->consultarArray("select * from vw_rejilla_enfermedades order by Enfermedad limit 10");
        $result = $bd->consultarArray("SELECT * FROM vw_rejilla_enfermedades ORDER BY Enfermedad asc $pages->limit");
        }
    }
?>

<div class="titulo">
<h3>ENFERMEDADES</h3>
</div>
<div class="buscar">
<form action="index.php" method="get">       
<input type="text" name="cadena"/>
<input type="hidden" name="cuerpo" value="rejilla_t_enfermedades.php" />
<input class="boton" type="submit" name="buscar" value="Buscar"/>
</form>
</div> 

<?php
if($result)
    {
    $rejilla=new rejilla($result,"index.php?cuerpo=form_t_enfermedades.php&","id","Enfermedad");
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
else	/* Incluir en generador este else */
    {
    if (isset($_GET["cadena"]) && $_GET["cadena"] == "")
    { //Evalua si existe esta variable y si viene sin contenido (vacia), la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    echo '<p class="error">Introduzca una enfermedad.</p>';
    //echo "ENTRA IF 3";
    $num_registros='';
    }
        
    }   
if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p class="error">Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                           
    echo '<p clase="mensaje">' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}
?>

<div class="nuevo">
<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_t_enfermedades.php" />
<input class="boton" type="submit" name="nuevo" value="Nuevo"/>
</form>   
</div> 

<?php
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
if (isset($_GET["buscar"]))
    {
    echo '<div class="cancelar">
        <form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="rejilla_t_enfermedades.php" />
    <input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
    </form></div>';
    }    
?>