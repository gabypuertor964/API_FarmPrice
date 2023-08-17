<?php

    require "getDataModel.php";
    require "../controller/hash.php";

    /*
        Nombre clase: authModel
        Extendida: Si -> class conection

        Objetivo: Clase encargada de realizar todas las operaciones en BD relacionadas con el modulo de autenticacion
    */
    class authModel extends getDataModel{

        public function __construct(string $table){
            parent::__construct();
            $this->table=$table;
        }

        /**
         * Validar la existencia del token y si es posible, retornar el id del usuario
         * 
         * @param string $token Token a validar
         * @return int Id del usuario
        */
        public function validateToken(string $token){
            $token=authHash::generateToken($token);

            //Validar el token y retornar (Si es posible) el identificador del usuario
            return $this->conditionQueryData('id',"token='$token'");
        }

        /** 
         * Consultar la informacion requerida del usario segun su id
         * 
         * @param int $id Id del usuario
         * @param string $columns Columnas a consultar
         * 
         * @return array Arreglo con los datos solicitados
        */
        public function getDataUser(int $id,string $columns){
            return $this->conditionQueryData($columns,"id='$id'");
        }
    
        /**
         * Realizar el guardado de la informacion de un nuevo usuario
         * 
         * @param array $unique Listado de campos unicos a validar
         * @param array $data Arreglo asociativo de los datos a registrar
         * 
         * @return array Arreglo con detallado del proceso realizado
        */
        public function register(array $unique,array $data){

            /* === Validacion de registos unicos === */
                foreach($data as $key=>$value){
                    if(in_array($key,$unique)){
                        if($this->validateUnique($key,$value)['count']>0){
                            return [
                                'status'=>False,
                                'message'=>"El campo $key ya se encuentra registrado"
                            ];
                        }
                    }
                }
            //

            /* === Guardado de Datos === */
                $id_role=$data['id_role'];
                $name=$data['name'];
                $id_gender=$data['id_gender'];
                $date_birth=$data['date_birth'];
                $id_doc_typ=$data['id_doc_typ'];
                $doc_num=$data['doc_num'];
                $email=$data['email'];
                $password_hash=$data['password_hash'];
                $token=$data['token'];
            //

            /* === Ejecucion de la consulta === */
                return [
                    'status'=>$this->db_conection->query("INSERT INTO users values(null,$id_role,'$name',$id_gender,'$date_birth',$id_doc_typ,'$doc_num','$email','$password_hash','$token');"),
                    'message'=>'Te has registrado exitosamente'
                ];
            //

        }
    }

?>