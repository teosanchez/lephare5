<?php
include ("clase_rejilla_pacientes.php");
include_once ("clase_bd.php");
include_once ("clase_paginador.php");

$bd=new bd();
/*********** Establecer consulta ***************/
$cadena="";   
$carnet="";    
$result="";     
$result2="";
/*********** Paginacion ***************/
if(!isset($_GET['ipp']))
    {
    $_GET['ipp']='';
    }
$result2=$bd->consultarArray("SELECT * FROM vw_rejilla_pacientes");
$num_registros=count($result2);
$pages= new Paginator;
$pages->items_total=$num_registros;
$pages->paginate();
/*********** Fin Paginacion ***************/
if(isset ($_GET["carnet"]) && $_GET["carnet"]<>"")
    {	
    $carnet=$_GET["carnet"];
    $result=$bd->consultarArray("select * from vw_rejilla_pacientes where `Numero de Carnet`='".$carnet."'$pages->limit");
    $result2=$bd->consultarArray("select * from vw_rejilla_pacientes where `Numero de Carnet`='".$carnet."'");
    $num_registros=count($result2); 
    $pages->items_total=$num_registros;
    $pages->paginate();
    }
else
    {
    if(isset ($_GET["cadena"]) && $_GET["cadena"]<>"")
        {	
        $cadena=$_GET["cadena"];
        $result=$bd->consultarArray("SELECT * from vw_rejilla_pacientes where Paciente like '%".$cadena."%' 
                                    or `Nombre de la Madre` like '%".$cadena."%'$pages->limit");
        $result2=$bd->consultarArray("SELECT * from vw_rejilla_pacientes where Paciente like '%".$cadena."%' 
                                or`Nombre de la Madre` like '%".$cadena."%'");
        $num_registros=count($result2); 
        $pages->items_total=$num_registros;
        $pages->paginate();
        }
    else
        {
        if (!isset($_GET["buscar_carnet"]) and !isset($_GET["buscar_cadena"]))
            {	
            /*paginacion (ordenado por fecha)*/
            $result=$bd->consultarArray("SELECT * FROM vw_rejilla_pacientes ORDER BY Paciente $pages->limit");
            }
        }   
    }
/******************** Fin establecer consulta *****************/

echo '<h3>REJILLA PACIENTES</h3><br/>';

if($result)
    {
    $rejilla=new rejilla_pacientes($result,"index.php?cuerpo=form_pacientes.php&","id","Paciente");
    echo $rejilla->pintar();
    if ($result2<>"")       /* Incluir  en generador este if */
        {
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
    if (isset($_GET["buscar_carnet"]) && $carnet=="")
        {
        echo '<p class="error">Introduzca nº de carnet.</p>';
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
    }                                         //Incluir en Generador 
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
if(isset ($_GET["buscar"]) or isset ($_GET["todos"]) or isset ($_GET["buscar_carnet"]))
    {
    echo '<form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="rejilla_pacientes.php" />
    <br/><input class="boton" type="submit" name="Cancelar" value="Cancelar"/>
    </form><br/>';
    }
else 
    {
    echo '<form action="index.php" method="get">
    <br/>Buscar
    <input type="text" name="cadena"/>
    <input type="hidden" name="cuerpo" value="rejilla_pacientes.php" />
    <input class="boton" type="submit" name="buscar_cadena" value="Buscar"/>
    </form>
    <form action="index.php" method="get">
    <br/>Buscar Nº de carnet
    <input type="text" name="carnet"/>
    <input type="hidden" name="cuerpo" value="rejilla_pacientes.php" />
    <input class="boton" type="submit" name="buscar_carnet" value="Buscar"/>
    </form>        
    <form action="index.php" method="get">
    <input type="hidden" name="cuerpo" value="form_pacientes.php" />
    <br/><input class="boton" type="submit" name="nuevo" value="Nuevo"/>
    </form><br/><br/>';
    } //Incluir en Generador  
?>    