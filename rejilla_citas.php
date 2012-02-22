<?php
include ("clase_rejilla_citas.php");
include_once ("clase_bd.php");

$bd = new bd();

/* * ********* Establecer consulta ************** */
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
$resultados = $bd->consultar("SELECT * FROM vw_rejilla_citas");

$total_registros = mysql_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);
/* * ********* Fin Paginacion ************** */
if (isset($_GET["fecha"]) && $_GET["fecha"] <> "") {
    $fecha = $_GET["fecha"];
    $result = $bd->consultarArray("select * from vw_rejilla_citas where Fecha='" . $fecha . "'");
    $result2 = $bd->consultar("select * from vw_rejilla_citas where Fecha='" . $fecha . "'");
} else {
    if (isset($_GET["cadena"]) && $_GET["cadena"] <> "") {
        $cadena = $_GET["cadena"];
        $result = $bd->consultarArray("SELECT * from vw_rejilla_citas
                                             where Paciente like '%" . $cadena . "%' 
                                             or Medico like '%" . $cadena . "%'");
        $result2 = $bd->consultar("SELECT * from vw_rejilla_citas
                                                                            where Paciente like '%" . $cadena . "%' 
                                                                            or Medico like '%" . $cadena . "%'");
    } else {
        if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"])) {
            /* paginacion (ordenado por fecha) */
            $result = $bd->consultarArray("SELECT * FROM vw_rejilla_citas ORDER BY Fecha asc LIMIT $inicio, $registros");
        }
    }

include_once ("clase_paginador.php");
$bd=new bd();

/*********** Establecer consulta ***************/
$cadena="";   
$fecha="";    
$result="";
/*********** Paginacion ***************/
if(!isset($_GET['ipp']))
    {
    $_GET['ipp']='';
    }
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_citas");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/
if(isset ($_GET["fecha"]) && $_GET["fecha"]<>"")
    {	
    $fecha=$_GET["fecha"];
    $result=$bd->consultarArray("select * from vw_rejilla_citas where Fecha='".$fecha."' $pages->limit");
    $result2=$bd->consultarArray("select * from vw_rejilla_citas where Fecha='".$fecha."'");  
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
else
{
if(isset ($_GET["cadena"]) && $_GET["cadena"]<>"")
    {	
    $cadena=$_GET["cadena"];
    $result=$bd->consultarArray("SELECT * from vw_rejilla_citas where Paciente like '%".$cadena."%' 
                                or Medico like '%".$cadena."%'ORDER BY Fecha desc $pages->limit");
    $result2=$bd->consultarArray("SELECT * from vw_rejilla_citas where Paciente like '%".$cadena."%' 
                                or Medico like '%".$cadena."%'");
    $num_registros=count($result2);
    $pages->items_total=$num_registros;
    $pages->paginate();
    }    
else
    {
    if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"]))
        {	
<<<<<<< HEAD
        /*paginacion (ordenado por fecha)*/
        $result=$bd->consultarArray("SELECT * FROM vw_rejilla_citas ORDER BY Fecha desc $pages->limit");
        }
    }	
=======
                $cadena=$_GET["cadena"];
                $result=$bd->consultarArray("SELECT * from vw_rejilla_citas
                                             where Paciente like '%".$cadena."%' 
                                             or Medico like '%".$cadena."%'");
                $result2=$bd->consultar("SELECT * from vw_rejilla_citas
                                                                            where Paciente like '%".$cadena."%' 
                                                                            or Medico like '%".$cadena."%'");
        }    
        else
        {
                if (!isset($_GET["buscar_fecha"]) and !isset($_GET["buscar_cadena"]))
                {	
                        /*paginacion (ordenado por fecha)*/
                    $result=$bd->consultarArray("SELECT * FROM vw_rejilla_citas ORDER BY Fecha asc $pages->limit");
                }
        }   
	

>>>>>>> 311f8ae8d2c98939e15bb1dcf07c0c43a0236c91
}
/* * ****************** Fin establecer consulta **************** */
?>

<div class="titulo">
    <h3>CITAS</h3>
</div>

<div class="buscar">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
        <input type="text" name="cadena"/>
        <input class="boton" type="submit" name="buscar_cadena" value="Buscar Datos"/>
    </form>
</div>

<div class="buscar_fecha">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
        <input type="text" name="fecha"/>
        <input class="boton" type="submit" name="buscar_fecha" value="Buscar Fecha"/>
    </form>    
</div>

<?php
if ($result) {
    $rejilla = new rejilla_citas($result, "index.php?cuerpo=form_citas.php&", "id", "Paciente");
    echo $rejilla->pintar();
<<<<<<< HEAD
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
    }
else	/* Incluir en generador este else */
    {
    if (isset($_GET["buscar_fecha"]) && $fecha=="")
        {
        echo '<p class="error">Introduzca una fecha.</p>';
        $num_registros='';
        }
    else
        {
        if (isset($_GET["buscar_cadena"]) && $cadena=="")
            {
            echo '<p class="error">Introduzca el dato que desea buscar.</p>';
            $num_registros='';
            }
        }
    }    
if(isset ($_GET['msj'])&& $_GET['msj']!="")
    {
    echo '<p>Error: '.$_GET['msj'].'</p>';
    }
if(isset ($_GET['msj2'])&& $_GET['msj2']!="")//Incluir en Generador
    {                                           //Incluir en Generador
    echo '<p>'.$_GET['msj2'].'</p>';            //Incluir en Generador
    }                                           //Incluir en Generador
=======
    if ($result2 <> "") /* Incluir  en generador este if */ {
        $num_registros = mysql_num_rows($result2);
        if ($num_registros == 1) {
            echo '<p>Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p>Se han encontrado ' . $num_registros . ' registros.</p>';
        }
    }
} else /* Incluir en generador este else */ {
    if (isset($_GET["buscar_fecha"]) && $fecha == "") {
        echo '<p class="error">Introduzca una fecha.</p>';
    } else {
        if (isset($_GET["buscar_cadena"]) && $cadena == "") {
            echo '<p class="error">Introduzca el dato que desea buscar.</p>';
        } else {
            echo '<p class="error">No se ha encontrado ningún registro.</p>';
        }
    }
}

if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p>Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                           //Incluir en Generador
    echo '<p>' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}                                           //Incluir en Generador
>>>>>>> 311f8ae8d2c98939e15bb1dcf07c0c43a0236c91


/* * ********* Paginacion ************** */
if (($pagina - 1) > 0) {
    echo "<a href='index.php?cuerpo=rejilla_citas.php&pagina=" . ($pagina - 1) . "'>< Anterior</a> ";
}
for ($i = 1; $i <= $total_paginas; $i++) {
    if ($pagina == $i) {
        echo "<b>" . $pagina . "</b> ";
    } else {
        echo "<a href='index.php?cuerpo=rejilla_citas.php&pagina=$i'>$i</a>&nbsp;";
    }
}
if (($pagina + 1) <= $total_paginas) {
    echo " <a href='index.php?cuerpo=rejilla_citas.php&pagina=" . ($pagina + 1) . "'>Siguiente ></a>";
}
/* * ********* Fin Paginacion ************** */

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

?>
<<<<<<< HEAD
<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="form_citas.php" />
    <br/><input class="boton" type="submit" name="nuevo" value="Nueva Cita"/>
</form>

<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
    <input type="text" name="fecha"/>
    <input class="boton" type="submit" name="buscar_fecha" value="Buscar Fecha"/>
</form>

<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="rejilla_citas.php" />
    <input type="text" name="cadena"/>
    <input class="boton" type="submit" name="buscar_cadena" value="Buscar Dato"/>
</form>
=======

<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_citas.php" />
        <br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form>
</div>

>>>>>>> 311f8ae8d2c98939e15bb1dcf07c0c43a0236c91
