<!-- ===== views/error.php ===== -->
<div class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            
            <h1 class="error-title">Ops! Algo deu errado</h1>
            
            <div class="error-message">
                <p><?= htmlspecialchars($error ?? 'Erro desconhecido') ?></p>
            </div>
            
            <div class="error-actions">
                <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] : '/' ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Voltar à página inicial
                </a>
                <button onclick="history.back()" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar
                </button>
            </div>
        </div>
    </div>
</div>