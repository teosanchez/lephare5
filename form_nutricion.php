<?php
include ("clase_nutricion.php");
include ("utilidadesIU.php");
include_once ("clase_bd.php");

$bd=new bd();
$util=new utilidadesIU();
$nutricion=new nutricion();
if(isset($_GET["id"]))
{
    $nutricion->id=($_GET["id"]);
    $arrayEntidad=$bd->buscar($nutricion);
    if($arrayEntidad)
    {
        $nutricion->cargar($arrayEntidad[0]);
    }
}




?>
<h3><u>EDICI�N NUTRICI�N</u><br></h3>
<form name="form_nutricion" method="get" action="procesar_nutricion.php">
<input type="hidden" name="id" id="id" value="<?php echo $nutricion->id; ?>"/>
<table>
<!--<tr>
<td>id</td>
<td>
<input type="text" name="id" id="id" enabled="false" value="<?php //echo  $nutricion->id; ?>"/>
</td>
</tr>
<tr>-->
    
<td>Paciente</td>
<td>
<?php 
    $datosLista=$bd->consultar("select concat(pacientes.apellidos,',  ',pacientes.nombre) AS Paciente,id from pacientes");
    echo $util->pinta_selection($datosLista,"id_paciente","Paciente",$nutricion->id_paciente);
?>
<!--<input type="text" name="id_paciente" id="id_paciente" value="<?php //echo  $nutricion->id_paciente; ?>"/>-->
</td>
</tr>
<tr>
<td>Fecha Ingreso</td>
<td>
<input type="text" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo  $nutricion->fecha_ingreso; ?>"/>
</td>
</tr>
<tr>
<td>Peso Ingreso</td>
<td>
<input type="text" name="peso_ingreso" id="peso_ingreso" value="<?php echo  $nutricion->peso_ingreso; ?>"/>
</td>
</tr>
<tr>
<td>Peso Nacimiento</td>
<td>
<input type="text" name="peso_nacimiento" id="peso_nacimiento" value="<?php echo  $nutricion->peso_nacimiento; ?>"/>
</td>
</tr>
<tr>
<td>Peso Alta</td>
<td>
<input type="text" name="peso_alta" id="peso_alta" value="<?php echo  $nutricion->peso_alta; ?>"/>
</td>
</tr>
<tr>
<td>Enfermedad</td>
<td>
<?php 
    $datosLista=$bd->consultar("select * from t_enfermedades");
    echo $util->pinta_selection($datosLista,"enfermedad","enfermedad",$nutricion->enfermedad);
?>
</td>
</tr>
<tr>
<td>Fecha Muerte</td>
<td>
<input type="text" name="fecha_muerte" id="fecha_muerte" value="<?php echo  $nutricion->fecha_muerte; ?>"/>
</td>
</tr>
<tr>
<td>Fecha Alta</td>
<td>
<input type="text" name="fecha_alta" id="fecha_alta" value="<?php echo  $nutricion->fecha_alta; ?>"/>
</td>
</tr>
<tr>
<td>Reenvio Hospital</td>
<td>
<input type="text" name="reenvio_hospital" id="reenvio_hospital" value="<?php echo  $nutricion->reenvio_hospital; ?>"/>
</td>
</tr>
<tr>
	<td><input type="submit" name="Enviar" value="Aceptar"/></td>
        <td><?php if(isset($_GET['id']))
            {
                echo '<input type="submit" name="Borrar" value="Borrar"/>';
            }?>
            <input type="submit" name="Cancelar" value="Cancelar"/></td>
        </tr>
     </table>
     </form>