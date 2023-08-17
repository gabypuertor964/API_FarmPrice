<?php

   /**
    * Class Name: conection 
    * 
    * Description (Spanish): Clase encargada de proveer acceso a BD
   */
   class conection{

      //Propiedades Privadas (Acceso solo en superclase)
      private $host='localhost';
      private $user='root';
      private $password='';
      private $database='api_farmprice';

      //Propiedades Protegidas (Permiten su acceso en herencia)
      public $db_conection;

      //Metodo constructor
      public function __construct(){
         $this->db_conection=new mysqli($this->host,$this->user,$this->password,$this->database);
      }
   }
   
?>