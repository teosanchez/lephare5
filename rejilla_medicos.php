<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");
<<<<<<< HEAD
include_once ("clase_paginador.php");
$bd=new bd();

$cadena="";
$result="";
$result2="";
/*********** Paginacion ***************/
if(!isset($_GET['ipp']))
    {
    $_GET['ipp']='';
    }
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_medicos");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/ 
if(isset ($_GET["buscar"]) && $_GET["cadena"]<>"")
    {
    $cadena=$_GET["cadena"];
    $result=$bd->consultarArray("SELECT * from vw_rejilla_medicos where Medico like '%".$cadena."%'ORDER BY Medico asc $pages->limit");
    $result2=$bd->consultarArray("SELECT * from vw_rejilla_medicos where Medico like '%".$cadena."%'");
    $num_registros=count($result2);
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
elseif (!isset ($_GET['buscar']))
    {       
    $result=$bd->consultarArray("SELECT * FROM vw_rejilla_medicos ORDER BY Medico asc $pages->limit");
    }
    
echo '<h3>REJILLA MEDICO</h3><br/>';
if($result)
    {
    $rejilla=new rejilla($result,"index.php?cuerpo=form_medicos.php&","id","Medico");
    echo $rejilla->pintar();
    if ($result2<>"")       /* Incluir  en generador este if */
        {        
        if ($num_registros==1)
            {
            echo '<br/>Se ha encontrado '.$num_registros.' registro.';
            }
        else
            {
            echo '<br/>Se han encontrado '.$num_registros.' registros.';
            }
        }
    }
else
    {
    if (isset($_GET["buscar"]) && $cadena=="")
        {
        echo '<p class="error">Introduzca el dato que desea buscar.</p>';
        $num_registros='';
        }
    else
        {
        echo '<p class="error">No se ha encontrado ningun registro.</p>';
        $num_registros='';
        }
    }
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
    echo "No se ha encontrado ningun registro.";
    }   
/*********** Fin Paginacion ***************/
if(isset ($_GET['msj2'])&& $_GET['msj2']!="")//Incluir en Generador
    {                                            //Incluir en Generador   
    echo '<p>'.$_GET['msj2'].'</p>';            //Incluir en Generador
    }                                           //Incluir en Generador                                                                                         

if(isset ($_GET["buscar"]) or isset ($_GET["todos"]))
    {
    echo '<form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_medicos.php" />
        <br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
    </form><br/>';
    }
?>

<form action="index.php" method="get">        
    <input type="text" name="cadena"/>
    <input type="hidden" name="cuerpo" value="rejilla_medicos.php" />
    <input class="boton" type="submit" name="buscar" value="Buscar"/>
</form>

<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="form_medicos.php" />
    <br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
</form>
=======

$bd = new bd();

$cadena = "";
$fecha = "";
$result = "";
$result2 = "";

/* * ********* Paginacion ************** */
$registros = 2;
$inicio = 0;
if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $inicio = ($pagina - 1) * $registros;
} else {
    $pagina = 1;
}
$resultados = $bd->consultar("SELECT * FROM vw_rejilla_medicos");

$total_registros = mysql_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);
/* * ********* Fin Paginacion ************** */


if (isset($_GET["todos"])) {
    $result = $bd->consultarArray("select * from vw_rejilla_medicos");
}


if (isset($_GET["buscar"]) && $_GET["cadena"] <> "") {
    $cadena = $_GET["cadena"];
    $result = $bd->consultarArray("SELECT * from vw_rejilla_medicos where Medico like '%" . $cadena . "%'");
    $result2 = $bd->consultar("SELECT * from vw_rejilla_medicos where Medico like '%" . $cadena . "%'");
} elseif (!isset($_GET['buscar'])) {

    $result = $bd->consultarArray("SELECT * FROM vw_rejilla_medicos ORDER BY Medico asc LIMIT $inicio, $registros");
}
?>

<div class="titulo">
    <h3>MÉDICOS</h3>
</div>

<div class="buscar">
    <form action="index.php" method="get">        
        <input type="text" name="cadena"/>
        <input type="hidden" name="cuerpo" value="rejilla_medicos.php" />
        <input class="boton" type="submit" name="buscar" value="Buscar"/>
    </form>
</div>

<?php
if ($result) {
    $rejilla = new rejilla($result, "index.php?cuerpo=form_medicos.php&", "id", "Medico");
    echo $rejilla->pintar();
    if ($result2 <> "") /* Incluir  en generador este if */ {
        $num_registros = mysql_num_rows($result2);

        if ($num_registros == 1) {
            echo '<p>Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p>Se han encontrado ' . $num_registros . ' registros.</p>';
        }
    }
} else {
    if (isset($_GET["buscar"]) && $cadena == "") {
        echo '<p class="error">Introduzca el dato que desea buscar.</p>';
    } else {
        echo '<p class="error">No se ha encontrado ningún registro.</p>';
    }
}

/* * ********* Paginacion ************** */
if (($pagina - 1) > 0) {
    echo "<a href='index.php?cuerpo=rejilla_medicos.php&pagina=" . ($pagina - 1) . "'>< Anterior</a> ";
}
for ($i = 1; $i <= $total_paginas; $i++) {
    if ($pagina == $i) {
        echo "<b>" . $pagina . "</b> ";
    } else {
        echo "<a href='index.php?cuerpo=rejilla_medicos.php&pagina=$i'>$i</a>&nbsp;";
    }
}
if (($pagina + 1) <= $total_paginas) {
    echo " <a href='index.php?cuerpo=rejilla_medicos.php&pagina=" . ($pagina + 1) . "'>Siguiente ></a>";
}
/* * ********* Fin Paginacion ************** */

if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                            //Incluir en Generador   
    echo '<p>' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}                                           //Incluir en Generador                                                                                         

if (isset($_GET["buscar"]) or isset($_GET["todos"])) {
    echo '<form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_medicos.php" />
        <br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
        </form><br/>';
}
?>

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_medicos.php" />
        <input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>
>>>>>>> 311f8ae8d2c98939e15bb1dcf07c0c43a0236c91
