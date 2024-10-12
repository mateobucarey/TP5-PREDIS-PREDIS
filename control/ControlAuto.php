<?php

class ControlAuto {

/**
 * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancia del objeto
 * @param array $param
 * @return Auto
 */
private function cargarObjeto($param){
    $obj = null;
       
    if( array_key_exists('patente',$param) && array_key_exists('marca',$param) && array_key_exists('modelo',$param) && array_key_exists('dniDuenio',$param)){

        $objPersona = new Persona();
        $objPersona->setNroDni($param['dniDuenio']);
        $objPersona->cargar();

        $obj = new Auto();
        $obj->setear($param['patente'], $param['marca'], $param['modelo'], $objPersona);
    }
    return $obj;
}

/**
 * Espera como parámetro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancia del objeto que son claves
 * @param array $param
 * @return Auto
 */
private function cargarObjetoConClave($param){
    $obj = null;
    
    if( isset($param['patente']) ){
        $obj = new Auto();
        $obj->setear($param['patente'], null, null, null);
    }
    return $obj;
}


/**
 * Corrobora que dentro del arreglo asociativo están seteados los campos claves
 * @param array $param
 * @return boolean
 */

private function seteadosCamposClaves($param){
    $resp = false;
    if (isset($param['patente']))
        $resp = true;
    return $resp;
}

/**
 * permite insertar un objeto
 * @param array $param
 */
public function alta($param){
    $resp = false;
    $objAuto = $this->cargarObjeto($param);
    if ($objAuto != null && $objAuto->insertar()){
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
        $objAuto = $this->cargarObjetoConClave($param);
        if ($objAuto != null && $objAuto->eliminar()){
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
    $resp = false;
    if ($this->seteadosCamposClaves($param)){
        $objAuto = $this->cargarObjeto($param);
        if($objAuto != null && $objAuto->modificar()){
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
    if ($param != NULL){
        if (isset($param['patente']))
            $where .= " and patente = '".$param['patente']."'";
        if (isset($param['dniDuenio']))
            $where .= " and dniDuenio = '".$param['dniDuenio']."'";
        /*if (isset($param['marca']))
            $where .= " and marca = '".$param['marca']."'";
        if (isset($param['modelo']))
            $where .= " and modelo = ".$param['modelo'];
        */
    }
    $arreglo = Auto::listar($where);  
    return $arreglo;
}
}
