<?php

    /*
        Nombre clase: authHash
        Extendida: No

        Objetivo: Realizar los procedimientos de generacion y validacion de hash
    */
    class authHash{

       /*
            Nombre constante: salt
            Objetivo: Frase secreta para el hasheo
       */
        private const salt="92031993acdc0c23c4ae50b7473f98ec6f0fcc97";

        /*
            Nombre Metodo: generateToken
            Objetivo: Generar el token de acceso unico para cada usuario
        */
        public static function generateToken($hash){
            return hash('sha512', self::salt.$hash);
        }

    }
?>