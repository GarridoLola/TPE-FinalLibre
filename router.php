<?php
require_once 'libs/respuesta.php';

require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';

require_once 'app/controladores/auth.controlador.php';
require_once 'app/controladores/alimentos.controlador.php';
require_once 'app/controladores/grupos.controlador.php';
require_once 'app/controladores/home.controlador.php';

define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new respuesta();

$action = 'home'; //por defecto si no se elvia ninguna.
if (!empty($_GET['action'])){
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]){

    //home
    case 'home': 
        sessionAuthMiddleware($res);
        $controlador = new homeControlador($res);
        $controlador->mostrarHome();
    break;
    
    //administrar
    case 'administrar': 
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controladorA = new alimentosControlador($res);
        $controladorG = new gruposControlador($res);
        $controladorA->administrarAlimentos();
        $controladorG->administrarGrupos();
    break;

    //grupos
    case 'listar_grupos':
        sessionAuthMiddleware($res);
        $controlador = new gruposControlador();
        $controlador->mostrarGrupos();
    break;
    case 'mostrar_items':
        sessionAuthMiddleware($res);
        $controlador = new gruposControlador();
        $controlador->mostrarItemsPorGrupo($params[1]);
    break;

    //alimentos 

    case 'listar_alimentos':
        $controlador = new alimentosControlador();
        $controlador->mostrarAlimentos();
    break;

    case 'alimentos':
        $controlador =  new alimentosControlador();
        $controlador->alimentosDetalle($params[1]);
    break;

    //autenticación.

    case 'mostrarLogin':
        $controlador = new authControlador();
        $controlador->mostrarLogin();
    break;
    case 'login':
        $controlador = new authControlador();
        $controlador->login();
    break;
    case 'logOut':
        $controlador = new authControlador();
        $controlador->logOut();
    break;

    //administrador.

    //alimentos admin
    case 'admin_alimentos':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new  alimentosControlador($res);
        $controlador->mostrarAlimentos();
    break;
    case 'agregar_alimento': 
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new alimentosControlador($res);
        $controlador->agregarAlimento();
    break;
    case 'eliminar_alimento':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new alimentosControlador($res);
        $controlador->eliminarAlimento($params[1]);
    break;
    case 'form_editar_alimento':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new alimentosControlador($res);
        $controlador->formEditarAlimento($params[1]); //vista con los datos
    break;
    case 'actualizar_alimento':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new alimentosControlador($res);
        $controlador->actualizarAlimento();
    break;

    //grupos admin
    case 'admin_grupos':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new gruposControlador($res);
        $controlador->mostrarGrupos();
    break;
    case 'agregar_grupo':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new gruposControlador($res);
        $controlador->agregarGrupo();
    break;
    case 'eliminar_grupo': 
       sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new gruposControlador($res);
        $controlador->eliminarGrupo($params[1]);
    break;
    case 'form_editar_grupo':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new gruposControlador($res);
        $controlador->formEditarGrupo($params[1]); //vista con los datos
    break;
    case 'actualizar_grupo':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new gruposControlador($res);
        $controlador->actualizarGrupo();
    break;

    default:
        $controlador = new alimentosControlador();
        $controlador->default();
    break;
}