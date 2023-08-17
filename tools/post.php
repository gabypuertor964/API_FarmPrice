<?php

    /* 
        Nombre clase: Post
        Extendida: No

        Objetivo: Contener todos los metodos relacionados con la recepcion y validacion de registros $_POST
    */
    class Post{

        /*
            Nombre Metodo: validateExistence

            Obejtivo: Metodo encargado de validar la existencia de los registros en $_POST segun su indice
        */
        public static function validateExistence(array $index_s){

            //Variable de Control
            $validation=TRUE;

            //Validacion bajo funcion Isset
            foreach($index_s as $index){
                if(!isset($_POST["$index"])){
                    $validation=FALSE;
                }
            }
            
            return $validation;
        }

        /*
            Nombre Metodo: getData

            Obejtivo: Metodo encargado de retornar la informacion de la variable $_POST
        */
        public static function getData($index_s){

            //Variable contendora
            $data=[];

            foreach($index_s as $index){
                $data["$index"]=self::getIndividualData($index);
            }

            //Retorno de datos obtenidos
            return $data;
        }

        public static function getIndividualData($index){
            return $_POST["$index"];
        }

    }

?>