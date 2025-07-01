<?php
// ===== classes/ApiClient.php =====
class ApiClient {
    private $apiUrl;
    private $token;
    
    public function __construct() {
        $this->apiUrl = Config::API_URL;
        $this->token = Config::API_TOKEN;
    }
    
    public function makeRequest($class, $method, $params = []) {
        $data = [
            'class' => $class,
            'method' => $method
        ];
        
        if (!empty($params)) {
            $data = array_merge($data, $params);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . $this->token
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            curl_close($ch);
            throw new Exception('Erro de conexão: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('Erro na API: HTTP ' . $httpCode);
        }
        
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erro ao decodificar resposta da API');
        }
        
        return $decoded;
    }
    
    public function listarProdutos($categoria_id = null) {
        $params = [];
        if ($categoria_id) {
            $params['categoria_id'] = $categoria_id;
        }
        return $this->makeRequest('ProdutoVariacaoRest', 'listarProdutos', $params);
    }
    
    public function buscarProdutos($termo) {
        return $this->makeRequest('ProdutoVariacaoRest', 'buscarProdutos', ['termo' => $termo]);
    }
    
    public function obterProduto($id) {
        return $this->makeRequest('ProdutoVariacaoRest', 'obterProduto', ['id' => $id]);
    }
    
    public function criarPedido($dadosPedido) {
        return $this->makeRequest('PedidoRest', 'criarPedido', $dadosPedido);
    }
    
    public function calcularComissao($afiliadoId, $valorPedido) {
        return $this->makeRequest('AfiliadoRest', 'calcularComissao', [
            'afiliado_id' => $afiliadoId,
            'valor_pedido' => $valorPedido
        ]);
    }
    
    public function listarCategorias() {
        return $this->makeRequest('CategoriaRest', 'listarCategorias');
    }
    
    public function obterProdutosMaisVendidos($limit = 8) {
        return $this->makeRequest('ProdutoVariacaoRest', 'listarMaisVendidos', ['limit' => $limit]);
    }
    
    public function obterPromocoes($limit = 6) {
        return $this->makeRequest('ProdutoVariacaoRest', 'listarPromocoes', ['limit' => $limit]);
    }
}
?>