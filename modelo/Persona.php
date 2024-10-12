<?php 
class Persona {

    /**REVISAR EL ID AUTOINCREMENTABLE
     * SET MENSAJE OPERACION
     * PUBLIC STATIC
    */
    private $nroDni;
    private $apellido;
    private $nombre;
    private $fechaNac;
    private $telefono;
    private $domicilio;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->nroDni="";
        $this->apellido="";
        $this->nombre="";
        $this->fechaNac="";
        $this->telefono="";
        $this->domicilio="";
        $this->mensajeoperacion ="";
    }

    public function setear($nroDni, $apellido, $nombre, $fechaNac, $telefono, $domicilio){
        $this->setNroDni($nroDni);
        $this->setApellido($apellido);
        $this->setNombre($nombre);
        $this->setFechaNac($fechaNac);
        $this->setTelefono($telefono);
        $this->setDomicilio($domicilio);
    }
    
    public function getNroDni() {
    	return $this->nroDni;
    }

    public function setNroDni($nroDni) {
    	$this->nroDni = $nroDni;
    }

    public function getApellido() {
    	return $this->apellido;
    }

    public function setApellido($apellido) {
    	$this->apellido = $apellido;
    }

    public function getNombre() {
    	return $this->nombre;
    }

    public function setNombre($nombre) {
    	$this->nombre = $nombre;
    }

    public function getFechaNac() {
    	return $this->fechaNac;
    }

    public function setFechaNac($fechaNac) {
    	$this->fechaNac = $fechaNac;
    }

    public function getTelefono() {
    	return $this->telefono;
    }

    public function setTelefono($telefono) {
    	$this->telefono = $telefono;
    }

    public function getDomicilio() {
    	return $this->domicilio;
    }
   
    public function setDomicilio($domicilio) {
    	$this->domicilio = $domicilio;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }
    
    public function cargar(){
        $msj = false;
        $base=new BaseDatos();
        $sql= "SELECT * FROM persona WHERE nroDni = ".$this->getNroDni();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res > -1){
                if($res > 0){
                    $registro = $base->Registro();
                    $this->setear($registro['nroDni'], $registro['apellido'], $registro['nombre'], $registro['fechaNac'], $registro['telefono'], $registro['domicilio']);   
                    $msj = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Persona->listar: ".$base->getError());
        }
        return $msj;    
    }
    
    public function insertar(){
        $msj = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO persona(nroDni, apellido, nombre, fechaNac, telefono, domicilio) VALUES ('" . 
       $this->getNroDni() . "', '" . $this->getApellido() . "', '" . $this->getNombre() . "', '" . 
       $this->getFechaNac() . "', '" . $this->getTelefono() . "', '" . $this->getDomicilio() . "');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->insertar: ".$base->getError());
        }
        return $msj;
    }
    
    public function modificar(){
        $msj = false;
        $base=new BaseDatos();
        $sql="UPDATE persona SET apellido='".$this->getApellido()."',nombre='".$this->getNombre()."',fechaNac='".$this->getFechaNac()."',telefono='".$this->getTelefono()."',domicilio='".$this->getDomicilio()."' WHERE nroDni=".$this->getNroDni();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->modificar: ".$base->getError());
        }
        return $msj;
    }
    
    public function eliminar(){
        $msj = false;
        $base=new BaseDatos();
        $sql="DELETE FROM persona WHERE nroDni=".$this->getNroDni();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->eliminar: ".$base->getError());
        }
        return $msj;
    }
    
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM persona ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($registro = $base->Registro()){
                    $obj= new Persona();
                    $obj->setear($registro['nroDni'], $registro['apellido'], $registro['nombre'], $registro['fechaNac'], $registro['telefono'], $registro['domicilio']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
   //           $this->setmensajeoperacion("Persona->listar: ".$base->getError());
                $mensajeError = "Persona->listar: " . $base->getError();
                error_log($mensajeError);  
        }
        return $arreglo;
    }
}