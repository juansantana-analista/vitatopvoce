<?php
// ===== controllers/CartController.php =====
class CartController {
    private $cart;
    
    public function __construct() {
        $this->cart = new Cart();
    }
    
    public function index() {
        $cartItems = $this->cart->getCartWithProducts();
        $total = $this->cart->getTotalValue();
        
        $pageData = [
            'cartItems' => $cartItems,
            'total' => $total,
            'pageTitle' => 'Carrinho'
        ];
        
        $this->renderView('cart', $pageData);
    }
    
    public function add() {
        header('Content-Type: application/json');
        
        try {
            $productId = $_POST['product_id'] ?? null;
            $quantity = intval($_POST['quantity'] ?? 1);
            
            if (!$productId || $quantity <= 0) {
                throw new Exception('Dados inválidos');
            }
            
            $totalItems = $this->cart->addItem($productId, $quantity);
            
            echo json_encode([
                'success' => true,
                'message' => 'Produto adicionado ao carrinho',
                'totalItems' => $totalItems
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    public function remove() {
        header('Content-Type: application/json');
        
        try {
            $productId = $_POST['product_id'] ?? null;
            
            if (!$productId) {
                throw new Exception('ID do produto não informado');
            }
            
            $totalItems = $this->cart->removeItem($productId);
            
            echo json_encode([
                'success' => true,
                'message' => 'Produto removido do carrinho',
                'totalItems' => $totalItems
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    public function update() {
        header('Content-Type: application/json');
        
        try {
            $productId = $_POST['product_id'] ?? null;
            $quantity = intval($_POST['quantity'] ?? 0);
            
            if (!$productId) {
                throw new Exception('ID do produto não informado');
            }
            
            $totalItems = $this->cart->updateQuantity($productId, $quantity);
            
            echo json_encode([
                'success' => true,
                'message' => 'Carrinho atualizado',
                'totalItems' => $totalItems
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    
    public function count() {
        header('Content-Type: application/json');
        echo json_encode([
            'totalItems' => $this->cart->getTotalItems(),
            'totalValue' => $this->cart->getTotalValue()
        ]);
        exit;
    }
    
    private function renderView($view, $data = []) {
        extract($data);
        include 'views/layouts/header.php';
        include "views/{$view}.php";
        include 'views/layouts/footer.php';
    }
}
?>