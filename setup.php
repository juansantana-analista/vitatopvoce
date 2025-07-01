<?php
// ===== setup.php - Arquivo de Verificação e Configuração =====
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Vitatop E-commerce</title>
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 20px; background: #f5f7fa; }
        .container { max-width: 900px; margin: 0 auto; background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #2d5a41; }
        .header h1 { color: #2d5a41; margin: 0; font-size: 2.5rem; }
        .section { margin: 30px 0; padding: 20px; border: 1px solid #e9ecef; border-radius: 8px; }
        .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
        .warning { background: #fff3cd; border-color: #ffeaa7; color: #856404; }
        .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .info { background: #d1ecf1; border-color: #bee5eb; color: #0c5460; }
        .check-item { display: flex; align-items: center; margin: 10px 0; }
        .check-item i { margin-right: 10px; font-size: 18px; }
        .ok { color: #28a745; }
        .error-icon { color: #dc3545; }
        .warning-icon { color: #ffc107; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #2d5a41; }
        .code { background: #f1f3f4; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px; margin: 10px 0; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
        .btn { display: inline-block; padding: 10px 20px; background: #2d5a41; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #4a7c59; }
        .status-badge { padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .status-ok { background: #28a745; color: white; }
        .status-error { background: #dc3545; color: white; }
        .status-warning { background: #ffc107; color: black; }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-store"></i> VITATOP E-COMMERCE</h1>
            <p>Sistema de Verificação e Configuração</p>
        </div>

        <?php
        // Verificações do sistema
        $checks = [];
        $errors = [];
        $warnings = [];

        // 1. Verificar se o PHP é compatível
        $phpVersion = PHP_VERSION;
        if (version_compare($phpVersion, '7.4.0', '>=')) {
            $checks[] = ['ok' => true, 'message' => "PHP $phpVersion ✓"];
        } else {
            $errors[] = "PHP $phpVersion (necessário 7.4+)";
        }

        // 2. Verificar extensões necessárias
        $requiredExtensions = ['curl', 'json', 'session'];
        foreach ($requiredExtensions as $ext) {
            if (extension_loaded($ext)) {
                $checks[] = ['ok' => true, 'message' => "Extensão $ext ✓"];
            } else {
                $errors[] = "Extensão $ext não encontrada";
            }
        }

        // 3. Verificar arquivos essenciais
        $requiredFiles = [
            'config/config.php' => 'Configuração principal',
            'classes/ApiClient.php' => 'Cliente da API',
            'classes/Router.php' => 'Sistema de rotas',
            'classes/Cart.php' => 'Carrinho de compras',
            'controllers/HomeController.php' => 'Controller principal',
            'views/layouts/header.php' => 'Layout do cabeçalho',
            'views/home.php' => 'Página inicial',
            'assets/css/style.css' => 'Estilos CSS',
            'assets/js/main.js' => 'JavaScript principal',
            '.htaccess' => 'Configuração Apache'
        ];

        foreach ($requiredFiles as $file => $description) {
            if (file_exists($file)) {
                $checks[] = ['ok' => true, 'message' => "$description ✓"];
            } else {
                $errors[] = "$description ($file) não encontrado";
            }
        }

        // 4. Verificar se a configuração foi alterada
        if (file_exists('config/config.php')) {
            $configContent = file_get_contents('config/config.php');
            if (strpos($configContent, 'localhost/vitatopvoce') !== false) {
                $warnings[] = 'URL do site ainda está como localhost - altere em config/config.php';
            }
            if (strpos($configContent, '50119e057567b086d83fe5dd18336042ff2cf7bef3c24807bc55e34dbe5a') !== false) {
                $checks[] = ['ok' => true, 'message' => 'Token da API configurado ✓'];
            }
        }

        // 5. Verificar permissões de escrita
        $writableDirs = ['assets/', 'views/'];
        foreach ($writableDirs as $dir) {
            if (is_writable($dir)) {
                $checks[] = ['ok' => true, 'message' => "Permissão de escrita em $dir ✓"];
            } else {
                $warnings[] = "Sem permissão de escrita em $dir";
            }
        }

        // 6. Testar sessões
        if (session_start()) {
            $_SESSION['test'] = 'ok';
            if (isset($_SESSION['test'])) {
                $checks[] = ['ok' => true, 'message' => 'Sessões PHP funcionando ✓'];
                unset($_SESSION['test']);
            }
        } else {
            $errors[] = 'Sessões PHP não funcionam';
        }

        // 7. Verificar mod_rewrite (se Apache)
        if (function_exists('apache_get_modules')) {
            if (in_array('mod_rewrite', apache_get_modules())) {
                $checks[] = ['ok' => true, 'message' => 'mod_rewrite habilitado ✓'];
            } else {
                $errors[] = 'mod_rewrite não está habilitado';
            }
        } else {
            $warnings[] = 'Não foi possível verificar mod_rewrite (pode estar usando Nginx)';
        }

        // 8. Testar conectividade da API
        if (file_exists('config/config.php')) {
            include_once 'config/config.php';
            include_once 'classes/ApiClient.php';
            
            try {
                $apiClient = new ApiClient();
                $response = $apiClient->listarProdutos();
                if (isset($response['status']) && $response['status'] === 'success') {
                    $checks[] = ['ok' => true, 'message' => 'Conexão com API funcionando ✓'];
                    $productCount = count($response['data']['data'] ?? []);
                    $checks[] = ['ok' => true, 'message' => "$productCount produtos encontrados na API ✓"];
                } else {
                    $errors[] = 'API retornou erro: ' . ($response['message'] ?? 'Erro desconhecido');
                }
            } catch (Exception $e) {
                $errors[] = 'Erro ao conectar com API: ' . $e->getMessage();
            }
        }
        ?>

        <!-- Status Geral -->
        <div class="section <?= empty($errors) ? 'success' : 'error' ?>">
            <h2><i class="fas fa-clipboard-check"></i> Status do Sistema</h2>
            <?php if (empty($errors)): ?>
                <p><strong>✅ Sistema configurado corretamente!</strong></p>
                <p>Todos os componentes essenciais estão funcionando.</p>
            <?php else: ?>
                <p><strong>❌ Existem problemas que precisam ser corrigidos:</strong></p>
                <?php foreach ($errors as $error): ?>
                    <div class="check-item">
                        <i class="fas fa-times error-icon"></i>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Verificações Detalhadas -->
        <div class="grid">
            <div>
                <div class="section info">
                    <h3><i class="fas fa-check-circle"></i> Verificações Aprovadas</h3>
                    <?php foreach ($checks as $check): ?>
                        <div class="check-item">
                            <i class="fas fa-check ok"></i>
                            <span><?= htmlspecialchars($check['message']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <?php if (!empty($warnings)): ?>
                    <div class="section warning">
                        <h3><i class="fas fa-exclamation-triangle"></i> Avisos</h3>
                        <?php foreach ($warnings as $warning): ?>
                            <div class="check-item">
                                <i class="fas fa-exclamation-triangle warning-icon"></i>
                                <span><?= htmlspecialchars($warning) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="section info">
                    <h3><i class="fas fa-info-circle"></i> Informações do Sistema</h3>
                    <div class="check-item">
                        <i class="fas fa-server"></i>
                        <span>PHP: <?= PHP_VERSION ?></span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-globe"></i>
                        <span>Servidor: <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido' ?></span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-folder"></i>
                        <span>Diretório: <?= __DIR__ ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuração Passo a Passo -->
        <div class="section">
            <h2><i class="fas fa-cogs"></i> Configuração Passo a Passo</h2>
            
            <div class="step">
                <h4>1. Configurar API</h4>
                <p>Edite o arquivo <code>config/config.php</code>:</p>
                <div class="code">
const API_URL = 'https://vitatop.tecskill.com.br/rest.php';<br>
const API_TOKEN = 'SEU_TOKEN_AQUI';<br>
const SITE_URL = 'https://seudominio.com.br';<br>
const SITE_NAME = 'VITATOP';
                </div>
            </div>

            <div class="step">
                <h4>2. Configurar URLs Amigáveis</h4>
                <p>Certifique-se de que o arquivo <code>.htaccess</code> está na raiz:</p>
                <div class="code">
RewriteEngine On<br>
RewriteCond %{REQUEST_FILENAME} !-f<br>
RewriteCond %{REQUEST_FILENAME} !-d<br>
RewriteRule ^(.*)$ index.php [QSA,L]
                </div>
            </div>

            <div class="step">
                <h4>3. Testar URLs de Afiliados</h4>
                <p>Teste as seguintes URLs:</p>
                <div class="code">
<?= Config::SITE_URL ?? 'https://seudominio.com.br' ?>/<br>
<?= Config::SITE_URL ?? 'https://seudominio.com.br' ?>/joao<br>
<?= Config::SITE_URL ?? 'https://seudominio.com.br' ?>/maria/produto/1<br>
<?= Config::SITE_URL ?? 'https://seudominio.com.br' ?>/pedro/carrinho
                </div>
            </div>

            <div class="step">
                <h4>4. Verificar Funcionalidades</h4>
                <ul>
                    <li>✅ Listagem de produtos</li>
                    <li>✅ Adicionar ao carrinho</li>
                    <li>✅ Finalizar compra</li>
                    <li>✅ Sistema de afiliados</li>
                    <li>✅ Busca de produtos</li>
                    <li>✅ Responsividade mobile</li>
                </ul>
            </div>
        </div>

        <!-- Testes Rápidos -->
        <div class="section">
            <h2><i class="fas fa-vial"></i> Testes Rápidos</h2>
            <div class="grid">
                <div>
                    <h4>URLs para Testar:</h4>
                    <a href="/" class="btn">Página Inicial</a>
                    <a href="/produto/1" class="btn">Produto Individual</a>
                    <a href="/carrinho" class="btn">Carrinho</a>
                    <a href="/categoria/17" class="btn">Categoria</a>
                </div>
                <div>
                    <h4>URLs com Afiliado:</h4>
                    <a href="/teste" class="btn">Afiliado: teste</a>
                    <a href="/joao/produto/1" class="btn">Produto via João</a>
                    <a href="/maria/carrinho" class="btn">Carrinho via Maria</a>
                </div>
            </div>
        </div>

        <!-- Status Final -->
        <div class="section <?= empty($errors) ? 'success' : 'warning' ?>">
            <h2><i class="fas fa-flag-checkered"></i> Próximos Passos</h2>
            <?php if (empty($errors)): ?>
                <p><strong>🎉 Parabéns! Seu e-commerce está pronto!</strong></p>
                <ul>
                    <li>✅ Configure suas imagens em <code>assets/images/</code></li>
                    <li>✅ Personalize as cores em <code>assets/css/style.css</code></li>
                    <li>✅ Configure SSL (HTTPS) no seu servidor</li>
                    <li>✅ Teste todas as funcionalidades</li>
                    <li>✅ Configure backups regulares</li>
                </ul>
                <p><strong>Seu sistema de afiliados está funcionando!</strong></p>
            <?php else: ?>
                <p><strong>⚠️ Corrija os erros acima antes de usar o sistema.</strong></p>
                <p>Após corrigir, recarregue esta página para verificar novamente.</p>
            <?php endif; ?>
        </div>

        <!-- Informações de Contato -->
        <div class="section info">
            <h3><i class="fas fa-life-ring"></i> Suporte</h3>
            <p>Em caso de problemas:</p>
            <ol>
                <li>Verifique os logs de erro do PHP</li>
                <li>Confirme se todos os arquivos foram carregados</li>
                <li>Teste a API diretamente</li>
                <li>Verifique as configurações do servidor</li>
            </ol>
        </div>
    </div>

    <script>
        // Auto-refresh a cada 30 segundos se houver erros
        <?php if (!empty($errors)): ?>
            setTimeout(() => {
                if (confirm('Deseja verificar novamente o sistema?')) {
                    location.reload();
                }
            }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>

<?php
// ===== test_api.php - Arquivo de Teste da API =====
if (isset($_GET['test_api'])) {
    header('Content-Type: application/json');
    
    try {
        include_once 'config/config.php';
        include_once 'classes/ApiClient.php';
        
        $apiClient = new ApiClient();
        $response = $apiClient->listarProdutos();
        
        echo json_encode([
            'success' => true,
            'data' => $response,
            'timestamp' => date('Y-m-d H:i:s')
        ], JSON_PRETTY_PRINT);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'timestamp' => date('Y-m-d H:i:s')
        ], JSON_PRETTY_PRINT);
    }
    exit;
}
?>

<?php
// ===== create_images.php - Script para criar imagens placeholder =====
if (isset($_GET['create_images'])) {
    $imageDir = 'assets/images/';
    
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0755, true);
    }
    
    // Criar um favicon simples
    $faviconSvg = '<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg">
        <rect width="32" height="32" fill="#2d5a41"/>
        <text x="16" y="20" font-family="Arial" font-size="18" fill="white" text-anchor="middle">V</text>
    </svg>';
    
    file_put_contents($imageDir . 'favicon.svg', $faviconSvg);
    
    // Criar logo placeholder
    $logoSvg = '<svg width="200" height="60" xmlns="http://www.w3.org/2000/svg">
        <rect width="200" height="60" fill="#2d5a41" rx="5"/>
        <text x="100" y="35" font-family="Arial" font-size="24" font-weight="bold" fill="white" text-anchor="middle">VITATOP</text>
    </svg>';
    
    file_put_contents($imageDir . 'logo-vitatop.svg', $logoSvg);
    
    echo json_encode(['success' => true, 'message' => 'Imagens placeholder criadas']);
    exit;
}
?>

<?php
// ===== Arquivo de informações do sistema =====
// Este arquivo pode ser removido após a configuração inicial
// Para acessar: https://seudominio.com.br/setup.php
?>
