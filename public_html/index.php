<?php

    /* Importacion de Herramientas */

        //Manejo y Validacion $_POST
        require "../tools/post.php";

        //Manejo JSON
        require "../tools/json.php";
    //

    /* Acceso a modulos principales e informacion privada */
    if(Post::validateExistence(['module','action','token'])){

        //Segun el modulo ingresado realizar n accion
        switch(Post::getIndividualData('module')){

            //Metodos autenticacion
            case 'auth':
                require '../controller/authController.php';

                //Acciones de autenticacion
                switch(Post::getIndividualData('action')){

                    //Validacion Inicio de sesion
                    case 'login':
                        $request=Json::createJsonData(
                            authController::login(Post::getIndividualData('token'))
                        );
                    break;

                    //Registro de nuevos usuarios
                    case 'register':

                        //Validacion existencia de datos
                        if(Post::validateExistence(['name','id_gender','date_birth','id_doc_typ','doc_num','email','password','id_role','token'])){

                            //Ejecucion metodo de registro 
                            $request=authController::register(
                                Post::getData(['name','id_gender','date_birth','id_doc_typ','doc_num','email','password','id_role','token'])
                            );
                        }else{
                            $request=Json::generateFailedMessage('Informacion Faltante');
                        }
                    break;

                    default:
                        $request=Json::createJsonMessage(FALSE,'Accion no registrada');
                    break;
                }

            break;

            //Metodos modulo companies/Empresas
            case 'companies':
                require '../controller/companiesController.php';

                switch(Post::getIndividualData('action')){

                    //Crear o Registras
                    case 'create':

                        if(Post::validateExistence(['name','nit'])){
                            $request=companiesController::create(Post::getIndividualData("token"),Post::getData(['name','nit']));
                        }else{
                            $request=Json::generateFailedMessage('Informacion Faltante');
                        }
  
                    break;

                    //Consultar la informacion de n registros
                    case 'read':

                        if(Post::validateExistence(['type'])){
                            $request=companiesController::read(Post::getData(['token','id','type']));
                        }else{
                            $request=Json::generateFailedMessage('Informacion Faltante');
                        }
                    break;

                    //Actualizar un registro
                    case 'update':

                        if(Post::validateExistence(['name','nit','id'])){
                            $request=companiesController::update(Post::getData(['token','name','nit','id']));
                        }else{
                            $request=Json::generateFailedMessage('Informacion Faltante');
                        }
                        
                    break;

                    //Eliminar un registro
                    case 'delete':
                        if(Post::validateExistence(['id'])){
                            $request=companiesController::delete(Post::getData(['token','id']));
                        }else{
                            $request=Json::generateFailedMessage('Informacion Faltante');
                        }
                    break;

                    default:
                        $request=Json::createJsonMessage(FALSE,'Accion no registrada');
                    break;
                }

            break;

            //Metodos modulo points_sale/Puntos_venta
            case 'points_sale':
                require 'controller/points_sale.php';
            break;

            //Metodos modulo products/Productos
            case 'products':
                require 'controller/products.php';
            break;

            //Definicion de respuesta por defecto en caso de ingresar un metodo no autorizado
            default:
                $request=Json::createJsonMessage(FALSE,'Modulo no registrado');
            break;
        }   

    /* Acceso a funcionalidades publicas */
    }elseif(Post::validateExistence(['module'])){

        switch(Post::getIndividualData('module')){

            //Solicitar datos publicos -> Menus desplegables
            case 'getData':

                require "../controller/getDataController.php";

                //Validacion existencia nombre tabla
                if(Post::validateExistence(['table_name'])){
                    $request=Json::createJsonData(
                        getDataController::consultDataPublic(Post::getIndividualData('table_name'))
                    );
                }else{
                    $request=Json::generateFailedMessage('Informacion Faltante');
                }

            break;

            //Definicion de respuesta por defecto en caso de que el modulo solicitado no se encuente registrado
            default:
                $request=Json::createJsonMessage(FALSE,'Modulo no registrado');
            break;
        }

    }else{
        $request=Json::generateFailedMessage('Informacion Faltante');
    }

    print($request);
?>