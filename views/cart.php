<!-- ===== views/cart.php ===== -->
<div class="cart-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-shopping-bag"></i>
                Minha sacola
            </h1>
        </div>
        
        <?php if (!empty($cartItems)): ?>
            <div class="cart-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <?php foreach ($cartItems as $index => $item): ?>
                                <div class="cart-item" data-product-id="<?= $item['produto']['id'] ?>">
                                    <div class="item-image">
                                        <img src="<?= htmlspecialchars($item['produto']['foto']) ?>" 
                                             alt="<?= htmlspecialchars($item['produto']['titulo']) ?>" 
                                             class="img-fluid"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Qcm9kdXRvPC90ZXh0Pjwvc3ZnPg=='">
                                    </div>
                                    
                                    <div class="item-details">
                                        <h3 class="item-title">
                                            <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] . '/produto/' . $item['produto']['id'] : '/produto/' . $item['produto']['id'] ?>">
                                                <?= htmlspecialchars($item['produto']['titulo']) ?>
                                            </a>
                                        </h3>
                                        <p class="item-code">Código: <?= $item['produto']['id'] ?></p>
                                        
                                        <div class="item-actions">
                                            <button class="btn-remove" onclick="removeFromCart(<?= $item['produto']['id'] ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                                Remover
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="item-quantity">
                                        <label>Quantidade:</label>
                                        <div class="quantity-controls">
                                            <button type="button" class="qty-btn qty-minus" 
                                                    onclick="updateQuantity(<?= $item['produto']['id'] ?>, <?= $item['quantidade'] - 1 ?>)">-</button>
                                            <input type="number" 
                                                   value="<?= $item['quantidade'] ?>" 
                                                   min="1" 
                                                   max="10" 
                                                   class="qty-input"
                                                   onchange="updateQuantity(<?= $item['produto']['id'] ?>, this.value)">
                                            <button type="button" class="qty-btn qty-plus"
                                                    onclick="updateQuantity(<?= $item['produto']['id'] ?>, <?= $item['quantidade'] + 1 ?>)">+</button>
                                        </div>
                                    </div>
                                    
                                    <div class="item-pricing">
                                        <div class="unit-price">
                                            R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>
                                        </div>
                                        <div class="subtotal">
                                            R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="cart-actions">
                            <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] : '/' ?>" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i>
                                Continuar comprando
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3 class="summary-title">Resumo do pedido</h3>
                            
                            <div class="summary-items">
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="summary-item">
                                        <span class="item-qty"><?= $item['quantidade'] ?>x</span>
                                        <span class="item-name"><?= htmlspecialchars($item['produto']['titulo']) ?></span>
                                        <span class="item-total">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="summary-total">
                                <div class="total-line">
                                    <span class="total-label">Subtotal:</span>
                                    <span class="total-value">R$ <?= number_format($total, 2, ',', '.') ?></span>
                                </div>
                                <div class="total-line">
                                    <span class="total-label">Frete:</span>
                                    <span class="total-value">
                                        <?= $total >= 99 ? 'Grátis' : 'A calcular' ?>
                                    </span>
                                </div>
                                <div class="total-line final-total">
                                    <span class="total-label">Total:</span>
                                    <span class="total-value">R$ <?= number_format($total, 2, ',', '.') ?></span>
                                </div>
                            </div>
                            
                            <div class="checkout-actions">
                                <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] . '/pedido/checkout' : '/pedido/checkout' ?>" class="btn btn-checkout btn-lg">
                                    <i class="fas fa-credit-card"></i>
                                    Finalizar compra
                                </a>
                            </div>
                            
                            <?php if ($total < 99): ?>
                                <div class="free-shipping-alert">
                                    <i class="fas fa-truck"></i>
                                    <span>Falta R$ <?= number_format(99 - $total, 2, ',', '.') ?> para ganhar frete grátis!</span>
                                </div>
                            <?php else: ?>
                                <div class="free-shipping-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Parabéns! Você ganhou frete grátis!</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-cart-content">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h2 class="empty-cart-title">Sua sacola está vazia</h2>
                    <p class="empty-cart-text">Que tal conhecer nossos produtos?</p>
                    <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] : '/' ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left"></i>
                        Ver produtos
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>