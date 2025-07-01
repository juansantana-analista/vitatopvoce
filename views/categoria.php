<!-- ===== views/categoria.php ===== -->
<div class="category-page">
    <div class="container">
        <div class="category-header">
            <h1 class="page-title">
                <i class="fas fa-layer-group"></i>
                <?php
                $categoryNames = [
                    '17' => 'Suplementos',
                    '4' => 'Lançamentos', 
                    '18' => 'Vitaminas',
                    '9' => 'Emagrecimento',
                    '2' => 'Visão',
                    '3' => 'Articulações',
                    '7' => 'Sono'
                ];
                echo $categoryNames[$categoriaId] ?? 'Categoria ' . $categoriaId;
                ?>
            </h1>
            <p class="category-description">
                <?php if (!empty($produtos)): ?>
                    <span class="product-count"><?= count($produtos) ?> <?= count($produtos) == 1 ? 'produto encontrado' : 'produtos encontrados' ?></span>
                <?php endif; ?>
            </p>
        </div>
        
        <!-- Filtros e Ordenação -->
        <div class="category-filters">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="filter-options">
                        <span class="filter-label">Filtrar por:</span>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="all">Todos</button>
                            <button class="filter-btn" data-filter="promocao">Em promoção</button>
                            <button class="filter-btn" data-filter="menor-preco">Menor preço</button>
                            <button class="filter-btn" data-filter="maior-preco">Maior preço</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="sort-options">
                        <span class="sort-label">Ordenar por:</span>
                        <select class="sort-select" id="sortProducts">
                            <option value="relevancia">Relevância</option>
                            <option value="menor-preco">Menor preço</option>
                            <option value="maior-preco">Maior preço</option>
                            <option value="nome">Nome A-Z</option>
                            <option value="promocao">Promoções</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($produtos)): ?>
            <div class="category-products" id="productsGrid">
                <div class="row">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" 
                             data-price="<?= floatval($produto['preco_lojavirtual']) ?>"
                             data-name="<?= strtolower($produto['titulo']) ?>"
                             data-promotion="<?= floatval($produto['preco2']) > floatval($produto['preco_lojavirtual']) ? 'true' : 'false' ?>">
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
            <div class="no-products">
                <div class="no-products-content">
                    <div class="no-products-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h2 class="no-products-title">Nenhum produto nesta categoria</h2>
                    <p class="no-products-text">
                        Não há produtos disponíveis nesta categoria no momento.
                    </p>
                    <div class="no-products-actions">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado : '/' ?>" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            Ver todos os produtos
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Navegação entre categorias -->
        <div class="category-navigation">
            <h3>Outras categorias</h3>
            <div class="category-links">
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" 
                   class="category-link <?= $categoriaId == '17' ? 'active' : '' ?>">
                    <i class="fas fa-capsules"></i>
                    Suplementos
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/18' : '/categoria/18' ?>" 
                   class="category-link <?= $categoriaId == '18' ? 'active' : '' ?>">
                    <i class="fas fa-leaf"></i>
                    Vitaminas
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/9' : '/categoria/9' ?>" 
                   class="category-link <?= $categoriaId == '9' ? 'active' : '' ?>">
                    <i class="fas fa-weight"></i>
                    Emagrecimento
                </a>
                <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/4' : '/categoria/4' ?>" 
                   class="category-link <?= $categoriaId == '4' ? 'active' : '' ?>">
                    <i class="fas fa-star"></i>
                    Lançamentos
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para a página de categoria */
.category-page {
    padding: 2rem 0;
}

.category-header {
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

.category-description {
    font-size: 1.125rem;
    color: var(--text-light);
}

.product-count {
    color: var(--primary-color);
    font-weight: 600;
}

.category-filters {
    background: var(--bg-light);
    border-radius: var(--border-radius-lg);
    padding: 1.5rem;
    margin-bottom: 3rem;
}

.filter-label,
.sort-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-right: 1rem;
}

.filter-buttons {
    display: inline-flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    background: var(--white);
    border: 2px solid var(--border-light);
    color: var(--text-dark);
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
    font-weight: 500;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
}

.sort-select {
    background: var(--white);
    border: 2px solid var(--border-light);
    color: var(--text-dark);
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    cursor: pointer;
    min-width: 150px;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary-color);
}

.category-products {
    margin-bottom: 4rem;
}

.product-item {
    transition: var(--transition);
}

.product-item.hidden {
    display: none;
}

.no-products {
    text-align: center;
    padding: 4rem 0;
}

.no-products-content {
    max-width: 600px;
    margin: 0 auto;
}

.no-products-icon {
    font-size: 5rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

.no-products-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.no-products-text {
    font-size: 1.125rem;
    color: var(--text-light);
    margin-bottom: 2rem;
}

.no-products-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.category-navigation {
    background: var(--bg-light);
    border-radius: var(--border-radius-lg);
    padding: 2rem;
    text-align: center;
}

.category-navigation h3 {
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

.category-link:hover,
.category-link.active {
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
    
    .category-filters {
        padding: 1rem;
    }
    
    .category-filters .row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .category-filters .col-md-6 {
        text-align: center;
    }
    
    .filter-buttons {
        justify-content: center;
    }
    
    .sort-options {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
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

<script>
// JavaScript para filtros e ordenação
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortProducts');
    const productsGrid = document.getElementById('productsGrid');
    
    // Filtros
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active de todos os botões
            filterBtns.forEach(b => b.classList.remove('active'));
            // Adiciona active no botão clicado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterProducts(filter);
        });
    });
    
    // Ordenação
    sortSelect.addEventListener('change', function() {
        sortProducts(this.value);
    });
    
    function filterProducts(filter) {
        const products = document.querySelectorAll('.product-item');
        
        products.forEach(product => {
            product.classList.remove('hidden');
            
            switch(filter) {
                case 'promocao':
                    if (product.dataset.promotion !== 'true') {
                        product.classList.add('hidden');
                    }
                    break;
                case 'menor-preco':
                    // Este filtro será tratado pela ordenação
                    break;
                case 'maior-preco':
                    // Este filtro será tratado pela ordenação
                    break;
                case 'all':
                default:
                    // Mostra todos
                    break;
            }
        });
    }
    
    function sortProducts(sortBy) {
        const products = Array.from(document.querySelectorAll('.product-item'));
        const row = productsGrid.querySelector('.row');
        
        products.sort((a, b) => {
            switch(sortBy) {
                case 'menor-preco':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'maior-preco':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'nome':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'promocao':
                    if (a.dataset.promotion === 'true' && b.dataset.promotion !== 'true') {
                        return -1;
                    }
                    if (a.dataset.promotion !== 'true' && b.dataset.promotion === 'true') {
                        return 1;
                    }
                    return 0;
                default: // relevancia
                    return 0;
            }
        });
        
        // Reordena os elementos no DOM
        products.forEach(product => {
            row.appendChild(product);
        });
    }
});
</script>