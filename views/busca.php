<!-- ===== views/busca.php ===== -->
<div class="search-page">
    <div class="container">
        <div class="search-header">
            <h1 class="page-title">
                <i class="fas fa-search"></i>
                Resultados da busca
            </h1>
            <p class="search-query">
                Você buscou por: <strong>"<?= htmlspecialchars($termo) ?>"</strong>
                <?php if (!empty($produtos)): ?>
                    <span class="search-count">(<?= count($produtos) ?> <?= count($produtos) == 1 ? 'produto encontrado' : 'produtos encontrados' ?>)</span>
                <?php endif; ?>
            </p>
        </div>
        
        <?php if (!empty($produtos)): ?>
            <div class="search-results">
                <div class="row">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="<?= htmlspecialchars($produto['foto']) ?>" 
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
                </div>
            </div>
        <?php else: ?>
            <div class="no-results">
                <div class="no-results-content">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="no-results-title">Nenhum produto encontrado</h2>
                    <p class="no-results-text">
                        Não encontramos produtos com o termo "<strong><?= htmlspecialchars($termo) ?></strong>".
                    </p>
                    <div class="no-results-suggestions">
                        <h4>Que tal tentar:</h4>
                        <ul>
                            <li>Verificar a ortografia das palavras</li>
                            <li>Usar termos mais genéricos</li>
                            <li>Buscar por categorias específicas</li>
                        </ul>
                    </div>
                    <div class="no-results-actions">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado : '/' ?>" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            Ver todos os produtos
                        </a>
                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" class="btn btn-outline-primary">
                            <i class="fas fa-pills"></i>
                            Ver suplementos
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Sugestões de categorias -->
        <div class="search-suggestions">
            <h3>Navegue por categorias</h3>
            <div class="category-links">
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" class="category-link">
                    <i class="fas fa-capsules"></i>
                    Suplementos
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/18' : '/categoria/18' ?>" class="category-link">
                    <i class="fas fa-leaf"></i>
                    Vitaminas
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/9' : '/categoria/9' ?>" class="category-link">
                    <i class="fas fa-weight"></i>
                    Emagrecimento
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/4' : '/categoria/4' ?>" class="category-link">
                    <i class="fas fa-star"></i>
                    Lançamentos
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para a página de busca */
.search-page {
    padding: 2rem 0;
}

.search-header {
    margin-bottom: 3rem;
    text-align: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.search-query {
    font-size: 1.125rem;
    color: var(--text-light);
}

.search-count {
    color: var(--primary-color);
    font-weight: 600;
}

.search-results {
    margin-bottom: 4rem;
}

.no-results {
    text-align: center;
    padding: 4rem 0;
}

.no-results-content {
    max-width: 600px;
    margin: 0 auto;
}

.no-results-icon {
    font-size: 5rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.no-results-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.no-results-text {
    font-size: 1.125rem;
    color: var(--text-light);
    margin-bottom: 2rem;
}

.no-results-suggestions {
    background: var(--bg-light);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: left;
}

.no-results-suggestions h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.no-results-suggestions ul {
    list-style: none;
    padding: 0;
}

.no-results-suggestions li {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-light);
}

.no-results-suggestions li:last-child {
    border-bottom: none;
}

.no-results-suggestions li:before {
    content: "•";
    color: var(--primary-color);
    margin-right: 0.5rem;
}

.no-results-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.search-suggestions {
    background: var(--bg-light);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    text-align: center;
}

.search-suggestions h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.category-links {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.category-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--white);
    color: var(--primary-color);
    text-decoration: none;
    border-radius: var(--border-radius);
    border: 2px solid var(--border-light);
    transition: var(--transition);
    font-weight: 600;
}

.category-link:hover {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .no-results-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .category-links {
        flex-direction: column;
        align-items: center;
    }
    
    .category-link {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}
</style>