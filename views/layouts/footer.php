<!-- ===== views/layouts/footer.php ===== -->
    </main>
    
    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-title"><?= Config::SITE_NAME ?></h5>
                            <p class="footer-text">
                                Produtos naturais e suplementos de alta qualidade para cuidar da sua saúde e bem-estar.
                            </p>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h6 class="footer-subtitle">Categorias</h6>
                            <ul class="footer-links">
                                <li><a href="/categoria/17">Suplementos</a></li>
                                <li><a href="/categoria/4">Lançamentos</a></li>
                                <li><a href="/categoria/18">Vitaminas</a></li>
                                <li><a href="/categoria/9">Emagrecimento</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-section">
                            <h6 class="footer-subtitle">Atendimento</h6>
                            <ul class="footer-links">
                                <li><a href="#">Central de Ajuda</a></li>
                                <li><a href="#">Política de Privacidade</a></li>
                                <li><a href="#">Termos de Uso</a></li>
                                <li><a href="#">Trocas e Devoluções</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-section">
                            <h6 class="footer-subtitle">Fale Conosco</h6>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>(11) 3000-0000</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>contato@vitatop.com.br</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Seg a Sex: 8h às 18h</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Linha do afiliado -->
                <?php if (isset($afiliado) && $afiliado): ?>
                    <div class="affiliate-footer">
                        <div class="affiliate-info">
                            <i class="fas fa-handshake"></i>
                            <span>Vendas realizadas através do parceiro: <strong><?= ucfirst($afiliado) ?></strong></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="copyright">
                                &copy; <?= date('Y') ?> <?= Config::SITE_NAME ?>. Todos os direitos reservados.
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="payment-methods">
                                <small class="text-muted">Formas de pagamento aceitas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>