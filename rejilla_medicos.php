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
echo '<div class="titulo">';    
echo '<h3>REJILLA MEDICO</h3><br/>';
echo '</div>';
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