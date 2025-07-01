<?php
// ===== controllers/OrderController.php =====
class OrderController {
    private $apiClient;
    private $cart;
    
    public function __construct() {
        $this->apiClient = new ApiClient();
        $this->cart = new Cart();
    }
    
    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processOrder();
        } else {
            $this->showCheckout();
        }
    }
    
    private function showCheckout() {
        $cartItems = $this->cart->getCartWithProducts();
        
        if (empty($cartItems)) {
            header('Location: /carrinho');
            exit;
        }
        
        $total = $this->cart->getTotalValue();
        
        $pageData = [
            'cartItems' => $cartItems,
            'total' => $total,
            'pageTitle' => 'Finalizar Compra'
        ];
        
        $this->renderView('checkout', $pageData);
    }
    
    private function processOrder() {
        try {
            $cartItems = $this->cart->getCartWithProducts();
            
            if (empty($cartItems)) {
                throw new Exception('Carrinho vazio');
            }
            
            // Validar dados obrigatórios
            $requiredFields = ['nome', 'email', 'telefone', 'cep', 'rua', 'numero', 'cidade', 'estado'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Campo {$field} é obrigatório");
                }
            }
            
            // Preparar dados do pedido
            $dadosPedido = [
                'afiliado' => $_SESSION['afiliado'] ?? null,
                'cliente' => [
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'telefone' => $_POST['telefone']
                ],
                'endereco' => [
                    'cep' => $_POST['cep'],
                    'rua' => $_POST['rua'],
                    'numero' => $_POST['numero'],
                    'complemento' => $_POST['complemento'] ?? '',
                    'bairro' => $_POST['bairro'] ?? '',
                    'cidade' => $_POST['cidade'],
                    'estado' => $_POST['estado']
                ],
                'itens' => [],
                'valor_total' => 0
            ];
            
            $total = 0;
            foreach ($cartItems as $item) {
                $dadosPedido['itens'][] = [
                    'produto_id' => $item['produto']['id'],
                    'nome' => $item['produto']['titulo'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                    'subtotal' => $item['subtotal']
                ];
                $total += $item['subtotal'];
            }
            
            $dadosPedido['valor_total'] = $total;
            
            // Enviar pedido para API
            $response = $this->apiClient->criarPedido($dadosPedido);
            
            if ($response['status'] === 'success') {
                $pedidoId = $response['data']['pedido_id'] ?? 'N/A';
                $this->cart->clear();
                
                $pageData = [
                    'pedidoId' => $pedidoId,
                    'dadosPedido' => $dadosPedido,
                    'pageTitle' => 'Pedido Confirmado'
                ];
                
                $this->renderView('order_success', $pageData);
            } else {
                throw new Exception($response['message'] ?? 'Erro ao processar pedido');
            }
            
        } catch (Exception $e) {
            $error = $e->getMessage();
            $cartItems = $this->cart->getCartWithProducts();
            $total = $this->cart->getTotalValue();
            
            $pageData = [
                'error' => $error,
                'cartItems' => $cartItems,
                'total' => $total,
                'pageTitle' => 'Finalizar Compra'
            ];
            
            $this->renderView('checkout', $pageData);
        }
    }
    
    private function renderView($view, $data = []) {
        extract($data);
        include 'views/layouts/header.php';
        include "views/{$view}.php";
        include 'views/layouts/footer.php';
    }
}
?>