<?php
class validar_fecha implements Ivalidador 
   {
    public function validar($citas)
        {
        $fecha=$citas->fecha;
        $fecha_actual=date("Y-m-d");        
        if($fecha>=$fecha_actual)
            {
            return TRUE;
            }
        else 
            {
            return FALSE;
            }    
        }
    }
class validar_hora implements Ivalidador
    {
    public function validar($citas)
        {
        $hora=$citas->hora;        
        if ((strtotime($hora))===false)
            {            
            return false;
            } 
        else
            {            
            return true;
            }        
        }
    }
    class validar_citas_completo implements Ivalidador
    {
    public function validar($cita)
        {
        $val_fecha=new validar_fecha();
        $val_hora=new validar_hora();
        if($val_fecha->validar($cita) && $val_hora->validar($cita))
            {
            return TRUE;
            }
        else 
            {
            return FALSE;    
            }
        }
    }
    
?>
