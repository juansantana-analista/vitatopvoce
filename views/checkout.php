<!-- ===== views/checkout.php ===== -->
<div class="checkout-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-credit-card"></i>
                Finalizar compra
            </h1>
            
            <div class="checkout-steps">
                <div class="step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Dados pessoais</span>
                </div>
                <div class="step">
                    <span class="step-number">2</span>
                    <span class="step-label">Endereço</span>
                </div>
                <div class="step">
                    <span class="step-number">3</span>
                    <span class="step-label">Confirmação</span>
                </div>
            </div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <div class="checkout-content">
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" class="checkout-form" id="checkoutForm">
                        <!-- Dados Pessoais -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-user"></i>
                                Dados pessoais
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nome" class="form-label">Nome completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" 
                                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefone" class="form-label">Telefone *</label>
                                    <input type="tel" class="form-control" id="telefone" name="telefone" 
                                           value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Endereço de Entrega -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Endereço de entrega
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="cep" class="form-label">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" 
                                           value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>" 
                                           placeholder="00000-000" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="rua" class="form-label">Rua *</label>
                                    <input type="text" class="form-control" id="rua" name="rua" 
                                           value="<?= htmlspecialchars($_POST['rua'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="numero" class="form-label">Número *</label>
                                    <input type="text" class="form-control" id="numero" name="numero" 
                                           value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" 
                                           value="<?= htmlspecialchars($_POST['complemento'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" 
                                           value="<?= htmlspecialchars($_POST['bairro'] ?? '') ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="cidade" class="form-label">Cidade *</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" 
                                           value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC" <?= ($_POST['estado'] ?? '') === 'AC' ? 'selected' : '' ?>>Acre</option>
                                        <option value="AL" <?= ($_POST['estado'] ?? '') === 'AL' ? 'selected' : '' ?>>Alagoas</option>
                                        <option value="AP" <?= ($_POST['estado'] ?? '') === 'AP' ? 'selected' : '' ?>>Amapá</option>
                                        <option value="AM" <?= ($_POST['estado'] ?? '') === 'AM' ? 'selected' : '' ?>>Amazonas</option>
                                        <option value="BA" <?= ($_POST['estado'] ?? '') === 'BA' ? 'selected' : '' ?>>Bahia</option>
                                        <option value="CE" <?= ($_POST['estado'] ?? '') === 'CE' ? 'selected' : '' ?>>Ceará</option>
                                        <option value="DF" <?= ($_POST['estado'] ?? '') === 'DF' ? 'selected' : '' ?>>Distrito Federal</option>
                                        <option value="ES" <?= ($_POST['estado'] ?? '') === 'ES' ? 'selected' : '' ?>>Espírito Santo</option>
                                        <option value="GO" <?= ($_POST['estado'] ?? '') === 'GO' ? 'selected' : '' ?>>Goiás</option>
                                        <option value="MA" <?= ($_POST['estado'] ?? '') === 'MA' ? 'selected' : '' ?>>Maranhão</option>
                                        <option value="MT" <?= ($_POST['estado'] ?? '') === 'MT' ? 'selected' : '' ?>>Mato Grosso</option>
                                        <option value="MS" <?= ($_POST['estado'] ?? '') === 'MS' ? 'selected' : '' ?>>Mato Grosso do Sul</option>
                                        <option value="MG" <?= ($_POST['estado'] ?? '') === 'MG' ? 'selected' : '' ?>>Minas Gerais</option>
                                        <option value="PA" <?= ($_POST['estado'] ?? '') === 'PA' ? 'selected' : '' ?>>Pará</option>
                                        <option value="PB" <?= ($_POST['estado'] ?? '') === 'PB' ? 'selected' : '' ?>>Paraíba</option>
                                        <option value="PR" <?= ($_POST['estado'] ?? '') === 'PR' ? 'selected' : '' ?>>Paraná</option>
                                        <option value="PE" <?= ($_POST['estado'] ?? '') === 'PE' ? 'selected' : '' ?>>Pernambuco</option>
                                        <option value="PI" <?= ($_POST['estado'] ?? '') === 'PI' ? 'selected' : '' ?>>Piauí</option>
                                        <option value="RJ" <?= ($_POST['estado'] ?? '') === 'RJ' ? 'selected' : '' ?>>Rio de Janeiro</option>
                                        <option value="RN" <?= ($_POST['estado'] ?? '') === 'RN' ? 'selected' : '' ?>>Rio Grande do Norte</option>
                                        <option value="RS" <?= ($_POST['estado'] ?? '') === 'RS' ? 'selected' : '' ?>>Rio Grande do Sul</option>
                                        <option value="RO" <?= ($_POST['estado'] ?? '') === 'RO' ? 'selected' : '' ?>>Rondônia</option>
                                        <option value="RR" <?= ($_POST['estado'] ?? '') === 'RR' ? 'selected' : '' ?>>Roraima</option>
                                        <option value="SC" <?= ($_POST['estado'] ?? '') === 'SC' ? 'selected' : '' ?>>Santa Catarina</option>
                                        <option value="SP" <?= ($_POST['estado'] ?? '') === 'SP' ? 'selected' : '' ?>>São Paulo</option>
                                        <option value="SE" <?= ($_POST['estado'] ?? '') === 'SE' ? 'selected' : '' ?>>Sergipe</option>
                                        <option value="TO" <?= ($_POST['estado'] ?? '') === 'TO' ? 'selected' : '' ?>>Tocantins</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="<?= isset($_SESSION['afiliado']) ? '/' . $_SESSION['afiliado'] . '/carrinho' : '/carrinho' ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Voltar ao carrinho
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i>
                                Confirmar pedido
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3 class="summary-title">Resumo do pedido</h3>
                        
                        <div class="summary-items">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="summary-item">
                                    <div class="item-image">
                                        <img src="<?= htmlspecialchars($item['produto']['foto']) ?>" 
                                             alt="<?= htmlspecialchars($item['produto']['titulo']) ?>"
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSI4IiBmaWxsPSIjNjY2NjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+UDwvdGV4dD48L3N2Zz4='">
                                    </div>
                                    <div class="item-info">
                                        <span class="item-name"><?= htmlspecialchars($item['produto']['titulo']) ?></span>
                                        <span class="item-qty">Qtd: <?= $item['quantidade'] ?></span>
                                    </div>
                                    <div class="item-price">
                                        R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="summary-totals">
                            <div class="total-line">
                                <span>Subtotal:</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            <div class="total-line">
                                <span>Frete:</span>
                                <span><?= $total >= 99 ? 'Grátis' : 'A calcular' ?></span>
                            </div>
                            <div class="total-line final">
                                <span>Total:</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="security-badges">
                            <div class="security-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Compra 100% segura</span>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-lock"></i>
                                <span>Dados protegidos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
