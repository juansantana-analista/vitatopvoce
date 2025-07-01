<?php
// ===== controllers/HomeController.php =====
class HomeController {
    private $apiClient;
    private $afiliado;
    
    public function __construct($afiliado = null) {
        $this->apiClient = new ApiClient();
        $this->afiliado = $afiliado;
        $this->initSession();
    }
    
    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($this->afiliado) {
            $_SESSION['afiliado'] = $this->afiliado;
        }
    }
    
    public function index() {
        try {
            // Buscar produtos em paralelo
            $produtosResponse = $this->apiClient->listarProdutos();
            $produtos = $produtosResponse['data']['data'] ?? [];
            
            // Separar produtos por categoria para seções especiais
            $maisVendidos = array_slice($produtos, 0, 8);
            $promocoes = array_filter($produtos, function($produto) {
                return floatval($produto['preco2']) > floatval($produto['preco_lojavirtual']);
            });
            $promocoes = array_slice($promocoes, 0, 6);
            
            // Categorias para menu
            $categorias = $this->getCategorias($produtos);
            
            $pageData = [
                'produtos' => $produtos,
                'maisVendidos' => $maisVendidos,
                'promocoes' => $promocoes,
                'categorias' => $categorias,
                'afiliado' => $this->afiliado,
                'pageTitle' => 'Início'
            ];
            
            $this->renderView('home', $pageData);
            
        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }
    
    public function categoria($categoriaId) {
        try {
            $response = $this->apiClient->listarProdutos($categoriaId);
            $produtos = $response['data']['data'] ?? [];
            
            $pageData = [
                'produtos' => $produtos,
                'categoriaId' => $categoriaId,
                'afiliado' => $this->afiliado,
                'pageTitle' => 'Categoria'
            ];
            
            $this->renderView('categoria', $pageData);
            
        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }
    
    public function buscar($termo) {
        try {
            if (empty($termo)) {
                header('Location: /');
                exit;
            }
            
            $response = $this->apiClient->buscarProdutos($termo);
            $produtos = $response['data']['data'] ?? [];
            
            $pageData = [
                'produtos' => $produtos,
                'termo' => $termo,
                'afiliado' => $this->afiliado,
                'pageTitle' => 'Busca: ' . $termo
            ];
            
            $this->renderView('busca', $pageData);
            
        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }
    
    private function getCategorias($produtos) {
        $categorias = [];
        foreach ($produtos as $produto) {
            $catId = $produto['categoria_id'];
            if (!isset($categorias[$catId])) {
                $categorias[$catId] = [
                    'id' => $catId,
                    'nome' => 'Categoria ' . $catId,
                    'count' => 0
                ];
            }
            $categorias[$catId]['count']++;
        }
        return array_values($categorias);
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