<?php

class ControlPersona{

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Persona
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('nroDni',$param) && array_key_exists('apellido',$param) && array_key_exists('nombre',$param) && array_key_exists('fechaNac',$param) && array_key_exists('telefono',$param) && array_key_exists('domicilio',$param)){
            $obj = new Persona();
            $obj->setear($param['nroDni'], $param['apellido'], $param['nombre'], $param['fechaNac'], $param['telefono'], $param['domicilio']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Persona
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['nroDni']) ){
            $obj = new Persona();
            $obj->setear($param['nroDni'], null, null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['nroDni']))
            $resp = true;
        return $resp;
    }
    
    /**
     * permite insertar un objeto
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        //$param['id'] =null;
        $objPersona = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($objPersona!=null && $objPersona->insertar()){
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objPersona = $this->cargarObjetoConClave($param);
            if ($objPersona!=null && $objPersona->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objPersona = $this->cargarObjeto($param);
            if($objPersona!=null && $objPersona->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['nroDni']))
                $where.=" and nroDni =".$param['nroDni'];
           /* if  (isset($param['apellido']))
                 $where.=" and apellido ='".$param['apellido']."'";
            if  (isset($param['nombre']))
                 $where.=" and nombre ='".$param['nombre']."'";
            if  (isset($param['fechaNac']))
                 $where.=" and fechaNac ='".$param['fechaNac']."'";
            if  (isset($param['telefono']))
                 $where.=" and telefono ='".$param['telefono']."'";
            if  (isset($param['domicilio']))
                 $where.=" and domicilio ='".$param['domicilio']."'";*/
        }
        $arreglo = Persona::listar($where);  
        return $arreglo;
    }
}