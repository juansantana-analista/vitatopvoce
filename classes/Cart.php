<?php
// ===== classes/Cart.php =====
class Cart {
    private $sessionKey = 'vitatop_cart';
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }
    
    public function addItem($productId, $quantity = 1) {
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            $_SESSION[$this->sessionKey][$productId] += $quantity;
        } else {
            $_SESSION[$this->sessionKey][$productId] = $quantity;
        }
        
        return $this->getTotalItems();
    }
    
    public function removeItem($productId) {
        unset($_SESSION[$this->sessionKey][$productId]);
        return $this->getTotalItems();
    }
    
    public function updateQuantity($productId, $quantity) {
        if ($quantity <= 0) {
            $this->removeItem($productId);
        } else {
            $_SESSION[$this->sessionKey][$productId] = (int)$quantity;
        }
        
        return $this->getTotalItems();
    }
    
    public function getItems() {
        return $_SESSION[$this->sessionKey] ?? [];
    }
    
    public function getTotalItems() {
        return array_sum($_SESSION[$this->sessionKey] ?? []);
    }
    
    public function getTotalValue() {
        $cartItems = $this->getCartWithProducts();
        return array_sum(array_column($cartItems, 'subtotal'));
    }
    
    public function clear() {
        $_SESSION[$this->sessionKey] = [];
    }
    
    public function getCartWithProducts() {
        $cart = $this->getItems();
        if (empty($cart)) return [];
        
        try {
            $apiClient = new ApiClient();
            $response = $apiClient->listarProdutos();
            $produtos = $response['data']['data'] ?? [];
            
            $cartItems = [];
            foreach ($cart as $productId => $quantity) {
                foreach ($produtos as $produto) {
                    if ($produto['id'] == $productId) {
                        $cartItems[] = [
                            'produto' => $produto,
                            'quantidade' => $quantity,
                            'preco_unitario' => floatval($produto['preco_lojavirtual']),
                            'subtotal' => floatval($produto['preco_lojavirtual']) * $quantity
                        ];
                        break;
                    }
                }
            }
            
            return $cartItems;
        } catch (Exception $e) {
            return [];
        }
    }
    
    public function hasItems() {
        return $this->getTotalItems() > 0;
    }
}
?>