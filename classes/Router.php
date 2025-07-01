<?php
// ===== classes/Router.php =====
class Router {
    private $routes = [];
    private $afiliado = null;
    private $segments = [];
    
    public function __construct() {
        $this->parseUrl();
    }
    
    private function parseUrl() {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url, PHP_URL_PATH);
        $segments = array_filter(explode('/', trim($path, '/')));
        
        // Remover index.php se presente
        if (!empty($segments) && $segments[0] === 'index.php') {
            array_shift($segments);
        }
        
        // Se há um segmento e não é uma rota conhecida, pode ser afiliado
        if (!empty($segments) && !in_array($segments[0], ['produto', 'carrinho', 'pedido', 'categoria', 'buscar', 'api'])) {
            $this->afiliado = array_shift($segments);
        }
        
        $this->segments = array_values($segments);
    }
    
    public function getAfiliado() {
        return $this->afiliado;
    }
    
    public function getSegments() {
        return $this->segments;
    }
    
    public function route() {
        $segments = $this->getSegments();
        
        if (empty($segments)) {
            return ['controller' => 'HomeController', 'action' => 'index'];
        }
        
        switch ($segments[0]) {
            case 'produto':
                return [
                    'controller' => 'ProductController', 
                    'action' => 'view', 
                    'id' => $segments[1] ?? null
                ];
                
            case 'categoria':
                return [
                    'controller' => 'HomeController', 
                    'action' => 'categoria', 
                    'id' => $segments[1] ?? null
                ];
                
            case 'buscar':
                return [
                    'controller' => 'HomeController', 
                    'action' => 'buscar',
                    'termo' => $_GET['q'] ?? ''
                ];
                
            case 'carrinho':
                return [
                    'controller' => 'CartController', 
                    'action' => $segments[1] ?? 'index'
                ];
                
            case 'pedido':
                return [
                    'controller' => 'OrderController', 
                    'action' => $segments[1] ?? 'index'
                ];
                
            case 'api':
                return [
                    'controller' => 'ApiController', 
                    'action' => $segments[1] ?? 'index'
                ];
                
            default:
                return ['controller' => 'HomeController', 'action' => 'index'];
        }
    }
}
?>