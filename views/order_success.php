<!-- ===== views/order_success.php ===== -->
<div class="success-page">
    <div class="container">
        <div class="success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="success-title">Pedido realizado com sucesso!</h1>
            
            <div class="success-info">
                <p class="success-message">
                    Obrigado por sua compra! Seu pedido foi processado e você receberá 
                    um e-mail de confirmação em breve.
                </p>
                
                <div class="order-details">
                    <div class="detail-item">
                        <strong>Número do pedido:</strong>
                        <span><?= htmlspecialchars($pedidoId) ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Total:</strong>
                        <span>R$ <?= number_format($dadosPedido['valor_total'], 2, ',', '.') ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>E-mail:</strong>
                        <span><?= htmlspecialchars($dadosPedido['cliente']['email']) ?></span>
                    </div>
                </div>
                
                <?php if (isset($dadosPedido['afiliado']) && $dadosPedido['afiliado']): ?>
                    <div class="affiliate-success">
                        <i class="fas fa-handshake"></i>
                        <p>Venda realizada através do parceiro: <strong><?= ucfirst($dadosPedido['afiliado']) ?></strong></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="success-actions">
                <a href="<?= isset($dadosPedido['afiliado']) ? '/' . $dadosPedido['afiliado'] : '/' ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i>
                    Voltar à loja
                </a>
                <button onclick="window.print()" class="btn btn-outline-primary">
                    <i class="fas fa-print"></i>
                    Imprimir pedido
                </button>
            </div>
        </div>
    </div>
</div>