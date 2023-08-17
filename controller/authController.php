<?php
    require "../model/authModel.php";

    /**
     * Clase: authController
     * 
     * Extension: No
     * 
     * Description (Spanish): Esta clase esta encargada de gestionar todos los procesos relacionados con el modulo de Autenticacion 
    */
    class authController{

        /** 
         * Partiendo del token recibido se realizara la validacion del hash de este, retornando (si es posible) el identificador del usuario asociado al token
         * 
         * @param string $token Token enviado por el cliente
         * 
         * @return
        */
        public static function validateToken(string $token){
            $model=new authModel('users');
            return $model->validateToken($token);
        }

        /**
         * Emplear el metodo validateToken y segun los datos que este retorne realizar las consultas correspondientes o retornar un mensaje de error
         * 
         * @param string $token Token enviado por el cliente
         * @return array Detallado en forma de arreglo asociativo de la operacion realizada
        */
        public static function login(string $token){

            $id_user=self::validateToken($token);

            if(isset($id_user['id'])){

                $model=new authModel('users');
                $model->table="users";

                $data_user=$model->getDataUser($id_user['id'],'name,id_role');

                return [
                    'status'=>TRUE,
                    'message'=>'Inicio de sesion exitoso',
                    'data'=>$data_user
                ];
            }else{

                return [
                    'status'=>FALSE,
                    'message'=>'Datos Invalidos'
                ];
            }
        }

        /**
         * Emplear el modelo y realizar el proceso de registro de un nuevo usuario
         * 
         * @param array $data Informacion a emplear
         * @return string Mensaje en forma de Json sobre el resultado del proceso
        */
        public static function register($data){
            $model=new authModel('users');

            $data=[
                'id_role'=>$data['id_role'],
                'name'=>$data['name'],
                'id_gender'=>$data['id_gender'],
                'date_birth'=>$data['date_birth'],
                'id_doc_typ'=>$data['id_doc_typ'],
                'doc_num'=>$data['doc_num'],
                'email'=>$data['email'],
                'password_hash'=>password_hash($data['password'],PASSWORD_DEFAULT),
                'token'=>authHash::generateToken($data['token'])
            ];

            $unique=['name','doc_num','email','password_hash','token'];
            $query=$model->register($unique,$data);

            return Json::createJsonMessage($query['status'],$query['message']);
        }

    }   
?>