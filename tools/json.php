<?php

    /* 
        Nombre clase: Json
        Extendida: No

        Objetivo: Contener todos los metodos relacionados con el manejo de archivos Json
    */
    class Json{

        /*
            Nombre Metodo: createJsonMessage 
            
            Formato de retorno: Json 
            Objetivo: Enviar Mensajes temporales
        */
        public static function createJsonMessage(bool $status,string $message){
            return json_encode([
                'status'=>$status,
                'message'=>$message
            ]);
        }

        /*
            Nombre Metodo: createJsonData 
            
            Formato de retorno: Json 
            Objetivo: Enviar grandes volumenenes de datos
        */
        public static function createJsonData(array $data){
            return json_encode($data);
        }

        /*
            Nombre Metodo: generateFailedMessage
            
            Formato de retorno: Json 
            Objetivo: Emplear el metodo 'createJsonMessage' y retornar un mensaje de accion fallida
        */  
        public static function generateFailedMessage($message){
            return self::createJsonMessage(FALSE,$message);
        }

        /**
         * Emplear el metodo 'createJsonMessage' y generar una respuesta de operacion exitosa
        */
        public static function generateSuccessMessage($message){
            return self::createJsonMessage(TRUE,$message);
        }
    }

?>