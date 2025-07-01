<!-- ===== views/layouts/header.php ===== -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?><?= Config::SITE_NAME ?><?= isset($afiliado) ? ' | ' . ucfirst($afiliado) : '' ?></title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <!-- Meta tags para SEO -->
    <meta name="description" content="Produtos naturais e suplementos Vitatop - Sua saúde em primeiro lugar">
    <meta name="keywords" content="suplementos, produtos naturais, vitatop, saúde, bem-estar">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= Config::SITE_NAME ?>">
    <meta property="og:description" content="Produtos naturais e suplementos para sua saúde">
    <meta property="og:url" content="<?= Config::SITE_URL ?>">
</head>
<body>
    <!-- Header Principal -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo-section">
                    <a href="<?= isset($afiliado) ? '/' . $afiliado : '/' ?>" class="logo-link">
                        <span class="logo-text"><?= Config::SITE_NAME ?></span>
                    </a>
                </div>
                
                <!-- Barra de Busca -->
                <div class="search-section">
                    <form action="<?= isset($afiliado) ? '/' . $afiliado . '/buscar' : '/buscar' ?>" method="GET" class="search-form">
                        <div class="search-input-wrapper">
                            <input type="text" 
                                   name="q" 
                                   placeholder="O que você procura?" 
                                   class="search-input"
                                   value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Ações do usuário -->
                <div class="user-actions">
                    <!-- Badge do Afiliado -->
                    <?php if (isset($afiliado) && $afiliado): ?>
                        <div class="affiliate-badge">
                            <i class="fas fa-user-tag"></i>
                            <span><?= ucfirst($afiliado) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Favoritos -->
                    <button class="action-btn favorites-btn" type="button">
                        <i class="far fa-heart"></i>
                        <span class="action-text">Favoritos</span>
                    </button>
                    
                    <!-- Carrinho -->
                    <a href="<?= isset($afiliado) ? '/' . $afiliado . '/carrinho' : '/carrinho' ?>" class="action-btn cart-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="action-text">Sacola</span>
                        <span class="cart-count" id="cartCount">
                            <?php
                            $cart = new Cart();
                            $totalItems = $cart->getTotalItems();
                            echo $totalItems > 0 ? $totalItems : '';
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Menu de Navegação -->
    <nav class="main-navigation">
        <div class="container">
            <div class="nav-content">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado : '/' ?>" class="nav-link">
                            VOLTAR AO INÍCIO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/17' : '/categoria/17' ?>" class="nav-link">
                            SUPLEMENTOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/4' : '/categoria/4' ?>" class="nav-link">
                            LANÇAMENTOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/18' : '/categoria/18' ?>" class="nav-link">
                            VITAMINAS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= isset($afiliado) ? '/' . $afiliado . '/categoria/9' : '/categoria/9' ?>" class="nav-link">
                            EMAGRECIMENTO
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Container Principal -->
    <main class="main-content">