<?php

    require "authModel.php";

    /**
     * Class Name: companiesModel
     * 
     * Extended: Si
     * Class Base: authModel -> getDataModel -> Conection
     * 
     * Description (Spanish): Clase encargada de realizar todas las operaciones en BD relacionadas con el modulo companies
    */
    class companiesModel extends authModel{

        /**
         * Registrar una nueva empresa
         * 
         * @param $unique Listado de campos a validar
         * @param $data Arreglo asociativo de los datos a guardar
         * 
         * @return array Arreglo con detallado del proceso realizado
        */
        public function create(array $unique,array $data){

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
                $id_user=$data['id_user'];
                $name=$data['name'];
                $nit=$data['nit'];
            //

            /* === Ejecucion de la consulta === */
                return [
                    'status'=>$this->db_conection->query("INSERT INTO $this->table values(null,$id_user,'$name','$nit');"),
                    'message'=>'Empresa registrada exitosamente'
                ];
            //
        }

        /**
         * Actualizar la informacion de una empresa
         *  
         * @param array $unique Listado de campos a validar
         * @param int $id Identificador de la empresa
         * @param array $data Arreglo asociativo de los datos a guardar
         * 
         * @return array Arreglo con detallado del proceso realizado
        */
        public function update(array $unique,int $id,array $data){

            /* === Validacion de registos unicos === */
                foreach($data as $key=>$value){
                    if(in_array($key,$unique)){
                        if($this->validateUnique($key,$value)['count']>1){
                            return [
                                'status'=>False,
                                'message'=>"El campo $key ya se encuentra registrado"
                            ];
                        }
                    }
                }
            //

            /* === Guardado de Datos === */
                $name=$data['name'];
                $nit=$data['nit'];
            //

            /* === Ejecucion de la consulta === */
                return [
                    'status'=>$this->db_conection->query("UPDATE $this->table SET name='$name',nit='$nit' WHERE id='$id'"),
                    'message'=>'Informacion Actualizada exitosamente'
                ];
            //

        }

        /**
         * Eliminar la informacion de una empresa
         * 
         * @param int $id Identificador de la empresa
         * 
         * @return array Arreglo con detallado del proceso realizado
        */
        public function delete(int $id){
            return [
                'status'=>$this->db_conection->query("DELETE FROM $this->table WHERE id='$id'"),
                'message'=>'Registro eliminado exitosamente'
            ];
        }

        /**
         * Obtener la informacion detallada de una empresa asocida a un cliente
         * 
         * @param int $token Identificador del cliente
         * @param int $id Identificador de la empresa
         * 
         * @return bool Estado de la validacion
        */
        public function getDataCompany(int $id_user,int $id){
            return $this->conditionQueryData('*',"id=$id and id_user=$id_user");
        }

        /**
         * Obtener el listado de empresas asociado a un cliente
         * 
         * @param int $token Identificador del cliente
         * @param int $id Identificador de la empresa
         * 
         * @return bool Estado de la validacion
        */
        public function getListCompanies(int $id_user){
            return $this->conditionQueryData('*',"id_user=$id_user",'all');
        }

    }

?>