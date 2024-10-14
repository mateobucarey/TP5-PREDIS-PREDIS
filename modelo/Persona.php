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
    
    public function cargar() {
        echo "esta cargando";
        global $client;
        $base = new BaseDatos();
        $msj = false;
        //$tiempoTotal = 0;
        
        $inicioRedis = microtime(true);
        // Verifica si el registro está en Redis
        $cacheKey = 'persona:' . $this->getNroDni();
        $registroCache = $client->get($cacheKey); // Usando la conexión a Redis

        if ($registroCache) {
            // Si existe en cache, lo cargamos
            $registro = json_decode($registroCache, true);
            $this->setear($registro['nroDni'], $registro['apellido'], $registro['nombre'], $registro['fechaNac'], $registro['telefono'], $registro['domicilio']);

            //calculo de tiempo de la consulta
            $finRedis = microtime(true);
            $tiempoTotal = $finRedis - $inicioRedis;
            echo "Tiempo de acceso a Redis: " . $tiempoTotal . " segundos\n";

            $msj = true;
        } else{
            $inicioSQL = microtime(true);
            $sql = "SELECT * FROM persona WHERE nroDni = " . $this->getNroDni();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $registro = $base->Registro();
                    $this->setear($registro['nroDni'], $registro['apellido'], $registro['nombre'], $registro['fechaNac'], $registro['telefono'], $registro['domicilio']);

                    $finSQL = microtime(true);
                    $tiempoTotal = $finSQL - $inicioSQL;
                    echo "Tiempo de consulta SQL: " . $tiempoTotal . " segundos\n";
                    // Almacenar en Redis
                    $client->set($cacheKey, json_encode($registro));
                    $msj = true;
                }
            }
        } else {
            $this->setmensajeoperacion("Persona->listar: " . $base->getError());
        }
        }   
        return $msj;
    }
   
    public function insertar() {
        global $client;
        $msj = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO persona(nroDni, apellido, nombre, fechaNac, telefono, domicilio) VALUES ('" . 
       $this->getNroDni() . "', '" . $this->getApellido() . "', '" . $this->getNombre() . "', '" . 
       $this->getFechaNac() . "', '" . $this->getTelefono() . "', '" . $this->getDomicilio() . "');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Almacenar en Redis
                $registro = [
                    'nroDni' => $this->getNroDni(),
                    'apellido' => $this->getApellido(),
                    'nombre' => $this->getNombre(),
                    'fechaNac' => $this->getFechaNac(),
                    'telefono' => $this->getTelefono(),
                    'domicilio' => $this->getDomicilio()
                ];
                $client->set('persona:' . $this->getNroDni(), json_encode($registro)); // Guardar en Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->insertar: " . $base->getError());
        }
        return $msj;
    }

    public function eliminar() {
        global $client;
        $msj = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM persona WHERE nroDni=" . $this->getNroDni();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Eliminar de Redis
                $client->del('persona:' . $this->getNroDni()); // Borrar de Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->eliminar: " . $base->getError());
        }
        return $msj;
    }
    
    public function modificar() {
        global $client; // Usamos el cliente de Redis global
        $msj = false;
        $base = new BaseDatos();
        $sql = "UPDATE persona SET apellido='".$this->getApellido()."', nombre='".$this->getNombre()."', fechaNac='".$this->getFechaNac()."', telefono='".$this->getTelefono()."', domicilio='".$this->getDomicilio()."' WHERE nroDni=".$this->getNroDni();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Actualizar en Redis
                $registro = [
                    'nroDni' => $this->getNroDni(),
                    'apellido' => $this->getApellido(),
                    'nombre' => $this->getNombre(),
                    'fechaNac' => $this->getFechaNac(),
                    'telefono' => $this->getTelefono(),
                    'domicilio' => $this->getDomicilio()
                ];
                $client->set('persona:' . $this->getNroDni(), json_encode($registro)); // Actualizar en Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Persona->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->modificar: " . $base->getError());
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