<<<<<<< HEAD
<<<<<<< HEAD
<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");
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
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_menu");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/
if(isset ($_GET["cadena"]) && $_GET["cadena"]<>"")
    {
    $cadena=$_GET["cadena"];
    $result=$bd->consultarArray("SELECT * from vw_rejilla_menu where Enlace like '%".$cadena."%'
                                or Texto like '%".$cadena."%'ORDER BY Texto desc $pages->limit");
    $result2=$bd->consultarArray("SELECT * from vw_rejilla_menu where Enlace like '%".$cadena."%' 
                            or Texto like '%".$cadena."%'");
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
else
    {
    if (!isset($_GET["buscar_cadena"]))
        {        	
        $result=$bd->consultarArray("select * from vw_rejilla_menu order by Texto desc $pages->limit");
        }
    }
/******************** Fin establecer consulta *****************/
echo '<div class="titulo">';  
echo '<h3>MENU</h3><br/>';
echo '</div>';

if($result)
    {       
    $rejilla=new rejilla($result,"index.php?cuerpo=form_menu.php&","id","Texto");
    echo $rejilla->pintar();
    if ($result2<>"")
        {       /* Incluir  en generador este if */        
        $num_registros= count($result2);
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
else
    {	/* Incluir en generador este else */
    if (isset($_GET["buscar_cadena"]) && $cadena=="")
        {
        echo '<p class="error">Introduzca el dato que desea buscar.</p>';
        $num_registros='';
        }
    else
        {
        echo '<p class="error">No se ha encontrado ning�n registro.</p>';
        $num_registros='';
        }    
    }

if(isset ($_GET['msj'])&& $_GET['msj']!="")
    {
    echo '<p>Error: '.$_GET['msj'].'</p>';
    }
if(isset ($_GET['msj2'])&& $_GET['msj2']!="")
    {  //Incluir en Generador                                               
    echo '<p>'.$_GET['msj2'].'</p>';            //Incluir en Generador
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
?>


<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="rejilla_menu.php" />
<br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
</form><br/>

<form action="index.php" method="get">
<br/>Buscar
<input type="text" name="cadena"/>
<input type="hidden" name="cuerpo" value="rejilla_menu.php" />
<input class="boton" type="submit" name="buscar_cadena" value="Buscar"/>
</form>

<form action="index.php" method="get">
<input type="hidden" name="cuerpo" value="form_menu.php" />
<br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
</form><br/><br/>
=======
=======
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
<?php
include ("clase_rejilla.php");
include_once ("clase_bd.php");
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
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_menu");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/
if(isset ($_GET["cadena"]) && $_GET["cadena"]<>"")
    {
    $cadena=$_GET["cadena"];
    $result=$bd->consultarArray("SELECT * from vw_rejilla_menu where Enlace like '%".$cadena."%'
                                or Texto like '%".$cadena."%'ORDER BY Texto desc $pages->limit");
    $result2=$bd->consultarArray("SELECT * from vw_rejilla_menu where Enlace like '%".$cadena."%' 
                            or Texto like '%".$cadena."%'");
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
else
    {
    if (!isset($_GET["buscar_cadena"]))
        {        	
        $result=$bd->consultarArray("select * from vw_rejilla_menu order by Texto desc $pages->limit");
        }
    }
/******************** Fin establecer consulta *****************/

echo '<div class="titulo"><h3>MENU</h3></div>';
?>

<div class="buscar">
    <form action="index.php" method="get">
        <input type="text" name="cadena"/>
        <input type="hidden" name="cuerpo" value="rejilla_menu.php" />
        <input class="boton" type="submit" name="buscar_cadena" value="Buscar Datos"/>
    </form>
</div>   
    
<?php
if($result)
    {       
    $rejilla=new rejilla($result,"index.php?cuerpo=form_menu.php&","id","Texto");
    echo $rejilla->pintar();
    if ($result2<>"")
        {       /* Incluir  en generador este if */        
        $num_registros= count($result2);
        if ($num_registros == 1) {
            echo '<p class="num_registros">Se ha encontrado ' . $num_registros . ' registro.</p>';
        } else {
            echo '<p class="num_registros">Se han encontrado ' . $num_registros . ' registros.</p>';
        }
        }
    }
else
    {	/* Incluir en generador este else */
    if (isset($_GET["buscar_cadena"]) && $cadena=="")
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
if (isset($_GET['msj']) && $_GET['msj'] != "") {
    echo '<p class="error">Error: ' . $_GET['msj'] . '</p>';
}
if (isset($_GET['msj2']) && $_GET['msj2'] != "") {//Incluir en Generador                                           
    echo '<p clase="mensaje">' . $_GET['msj2'] . '</p>';            //Incluir en Generador
}  
?>
<div class="nuevo">
    <form action="index.php" method="get">
        <input type="hidden" name="cuerpo" value="form_menu.php" />
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
if(isset($_GET["buscar_cadena"]))
    {
    echo '<div class="cancelar">
            <form action="index.php" method="get">
                <input type="hidden" name="cuerpo" value="rejilla_menu.php" />
                <input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
            </form>
        </div>';
    }    
<<<<<<< HEAD
?>
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
=======
?>
>>>>>>> 38cb9c9840124788c2ea64d26e3cc657bdf136ba
