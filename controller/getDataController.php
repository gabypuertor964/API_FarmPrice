<?php

    require "../model/getDataModel.php";

    /*
        Nombre clase: authController
        Extendida: No

        Objetivo: Gestionar todas las consultas
    */
    class getDataController{

        //Declaracion atributos protegidos

        public static function consultDataPublic(string $table_name){

            //Listado de tablas autorizadas para su consulta sin token
            $public_tables=['days','doc_types','genders','roles'];

            $validate=in_array($table_name,$public_tables);

            if($validate){
                $model=new getDataModel();
                $model->table=$table_name;

                return [
                    'status'=>True,
                    'data'=>$model->simpleQueryData()
                ];
            }else{
                return [
                    'status'=>False,
                    'message'=>'Permisos insuficientes'
                ];
            }

        }

    }
?>