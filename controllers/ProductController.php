<?php
// ===== controllers/ProductController.php =====
class ProductController {
    private $apiClient;
    
    public function __construct() {
        $this->apiClient = new ApiClient();
    }
    
    public function view($productId) {
        try {
            if (!$productId) {
                throw new Exception('ID do produto não informado');
            }
            
            // Buscar produto específico
            $response = $this->apiClient->listarProdutos();
            $produtos = $response['data']['data'] ?? [];
            
            $produto = null;
            foreach ($produtos as $p) {
                if ($p['id'] == $productId) {
                    $produto = $p;
                    break;
                }
            }
            
            if (!$produto) {
                throw new Exception('Produto não encontrado');
            }
            
            // Produtos relacionados (mesma categoria)
            $relacionados = array_filter($produtos, function($p) use ($produto) {
                return $p['categoria_id'] == $produto['categoria_id'] && $p['id'] != $produto['id'];
            });
            $relacionados = array_slice($relacionados, 0, 4);
            
            $pageData = [
                'produto' => $produto,
                'relacionados' => $relacionados,
                'pageTitle' => $produto['titulo']
            ];
            
            $this->renderView('product', $pageData);
            
        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }
    
    private function renderView($view, $data = []) {
        extract($data);
        include 'views/layouts/header.php';
        include "views/{$view}.php";
        include 'views/layouts/footer.php';
    }
    
    private function renderError($message) {
        $error = $message;
        include 'views/layouts/header.php';
        include 'views/error.php';
        include 'views/layouts/footer.php';
    }
}
?>