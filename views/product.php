<!-- ===== views/product.php ===== -->
<div class="product-page">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="product-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] : '/' ?>">Início</a></li>
                <li class="breadcrumb-item"><a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] . '/categoria/' . $produto['categoria_id'] : '/categoria/' . $produto['categoria_id'] ?>">Categoria</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($produto['titulo']) ?></li>
            </ol>
        </nav>
        
        <!-- Produto Principal -->
        <div class="product-main">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <div class="main-image">
                            <img src="<?= htmlspecialchars($produto['foto']) ?>" 
                                 alt="<?= htmlspecialchars($produto['nome']) ?>" 
                                 class="img-fluid product-main-image"
                                 id="mainProductImage"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMjQiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Produto Vitatop</text></svg>'">
                        </div>
                        
                        <!-- Miniaturas -->
                        <div class="thumbnail-gallery">
                            <div class="thumbnail-item active">
                                <img src="<?= htmlspecialchars($produto['foto']) ?>" 
                                     alt="<?= htmlspecialchars($produto['nome']) ?>" 
                                     class="img-fluid"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxMCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPjE8L3RleHQ+PC9zdmc+'">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="product-details">
                        <h1 class="product-name"><?= htmlspecialchars($produto['titulo']) ?></h1>
                        
                        <div class="product-code">
                            <span>Código: <?= htmlspecialchars($produto['id']) ?></span>
                        </div>
                        
                        <div class="product-pricing">
                            <?php if (floatval($produto['preco2']) > floatval($produto['preco_lojavirtual'])): ?>
                                <div class="price-comparison">
                                    <span class="old-price-large">
                                        De R$ <?= number_format(floatval($produto['preco2']), 2, ',', '.') ?>
                                    </span>
                                    <?php $desconto = round((1 - floatval($produto['preco_lojavirtual']) / floatval($produto['preco2'])) * 100); ?>
                                    <span class="discount-percentage">-<?= $desconto ?>%</span>
                                </div>
                            <?php endif; ?>
                            <div class="current-price-large">
                                R$ <?= number_format(floatval($produto['preco_lojavirtual']), 2, ',', '.') ?>
                            </div>
                        </div>
                        
                        <div class="product-actions">
                            <div class="quantity-selector">
                                <label for="quantity">Quantidade:</label>
                                <div class="quantity-controls">
                                    <button type="button" class="qty-btn qty-minus">-</button>
                                    <input type="number" id="quantity" value="1" min="1" max="10" class="qty-input">
                                    <button type="button" class="qty-btn qty-plus">+</button>
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                <button class="btn btn-add-to-cart btn-lg" 
                                        onclick="addToCartWithQuantity(<?= $produto['id'] ?>)">
                                    <i class="fas fa-shopping-bag"></i>
                                    Adicionar à sacola
                                </button>
                                
                                <button class="btn btn-favorite" data-product-id="<?= $produto['id'] ?>">
                                    <i class="far fa-heart"></i>
                                    Favoritar
                                </button>
                            </div>
                        </div>
                        
                        <div class="product-features">
                            <div class="feature-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Frete grátis acima de R$ 99</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-medal"></i>
                                <span>Produtos de alta qualidade</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Compra 100% segura</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produtos Relacionados -->
        <?php if (!empty($relacionados)): ?>
            <div class="related-products">
                <h3 class="section-title">Produtos relacionados</h3>
                <div class="row">
                    <?php foreach ($relacionados as $produtoRel): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="<?= htmlspecialchars($produtoRel['foto']) ?>" 
                                         alt="<?= htmlspecialchars($produtoRel['nome']) ?>" 
                                         class="product-image"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Qcm9kdXRvPC90ZXh0Pjwvc3ZnPg=='">
                                    <button class="favorite-btn" data-product-id="<?= $produtoRel['id'] ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <?php if (floatval($produtoRel['preco2']) > floatval($produtoRel['preco_lojavirtual'])): ?>
                                        <?php $desconto = round((1 - floatval($produtoRel['preco_lojavirtual']) / floatval($produtoRel['preco2'])) * 100); ?>
                                        <span class="discount-badge">-<?= $desconto ?>%</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-info">
                                    <h4 class="product-title">
                                        <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] . '/produto/' . $produtoRel['id'] : '/produto/' . $produtoRel['id'] ?>">
                                            <?= htmlspecialchars($produtoRel['titulo']) ?>
                                        </a>
                                    </h4>
                                    
                                    <div class="product-prices">
                                        <?php if (floatval($produtoRel['preco2']) > floatval($produtoRel['preco_lojavirtual'])): ?>
                                            <span class="old-price">
                                                De R$ <?= number_format(floatval($produtoRel['preco2']), 2, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="current-price">
                                            R$ <?= number_format(floatval($produtoRel['preco_lojavirtual']), 2, ',', '.') ?>
                                        </span>
                                    </div>
                                    
                                    <button class="btn btn-add-cart" 
                                            onclick="addToCart(<?= $produtoRel['id'] ?>)">
                                        <i class="fas fa-shopping-bag"></i>
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
