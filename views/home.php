<!-- ===== views/home.php ===== -->
<div class="homepage">
    <!-- Banner Principal -->
    <section class="hero-banner">
        <div class="container">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-text">
                            <h1 class="hero-title">
                                <span class="brand-name"><?= Config::SITE_NAME ?></span>
                            </h1>
                            <h2 class="hero-subtitle">
                                SUPLEMENTOS
                                <span class="highlight">100% NATURAIS</span>
                            </h2>
                            <p class="hero-description">
                                Com resultados visíveis e comprovados
                            </p>
                            <div class="hero-discount">
                                <span class="discount-badge">
                                    ATÉ <strong>30%</strong> DESCONTO
                                </span>
                            </div>
                            <div class="hero-actions">
                                <a href="#produtos-destaque" class="btn btn-primary btn-lg">
                                    CONHEÇA NOSSOS PRODUTOS
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            <!-- Placeholder para imagem dos produtos -->
                            <div style="text-align: center; padding: 2rem; background: rgba(255,255,255,0.1); border-radius: 12px;">
                                <i class="fas fa-pills" style="font-size: 5rem; color: rgba(255,255,255,0.7);"></i>
                                <p style="color: rgba(255,255,255,0.8); margin-top: 1rem;">Produtos Vitatop</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categorias Rápidas -->
    <section class="quick-categories">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="category-card">
                        <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #2d5a41, #4a7c59); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-capsules" style="font-size: 3rem; color: white;"></i>
                        </div>
                        <div class="category-overlay">
                            <h3 class="category-title">Suplementos</h3>
                            <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" class="category-link">Ver produtos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="category-card">
                        <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #4a7c59, #8fbc8f); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf" style="font-size: 3rem; color: white;"></i>
                        </div>
                        <div class="category-overlay">
                            <h3 class="category-title">Vitaminas</h3>
                            <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/18' : '/categoria/18' ?>" class="category-link">Ver produtos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="category-card">
                        <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #8fbc8f, #2d5a41); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-weight" style="font-size: 3rem; color: white;"></i>
                        </div>
                        <div class="category-overlay">
                            <h3 class="category-title">Emagrecimento</h3>
                            <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/9' : '/categoria/9' ?>" class="category-link">Ver produtos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mais Vendidos -->
    <section class="section-products" id="produtos-destaque">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Mais vendidos</h2>
                <p class="section-subtitle">Os produtos favoritos dos nossos clientes</p>
            </div>
            
            <div class="products-carousel">
                <div class="row">
                    <?php if (!empty($maisVendidos)): ?>
                        <?php foreach ($maisVendidos as $produto): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image-wrapper">
                                        <img src="https://vitatop.tecskill.com.br/<?= htmlspecialchars($produto['foto']) ?>" 
                                             alt="<?= htmlspecialchars($produto['nome']) ?>" 
                                             class="product-image"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Qcm9kdXRvPC90ZXh0Pjwvc3ZnPg=='">
                                        <button class="favorite-btn" data-product-id="<?= $produto['id'] ?>">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <?php if (floatval($produto['preco2']) > floatval($produto['preco_lojavirtual'])): ?>
                                            <?php $desconto = round((1 - floatval($produto['preco_lojavirtual']) / floatval($produto['preco2'])) * 100); ?>
                                            <span class="discount-badge">-<?= $desconto ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="product-info">
                                        <h3 class="product-title">
                                            <a href="<?= isset($afiliado) ? '/' . $afiliado . '/produto/' . $produto['id'] : '/produto/' . $produto['id'] ?>">
                                                <?= htmlspecialchars($produto['titulo']) ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="product-prices">
                                            <?php if (floatval($produto['preco2']) > floatval($produto['preco_lojavirtual'])): ?>
                                                <span class="old-price">
                                                    De R$ <?= number_format(floatval($produto['preco2']), 2, ',', '.') ?>
                                                </span>
                                            <?php endif; ?>
                                            <span class="current-price">
                                                R$ <?= number_format(floatval($produto['preco_lojavirtual']), 2, ',', '.') ?>
                                            </span>
                                        </div>
                                        
                                        <button class="btn btn-add-cart" 
                                                onclick="addToCart(<?= $produto['id'] ?>)">
                                            <i class="fas fa-shopping-bag"></i>
                                            Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="section-footer">
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" class="btn btn-outline-primary">Ver todos</a>
            </div>
        </div>
    </section>
    
    <!-- Promoções -->
    <?php if (!empty($promocoes)): ?>
        <section class="section-products promocoes-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Promoções</h2>
                    <p class="section-subtitle">Ofertas especiais por tempo limitado</p>
                </div>
                
                <div class="row">
                    <?php foreach ($promocoes as $produto): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="product-card promo-card">
                                <div class="product-image-wrapper">
                                    <img src="<?= htmlspecialchars($produto['foto']) ?>" 
                                         alt="<?= htmlspecialchars($produto['nome']) ?>" 
                                         class="product-image"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjUwIiBoZWlnaHQ9IjI1MCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2NjY2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5Qcm9kdXRvPC90ZXh0Pjwvc3ZnPg=='">
                                    <button class="favorite-btn" data-product-id="<?= $produto['id'] ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <?php $desconto = round((1 - floatval($produto['preco_lojavirtual']) / floatval($produto['preco2'])) * 100); ?>
                                    <span class="discount-badge promo-badge">-<?= $desconto ?>%</span>
                                </div>
                                
                                <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/produto/' . $produto['id'] : '/produto/' . $produto['id'] ?>">
                                            <?= htmlspecialchars($produto['titulo']) ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="product-prices">
                                        <span class="old-price">
                                            De R$ <?= number_format(floatval($produto['preco2']), 2, ',', '.') ?> por
                                        </span>
                                        <span class="current-price promo-price">
                                            R$ <?= number_format(floatval($produto['preco_lojavirtual']), 2, ',', '.') ?>
                                        </span>
                                    </div>
                                    
                                    <button class="btn btn-add-cart btn-promo" 
                                            onclick="addToCart(<?= $produto['id'] ?>)">
                                        <i class="fas fa-shopping-bag"></i>
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="section-footer">
                    <a href="#" class="btn btn-outline-primary">Ver tudo</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>