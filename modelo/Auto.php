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

    public function cargar() {
        echo "cargando auto";
        global $client; // Usamos el cliente de Redis global
        $base = new BaseDatos();
        $msj = false;
    
        $inicioRedis = microtime(true);
        // Clave para el cache de Redis basada en la patente del auto
        $cacheKey = 'auto:' . $this->getPatente();
        $registroCache = $client->get($cacheKey); // Verificar si el auto está en Redis
    
        if ($registroCache) {
            // Si el auto está en cache, cargamos los datos desde Redis
            $registro = json_decode($registroCache, true);
            $this->setear($registro['patente'], $registro['marca'], $registro['modelo'], $registro['dniDuenio']);
            //calculo de tiempo de la consulta
            $finRedis = microtime(true);
            $tiempoTotal = $finRedis - $inicioRedis;
            echo "Tiempo de acceso a Redis: " . $tiempoTotal . " segundos\n";

            $msj = true;
        }else{
            $inicioSQL = microtime(true);
            // Si no está en cache, consultamos la base de datos
            $sql = "SELECT * FROM auto WHERE patente = '" . $this->getPatente() . "'";
            if ($base->Iniciar()) {
                $res = $base->Ejecutar($sql);
                if ($res > -1) {
                    if ($res > 0) {
                        $registro = $base->Registro();
                        $this->setear($registro['patente'], $registro['marca'], $registro['modelo'], $registro['dniDuenio']);
        
                        $finSQL = microtime(true);
                        $tiempoTotal = $finSQL - $inicioSQL;
                       
                        echo "Tiempo de consulta SQL: " . $tiempoTotal . " segundos\n";    
                        // Almacenar en Redis
                        $client->set($cacheKey, json_encode($registro));
        
                        $msj = true;
                    }
                }
            } else {
                $this->setmensajeoperacion("Auto->cargar: " . $base->getError());
            }
        }
        return $msj;
    }
    
    public function insertar() {
        global $client; // Usamos el cliente de Redis global
        $msj = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO auto(patente, marca, modelo, dniDuenio) VALUES('".$this->getPatente()."', '".$this->getMarca()."', ".$this->getModelo().", '".$this->getObjDuenio()->getNroDni()."');";
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Almacenar en Redis
                $registro = [
                    'patente' => $this->getPatente(),
                    'marca' => $this->getMarca(),
                    'modelo' => $this->getModelo(),
                    'dniDuenio' => $this->getObjDuenio()->getNroDni()
                ];
                $client->set('auto:' . $this->getPatente(), json_encode($registro)); // Guardar en Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->insertar: " . $base->getError());
        }
    
        return $msj;
    }
    

    public function modificar() {
        global $client; // Usamos el cliente de Redis global
        $msj = false;
        $base = new BaseDatos();
        $sql = "UPDATE auto SET marca='".$this->getMarca()."', modelo=".$this->getModelo().", dniDuenio='".$this->getObjDuenio()->getNroDni()."' WHERE patente='".$this->getPatente()."'";
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Actualizar en Redis
                $registro = [
                    'patente' => $this->getPatente(),
                    'marca' => $this->getMarca(),
                    'modelo' => $this->getModelo(),
                    'dniDuenio' => $this->getObjDuenio()->getNroDni()
                ];
                $client->set('auto:' . $this->getPatente(), json_encode($registro)); // Actualizar en Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->modificar: " . $base->getError());
        }
    
        return $msj;
    }

    public function eliminar() {
        global $client; // Usamos el cliente de Redis global
        $msj = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM auto WHERE patente='" . $this->getPatente() . "'";
    
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                // Eliminar de Redis
                $client->del('auto:' . $this->getPatente()); // Borrar de Redis
                $msj = true;
            } else {
                $this->setmensajeoperacion("Auto->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->eliminar: " . $base->getError());
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
