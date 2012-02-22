<?php
include ("clase_visitas.php");
include ("utilidadesIU.php");
include_once ("clase_bd.php");
include("clase_citas.php");
$bd=new bd();
$util=new utilidadesIU();
$visitas=new visitas();
if(isset($_GET["id"]))
    {
    $visitas->id=($_GET["id"]);
    $arrayEntidad=$bd->buscar($visitas);
    if($arrayEntidad)
        {
        $visitas->cargar($arrayEntidad[0]);
        }
    }
 else
     {
     if(isset ($_GET['id_cita']))
        {
         $cita=new citas();
         $cita->id=$_GET ['id_cita'];
         $arrayCita=$bd->buscar($cita);
         $cita->cargar($arrayCita[0]);
         $visitas->id_medico=$cita->id_medico;
         $visitas->id_paciente=$cita->id_paciente;
        }
     }   
?>
<h3><u>EDICIÓN VISITAS</u><br></h3>
<form name="form_visitas" method="get" action="procesar_visitas.php">
    <input type="hidden" name="id" id="id" value="<?php echo $visitas->id; ?>"/>
    <?php
        if(isset ($_GET["id_cita"]))
            {
            echo '<input type="hidden" name="id_cita" id="id_cita" value="'.$cita->id.'"/>';
            }
    ?>
    <table>
        <tr>
            <td>Paciente</td>
            <td>
            <?php
                $datosLista=$bd->consultar(      "select substr(concat(pacientes.apellidos,', ',pacientes.nombre),1,40) AS Paciente,
                    id from pacientes");
                echo $util->pinta_selection($datosLista,"id_paciente","Paciente",$visitas->id_paciente);
            ?>
            </td>
        </tr>
        <tr>
            <td>Médico</td>
            <td>
            <?php
               $datosLista=$bd->consultar("select substr(concat(medicos.apellidos,', ',medicos.nombre),1,40) AS Medico,id from medicos");
               echo $util->pinta_selection($datosLista,"id_medico","Medico",$visitas->id_medico);
            ?>
            </td>
        </tr>
        <tr>
            <td>Fecha</td>
            <td>
            <input type="text" name="fecha" id="fecha" value="<?php echo  $visitas->fecha; ?>"/>
            </td>
            </tr>
        <tr>
            <td>Tarifa de Consulta</td>
            <td>
            <input type="text" name="tarifa_consulta" id="tarifa_consulta" value="<?php echo  number_format($visitas->tarifa_consulta,2); ?>"/>
            </td>
        </tr>
        <tr>
            <td>Tarifa de Diabetes</td>
            <td>
            <input type="text" name="tarifa_diabetes" id="tarifa_diabetes" value="<?php echo  number_format($visitas->tarifa_diabetes,2); ?>"/>
            </td>
        </tr>
        <tr>
            <td>Tarifa de Medicamentos</td>
            <td>
            <input type="text" name="tarifa_medicamentos" id="tarifa_medicamentos" value="<?php echo  number_format($visitas->tarifa_medicamentos,2); ?>"/>
            </td>
        </tr>
        <tr>
            <td>Diagnóstico</td>
            <td>
            <textarea cols="42" rows="4" name="diagnostico" id="diagnostico" value=""/><?php echo  $visitas->diagnostico; ?>
            </textarea>
            </td>
        </tr>
        <tr>
            <td>Medicamentos</td>
            <td>
            <textarea cols="42" rows="4" name="medicamentos" id="medicamentos" value=""/><?php echo  $visitas->medicamentos; ?>
            </textarea>
            </td>
        </tr>
        <tr>
            <td><input class="boton" type="submit" name="Enviar" value="Enviar"/><?php if(!isset ($_GET["id_cita"]) && isset ($_GET["id"]) )
                { echo '<input class="boton" type="submit" name="Borrar" value="Borrar"/>';} ?></td>
            <td><input class="boton" type="submit" name="Cancelar" value="Cancelar"/></td>
        </tr>
    </table>
</form>