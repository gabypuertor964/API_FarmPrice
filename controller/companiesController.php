<?php
    
    require "../model/companiesModel.php";

    /**
     * Class Name: companiesModel
     * 
     * Extended: No
     * 
     * Description (Spanish): Clase encargada de gestionar todos los procesos relacionados con el modulo companies
    */
    class companiesController{

        /**
         * Emplear los metodos del modelo y registar una empresa 
         * 
         * @param string $token Token de acceso
         * @param array $data Arreglo asociativo de los datos a registrar
         * 
         * @return string Json del detallado de la operacion realizada
        */
        public static function create($token,$data){

            //Instanciamiento modelo
            $model=new companiesModel('users');

            //Obtencion (Si es posible) del id del usuario asociado al token
            $id_user=$model->validateToken($token);

            //Redefinicion tabla a usar
            $model->table="companies";
            
            if(isset($id_user['id'])){
                
                $unique=['name','nit'];
                $data=[
                    'id_user'=>$id_user['id'],
                    'name'=>$data['name'],
                    'nit'=>$data['nit']
                ];

                $query=$model->create($unique,$data);
                return Json::createJsonMessage($query['status'],$query['message']);

            }else{
                return Json::createJsonMessage(False,'Acceso no autorizado');
            }
        }

        /**
         * Emplear los metodos del modelo y realizar la consulta detallada de una empresa o el listado de empresas asociadas a un cliente
         * 
         * @param array $data Arreglo asociativo de la informacion a consultar asi como el token de autenticacion
         * 
         * @return string Json del detallado de la operacion realizada
        */
        public static function read($data){
            
            //Instanciamiento modelo
            $model=new companiesModel('users');

            //Obtencion (Si es posible) del id del usuario asociado al token
            $id_user=$model->validateToken($data['token']);

            //Redefinicion tabla a usar
            $model->table="companies";
        
            if(isset($id_user['id'])){

                switch($data['type']){

                    //Obtener y retornar informacion detalla de una unica Empresa
                    case 'individual':
                        $data_company=$model->getDataCompany($id_user['id'],$data['id']);

                        //Validacion Existencia registro de la empresa
                        if($data_company<>NULL){

                            return Json::createJsonData([
                                'status'=>True,
                                'data'=>$data_company
                            ]);

                        }else{
                            return Json::generateFailedMessage('Empresa no registrada');
                        }
                    break;

                    //Obtener y retornar el listado de empresas asociadas a un cliente
                    case 'all':
                        $data_companies=$model->getListCompanies($id_user['id']);

                        //Validacion Existencia registro de la empresa
                        if($data_companies<>NULL){

                            return Json::createJsonData([
                                'status'=>True,
                                'data'=>$data_companies
                            ]);

                        }else{
                            return Json::generateFailedMessage('El usuario no cuenta con ninguna empresa registrada');
                        }
                    break;

                    default:
                        return Json::generateFailedMessage('Tipo de consulta no registrada');
                    break;
                }

            }else{
                return Json::generateFailedMessage('Acceso no autorizado');
            }
        }

        /**
         * Emplear los metodos del modelo y actualizar la informacion de la empresa
         *
         * @param array $data Arreglo asociativo con los nuevos datos de la empresa, asi como el token de autenticacion
         * 
         * @return string Json del detallado de la operacion realizada
        */
        public static function update($data){

            //Instanciamiento modelo
            $model=new companiesModel('users');

            //Obtencion (Si es posible) del id del usuario asociado al token
            $id_user=$model->validateToken($data['token']);

            //Redefinicion tabla a usar
            $model->table="companies";
            
            if(isset($id_user['id'])){
                
                $data_company=$model->getDataCompany($id_user['id'],$data['id']);

                //Validacion Existencia registro de la empresa
                if($data_company<>NULL){

                    //Validacion de asociacion usuario -> Empresa
                    if($data_company['id_user']==$id_user['id']){

                        $unique=['name','nit'];
                        $data=[
                            'name'=>$data['name'],
                            'nit'=>$data['nit']
                        ];

                        $query=$model->update($unique,$data_company['id'],$data);

                        return Json::createJsonMessage($query['status'],$query['message']);

                    }else{
                        return Json::generateFailedMessage('Empresa no asociada al cliente');
                    }

                }else{
                    return Json::generateFailedMessage('Empresa no registrada');
                }

            }else{
                return Json::generateFailedMessage('Acceso no autorizado');
            } 

        }

        /**
         * Emplear los metodos del modelo y elimiar la informacion de la empresa
         * 
         * @param array $data Arreglo asociativo con los nuevos datos de la empresa, asi como el token de autenticacion
         * 
         * @return string Json del detallado de la operacion realizada
         * 
        */
        public static function delete($data){
            //Instanciamiento modelo
            $model=new companiesModel('users');

            //Obtencion (Si es posible) del id del usuario asociado al token
            $id_user=$model->validateToken($data['token']);

            //Redefinicion tabla a usar
            $model->table="companies";
            
            if(isset($id_user['id'])){
                
                $data_company=$model->getDataCompany($id_user['id'],$data['id']);

                //Validacion Existencia registro de la empresa
                if($data_company<>NULL){

                    //Validacion de asociacion usuario -> Empresa
                    if($data_company['id_user']==$id_user['id']){

                        $query=$model->delete($data_company['id']);

                        return Json::createJsonMessage($query['status'],$query['message']);

                    }else{
                        return Json::generateFailedMessage('Empresa no asociada al cliente');
                    }

                }else{
                    return Json::generateFailedMessage('Empresa no registrada');
                }

            }else{
                return Json::generateFailedMessage('Acceso no autorizado');
            }
            
        }
    }

?>