<?php
    require_once 'libs/router.php';
    require_once 'api/controladores/api.alimentos.controlador.php';
    require_once 'api/controladores/api.usuario.controlador.php';
    require_once 'api/middlewares/jwt.auth.middleware.php';

    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    // #                endpoint            verbo         controlador                    método
    $router->addRoute('alimentos',          'GET',       'apiAlimentosControlador',      'obtenerTodos');
    $router->addRoute('alimentos/:id',      'GET',       'apiAlimentosControlador',      'obtenerAlimento');
    $router->addRoute('alimentos/:id',      'DELETE',    'apiAlimentosControlador',      'borrarAlimento');
    $router->addRoute('alimentos',          'POST',      'apiAlimentosControlador',      'agregarAlimento');
    $router->addRoute('alimentos/:id',      'PUT',       'apiAlimentosControlador',      'actualizarAlimento');

    $router->addRoute('user/token',          'GET',       'apiUserControlador',      'obtenerToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);