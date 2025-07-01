<?php
// ===== index.php (ARQUIVO PRINCIPAL) =====
// Configuração de erro e sessão
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Auto-load das classes
require_once 'config/config.php';
require_once 'classes/ApiClient.php';
require_once 'classes/Router.php';
require_once 'classes/Cart.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/OrderController.php';

try {
    // Inicializar roteador
    $router = new Router();
    $route = $router->route();
    $afiliado = $router->getAfiliado();
    
    // Processar rota
    $controllerName = $route['controller'];
    $action = $route['action'];
    
    switch ($controllerName) {
        case 'HomeController':
            $controller = new HomeController($afiliado);
            if ($action === 'categoria') {
                $controller->categoria($route['id'] ?? null);
            } elseif ($action === 'buscar') {
                $controller->buscar($route['termo'] ?? '');
            } else {
                $controller->index();
            }
            break;
            
        case 'ProductController':
            $controller = new ProductController();
            $controller->view($route['id'] ?? null);
            break;
            
        case 'CartController':
            $controller = new CartController();
            switch ($action) {
                case 'add':
                    $controller->add();
                    break;
                case 'remove':
                    $controller->remove();
                    break;
                case 'update':
                    $controller->update();
                    break;
                case 'count':
                    $controller->count();
                    break;
                default:
                    $controller->index();
            }
            break;
            
        case 'OrderController':
            $controller = new OrderController();
            $controller->checkout();
            break;
            
        default:
            $controller = new HomeController($afiliado);
            $controller->index();
    }
    
} catch (Exception $e) {
    // Página de erro global
    $error = $e->getMessage();
    include 'views/layouts/header.php';
    include 'views/error.php';
    include 'views/layouts/footer.php';
}
?>