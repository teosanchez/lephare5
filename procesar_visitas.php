<?php

include ("clase_visitas.php");
include_once ("clase_bd.php");
include("clase_citas.php");
include("clase_contabilidad.php");
$visitas = new visitas();
$contabilidad = new contabilidad;
$bd = new bd();
if (isset($_GET["Enviar"])) {
    if (isset($_GET["id"])) {
        $visitas->id = $_GET["id"];
        $visitas->id_paciente = $_GET["id_paciente"];
        $visitas->id_medico = $_GET["id_medico"];
        $visitas->fecha = date("Y-m-d", strtotime($_GET["fecha"]));
        $visitas->hora =$_GET["hora"];
        $visitas->tarifa_consulta = $_GET["tarifa_consulta"];
        $visitas->tarifa_diabetes = $_GET["tarifa_diabetes"];
        $visitas->tarifa_medicamentos = $_GET["tarifa_medicamentos"];
        $visitas->diagnostico = $_GET["diagnostico"];
        $visitas->medicamentos = $_GET["medicamentos"];
        $contabilidad->id_visita = $_GET["id"];
        $contabilidad->fecha = date("Y-m-d", strtotime($_GET["fecha"]));
        if ($_GET["id"] != "") {
            $contabilidad->id_visita = $_GET["id"];
            $bd->consultar("DELETE FROM contabilidad WHERE id_visita = '$contabilidad->id_visita'");
        }
        if ($_GET["id"] == "") {
            $nuevo_id = $bd->insertar($visitas);
            $contabilidad->id_visita = $nuevo_id;
            $contabilidad->tipo = 0;
            $msj2 = "Registro Insertado Correctamete."; //Incluir en Generador
            if (isset($_GET["id_cita"])) {
                $cita = new citas();
                $cita->id = $_GET["id_cita"];
                $cita->visitado = true;
                $bd->actualizar($cita);
                $msj2 = "Registro Actualizado Correctamete."; //Incluir en Generador
                //$bd->consultar ("update vw_rejilla_citas set Visitado=true where id=".$_GET["id_cita"]);
                }
        } else {
            $bd->actualizar($visitas);
            $msj2 = "Registro Actualizado Correctamete."; //Incluir en Generador
            }
        if ($_GET["tarifa_consulta"] != "") {
            $contabilidad->cantidad = $_GET['tarifa_consulta'];
            $contabilidad->id_concepto = 5;
            $bd->insertar($contabilidad);
        }
        if ($_GET["tarifa_medicamentos"] != "") {
            $contabilidad->cantidad = $_GET['tarifa_medicamentos'];
            $contabilidad->id_concepto = 6;
            $bd->insertar($contabilidad);
    }
        if ($_GET["tarifa_diabetes"] != "") {
            $contabilidad->cantidad = $_GET['tarifa_diabetes'];
            $contabilidad->id_concepto = 7;
            $bd->insertar($contabilidad);
        }
    }
}
if (isset($_GET["Borrar"])) {
    $contabilidad->id_visita = $_GET["id"];
    $bd->consultar("DELETE FROM contabilidad WHERE id_visita = '$contabilidad->id_visita'");
    $visitas->id = $_GET["id"];    
    $bd->borrar($visitas);
    $msj2 = "Registro Eliminado Correctamente."; //Incluir en Generador
    }
if (isset($_GET["id_cita"])) {
    header('Location: index.php?cuerpo=rejilla_citas.php');
} else {
    header('Location: index.php?cuerpo=rejilla_visitas.php&msj2=' . $msj2); //Incluir en Generador
    }
?>