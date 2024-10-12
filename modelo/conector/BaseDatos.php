<?php

class BaseDatos extends PDO {
  
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
  	private $debug;
  	private $conec;
  	private $indice;
  	private $resultado;
    private $error;
    private $sql;
    
    public function __construct(){
        $this->engine = 'mysql';
        $this->host = 'localhost';
        $this->database = 'infoautos';
        $this->user = 'root';
        $this->pass = '';
        $this->debug = true;
        $this->error = "";
        $this->sql = "";
        $this->indice = 0;
        
        $dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
        try {
            parent::__construct($dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->conec = true;
        } catch (PDOException $e) {
            $this->conec = false;
            $this->sql = $e->getMessage();
        }
    }
    
    public function Iniciar(){
        return $this->getConec();
    }

    public function getConec(){
        return $this->conec;
    }
    
    public function setDebug($debug){
        $this->debug = $debug;
    }
    
    public function getDebug(){
        return $this->debug;
    }
  
    public function setError($e){
        $this->error = $e;
    }
        
    public function getError(){
        return "\n".$this->error;
    }
    
    public function setSQL($e){
        return "\n".$this->sql = $e;
    }
    
    public function getSQL(){
        return "\n".$this->sql;
    }
    
    public function Ejecutar($sql){
        // Verificar si la conexión fue exitosa antes de ejecutar cualquier consulta
        if (!$this->conec) {
            $this->setError("No se pudo conectar a la base de datos.");
            return false; // Retornar false si la conexión falló
        }
        
        $this->setError("");
        $this->setSQL($sql);
        $resp = false;

        //echo "\n \n consulta \n";
        //echo $sql;
        //echo "\n\n";



        
        // Verificar tipo de consulta (INSERT, UPDATE, DELETE, SELECT)
        if (stristr($sql, "insert")) { 
            $resp = $this->EjecutarInsert($sql);
        } elseif (stristr($sql, "update") || stristr($sql, "delete")) {
            $resp = $this->EjecutarDeleteUpdate($sql);
        } elseif (stristr($sql, "select")) {
            $resp = $this->EjecutarSelect($sql);
        }
        
        return $resp;
   }
   
   private function EjecutarInsert($sql){
       $resultado = parent::query($sql);
       if (!$resultado) {
           $this->analizarDebug();
           $id = 0;
       } else {
           $id = $this->lastInsertId(); 
           if ($id == 0) {
               $id = -1;
           }
       }
       return $id;
   }
   
   private function EjecutarDeleteUpdate($sql){
       $cantFilas = -1;
       $resultado = parent::query($sql);
       if (!$resultado) {
           $this->analizarDebug();
       } else {
           $cantFilas = $resultado->rowCount();
       }
       return $cantFilas;
   }
   
   private function EjecutarSelect($sql){
       $cant = -1;
       $resultado = parent::query($sql);
       if (!$resultado) {
           $this->analizarDebug();
       } else {
           $arregloResult = $resultado->fetchAll();
           $cant = count($arregloResult);
           $this->setIndice(0);
           $this->setResultado($arregloResult);
       }
       return $cant;
   }
   
   public function Registro() {
       $filaActual = false;
       $indiceActual = $this->getIndice();
       if ($indiceActual >= 0) {
           $filas = $this->getResultado();
           if ($indiceActual < count($filas)) {
               $filaActual = $filas[$indiceActual];
               $indiceActual++;
               $this->setIndice($indiceActual);
           } else {
               $this->setIndice(-1);
           }
       } 
       return $filaActual;
   }
   
   private function analizarDebug(){
       $e = $this->errorInfo();
       $this->setError($e);
       if ($this->getDebug()) {
           echo "<pre>";
           print_r($e);
           echo "</pre>";
       }
   }
   
   private function setIndice($valor){
       $this->indice = $valor;
   }
   
   private function getIndice(){
       return $this->indice;
   }
   
   private function setResultado($valor){
       $this->resultado = $valor;
   }
   
   private function getResultado(){
       return $this->resultado;
   }
}
