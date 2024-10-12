<?php 

class Auto {

    private $patente;
    private $marca;
    private $modelo;
    private $objDuenio;
    private $mensajeoperacion;

    public function __construct(){
        $this->patente = "";
        $this->marca = "";
        $this->modelo = 0;
       // $this->dniDuenio = new Persona();
        $this->mensajeoperacion = "";
    }

    public function setear($patente, $marca, $modelo, $objDuenio){
        $this->setPatente($patente);
        $this->setMarca($marca);
        $this->setModelo($modelo);
        $this->setObjDuenio($objDuenio);
    }

    public function getPatente() {
        return $this->patente;
    }

    public function setPatente($patente) {
        $this->patente = $patente;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getObjDuenio() {
        return $this->objDuenio;
    }

    public function setObjDuenio($objDuenio) {
        $this->objDuenio = $objDuenio;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    public function cargar(){
        $msj = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM auto WHERE patente = '".$this->getPatente()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $registro = $base->Registro();
                    $this->setear($registro['patente'], $registro['marca'], $registro['modelo'], $registro['dniDuenio']);   
                    $msj = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Auto->cargar: ".$base->getError());
        }
        return $msj;    
    }

    public function insertar(){
        $msj = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO auto(patente, marca, modelo, dniDuenio) VALUES('".$this->getPatente()."', '".$this->getMarca()."', ".$this->getModelo().", '".$this->getObjDuenio()->getNroDni()."');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->insertar: ".$base->getError());
        }
        return $msj;
    }

    public function modificar(){
        $msj = false;
        $base = new BaseDatos();
        $sql = "UPDATE auto SET marca='".$this->getMarca()."', modelo=".$this->getModelo().", dniDuenio='".$this->getObjDuenio()->getNroDni()."' WHERE patente='".$this->getPatente()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
        }
        return $msj;
    }

    public function eliminar(){
        $msj = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM auto WHERE patente='".$this->getPatente()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
        }
        return $msj;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM auto";
        if ($parametro != "") {
            $sql .= " WHERE ".$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res > -1){
            if($res > 0){
                while ($registro = $base->Registro()){
                    $obj = new Auto();
                    $obj->setear($registro['patente'], $registro['marca'], $registro['modelo'], $registro['dniDuenio']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
           // $this->setmensajeoperacion("Auto->listar: ".$base->getError());
           $mensajeError = "Persona->listar: " . $base->getError();
           error_log($mensajeError); 
        }
        return $arreglo;
    }
}
