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
<<<<<<< HEAD
    <h3>ENFERMEDADES</h3>
=======
<h3>ENFERMEDADES</h3>
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
</div>
<div class="buscar">
<form action="index.php" method="get">       
<input type="text" name="cadena"/>
<input type="hidden" name="cuerpo" value="rejilla_t_enfermedades.php" />
<input class="boton" type="submit" name="buscar" value="Buscar"/>
</form>
</div> 
<br/>

<?php
if($result)
    {
    $rejilla=new rejilla($result,"index.php?cuerpo=form_t_enfermedades.php&","id","Enfermedad");
    echo $rejilla->pintar();
<<<<<<< HEAD
}

if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                            //Incluir en Generador   
    echo '<p>' . $_GET['msj2'] . '</p>';             //Incluir en Generador   
}                                             //Incluir en Generador 
if (isset($_GET["buscar"]) or isset($_GET["todos"])) {
    echo '<form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_t_enfermedades.php" />
        <br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
        </form><br/>';
} else {
    /*     * ********* Paginacion ************** */
    echo "<br/>";
    if (($pagina - 1) > 0) {
        echo "<a href='index.php?cuerpo=rejilla_t_enfermedades.php&pagina=" . ($pagina - 1) . "'>< Anterior</a> ";
    }
    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($pagina == $i) {
            echo "<b>" . $pagina . "</b> ";
=======
    if ($result2<>"")       /* Incluir  en generador este if */
        {
        if ($num_registros == 1) {
            echo '<p class="num_registros">Se ha encontrado ' . $num_registros . ' registro.</p>';
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
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
