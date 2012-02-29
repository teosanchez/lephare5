<?php

class utilidadesIU {
    
     public function pinta_selection($datos,$nombre,$campoVisible,$seleccion=-1)
    {

        $salida= '<select size="1" name="'.$nombre.'">';

        while($row = mysql_fetch_array($datos))
        {    
                if($seleccion==$row['id'])
                {
                    $selected=" selected ";
                }
                else
                {
                    $selected='';
                }
                $salida.='<option  '.$selected.'value="'.$row['id'].'">'.$row[$campoVisible].'</option>';
        }
        $salida.= "</select>";
        return $salida;

    }
    


     public function pinta_selection2($datos,$nombre,$campoVisible,$seleccion=-1)
    {

        $salida= '<select size="1" name="'.$nombre.'">';

        while($row = mysql_fetch_array($datos))
        {    
                if($seleccion==$row['anio'])
                {
                    $selected=" selected ";
                }
                else
                {
                    $selected='';
                }
                $salida.='<option  '.$selected.'value="'.$row['anio'].'">'.$row[$campoVisible].'</option>';
        }
        $salida.= "</select>";
        return $salida;

    }
}
?>
