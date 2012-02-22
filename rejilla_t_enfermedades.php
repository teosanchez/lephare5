<<<<<<< HEAD
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

if (isset($_GET["cadena"]) && $_GET["cadena"] == "")
    { //Evalua si existe esta variable y si viene sin contenido (vacia), la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    echo '<p class="error">Introduzca una enfermedad.</p>';
    //echo "ENTRA IF 3";
    $num_registros='';
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

<div class="titutlo">
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
if ($result)
    {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_t_enfermedades.php&", "id", "Enfermedad");
    echo $rejilla->pintar();    
    }

if (isset($_GET['msj2']) && $_GET['msj2'] != "")//Incluir en Generador
    {                                            //Incluir en Generador   
    echo '<p>' . $_GET['msj2'] . '</p>';             //Incluir en Generador   
    }                                             //Incluir en Generador 
if (isset($_GET["buscar"]) or isset($_GET["todos"]))
    {
    echo '<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="rejilla_t_enfermedades.php" />
    <br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
    </form><br/>';
    }
/*********** Paginacion ***************/
if ($result2<>"")       /* Incluir  en generador este if */
        {
        //$num_registros= mysql_num_rows($result2);
        if ($num_registros == 1)
            {
                echo '<br/>Se ha encontrado '.$num_registros.' registro.';
            }
        else
            {
                echo '<br/>Se han encontrado '.$num_registros.' registros.';
            }
        }    
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
    echo "No se ha encontrado ningun registro.";
    }   
 /*********** Fin Paginacion ***************/ 
?>    

<div class="nuevo">
<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_t_enfermedades.php" />
<br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
</form>   
</div> 
=======
<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");

$bd = new bd();
/* * ********* Establecer consulta ************** */
$cadena = "";
$result = "";
$result2 = "";    /* Incluir en generador el cálculo de $result2 */
/* * ********* Paginacion ************** */
$registros = 2;
$inicio = 0;
if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $inicio = ($pagina - 1) * $registros;
} else {
    $pagina = 1;
}
$resultados = $bd->consultar("SELECT * FROM vw_rejilla_enfermedades");

$total_registros = mysql_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);
/* * ********* Fin Paginacion ************** */


if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") { //Evalua si existe esta variable y si viene con algun contenido, la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    $cadena = $_GET["cadena"];
    $result = $bd->consultarArray("SELECT * from vw_rejilla_enfermedades where Enfermedad like '%" . $cadena . "%'");
    $result2 = $bd->consultar("SELECT * from vw_rejilla_enfermedades where Enfermedad like '%" . $cadena . "%'");
    //echo "ENTRA IF 2";
}

if (isset($_GET["cadena"]) && $_GET["cadena"] == "") { //Evalua si existe esta variable y si viene sin contenido (vacia), la cual procede del cuadro de texto que esta junto al boton Buscar de uno de los formularios
    echo '<p class="error">Introduzca una enfermedad.</p>';
    //echo "ENTRA IF 3";
} else {
    if (!isset($_GET["cadena"])) {
        //$result=$bd->consultarArray("select * from vw_rejilla_enfermedades order by Enfermedad limit 10");
        $result = $bd->consultarArray("SELECT * FROM vw_rejilla_enfermedades ORDER BY Enfermedad asc LIMIT $inicio, $registros");
    }
}
?>

<div class="titutlo">
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
if ($result) {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_t_enfermedades.php&", "id", "Enfermedad");
    echo $rejilla->pintar();
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
    if (($pagina - 1) > 0) {
        echo "<a href='index.php?cuerpo=rejilla_t_enfermedades.php&pagina=" . ($pagina - 1) . "'>< Anterior</a> ";
    }
    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($pagina == $i) {
            echo "<b>" . $pagina . "</b> ";
        } else {
            echo "<a href='index.php?cuerpo=rejilla_t_enfermedades.php&pagina=$i'>$i</a>&nbsp;";
        }
    }
    if (($pagina + 1) <= $total_paginas) {
        echo " <a href='index.php?cuerpo=rejilla_t_enfermedades.php&pagina=" . ($pagina + 1) . "'>Siguiente ></a>";
    }
    ?>    

    <div class="nuevo">
        <form action="index.php" method="get">
            <input type="hidden" name="cuerpo" value="form_t_enfermedades.php" />
            <br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
        </form>   
    </div>


<?php } ?>  
>>>>>>> a8687821aec06cb97cb0f3a503579e7e5600c8ed
