<?php

    require "conection.php";

    /*
        Nombre clase: getDataModel
        Extendida: Si -> conection

        Objetivo: Clase encargada de contender y proveer a las demas clases hijas de metodos que les permitan realizar consultas simples y condicionales 
    */
    class getDataModel extends conection{

        public $table='';

        /**
         * Ejecutar consultas SQL sin hacer uso de condicionales
         * 
         * @param string $columns Columnas a consultar
         * @return array Arreglo indexado de los resultados de la consulta
        */
        public function simpleQueryData(string $columns="*"){
            return $this->db_conection->query("SELECT $columns from $this->table")->fetch_all();
        }

        /**
         * Ejecutar consulta SQL empleando condicionales personalizados
         * 
         * @param string $columns Columnas a consultar
         * @param string $condition Condicion a cumplir
         * @param string $fetch Formato de guardado de los datos (Opcional)
         * @param string $add Seccion personalizada de consulta (JOIN) (Opcional)
         * 
         * @return array Arreglo indexado de los resultados de la consulta
        */
        public function conditionQueryData(string $columns='*',string $condition,string $fetch='assoc',string $add=''){

            $query=$this->db_conection->query("SELECT $columns from $this->table $add WHERE $condition");

            //Seleccion formato de retorno
            switch($fetch){
                case 'assoc':
                    return $query->fetch_assoc();
                break;

                case 'array':
                    return $query->fetch_array();
                break;

                case 'all':
                    return $query->fetch_all();
                break;

                default:
                    return 'Metodo de asociacion no registrado';
                break;
            }
        }

        /**
         * Validar y retornar cuantos registros hay de una determinada columna con un determinado valor
         * 
         * @param string $column Nombre de la columna a consultar
         * @param string $value Valor a revisar
         * 
         * @return array Arreglo asocoativo de la cantidad de registros con esa informacion 
        */
        public function validateUnique($column,$value){
            $query=("SELECT COUNT('id') as 'count' FROM $this->table WHERE $column='$value'");

            return $this->db_conection->query($query)->fetch_array();
        }
    }

?>