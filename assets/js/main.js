/* ===== assets/js/main.js ===== */

// Configurações globais
const CONFIG = {
    API_BASE_URL: '/api',
    CART_ENDPOINT: '/carrinho',
    FAVORITES_KEY: 'vitatop_favorites',
    ANIMATION_DURATION: 300,
    NOTIFICATION_DURATION: 3000
};

// Classe principal da aplicação
class VitaToppApp {
    constructor() {
        this.favorites = this.loadFavorites();
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeComponents();
        this.setupFormValidation();
        this.updateCartCount();
        this.initializeFavorites();
    }

    // Event Listeners
    setupEventListeners() {
        // Botões de quantidade
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('qty-plus')) {
                this.increaseQuantity(e.target);
            } else if (e.target.classList.contains('qty-minus')) {
                this.decreaseQuantity(e.target);
            } else if (e.target.classList.contains('favorite-btn')) {
                this.toggleFavorite(e.target);
            }
        });

        // Busca por CEP
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('blur', this.buscarCEP.bind(this));
            cepInput.addEventListener('input', this.maskCEP.bind(this));
        }

        // Máscara de telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', this.maskTelefone.bind(this));
        }

        // Validação em tempo real
        const form = document.getElementById('checkoutForm');
        if (form) {
            form.addEventListener('submit', this.validateCheckoutForm.bind(this));
            
            // Validação em tempo real dos campos
            const inputs = form.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('input', () => this.clearFieldError(input));
            });
        }

        // Thumbnail gallery na página do produto
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => this.changeMainImage(thumb));
        });

        // Busca
        const searchForm = document.querySelector('.search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', this.handleSearch.bind(this));
        }
    }

    // Inicializar componentes
    initializeComponents() {
        this.initializeCarousels();
        this.initializeLazyLoading();
        this.initializeTooltips();
        this.initializeModals();
    }

    // === CARRINHO ===
    
    // Adicionar produto ao carrinho
    async addToCart(productId, quantity = 1) {
        try {
            this.showLoading();
            
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            const response = await fetch(`${CONFIG.CART_ENDPOINT}/add`, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Produto adicionado ao carrinho!', 'success');
                this.updateCartCount();
                this.animateCartButton();
            } else {
                throw new Error(data.message || 'Erro ao adicionar produto');
            }
        } catch (error) {
            console.error('Erro ao adicionar ao carrinho:', error);
            this.showNotification('Erro ao adicionar produto ao carrinho', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Adicionar com quantidade personalizada
    addToCartWithQuantity(productId) {
        const quantityInput = document.getElementById('quantity');
        const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
        this.addToCart(productId, quantity);
    }

    // Remover do carrinho
    async removeFromCart(productId) {
        if (!confirm('Tem certeza que deseja remover este produto?')) {
            return;
        }

        try {
            this.showLoading();

            const formData = new FormData();
            formData.append('product_id', productId);

            const response = await fetch(`${CONFIG.CART_ENDPOINT}/remove`, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Produto removido do carrinho', 'success');
                this.updateCartCount();
                
                // Remover elemento da página se estivermos na página do carrinho
                const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
                if (cartItem) {
                    cartItem.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => {
                        cartItem.remove();
                        this.checkEmptyCart();
                    }, 300);
                }
            } else {
                throw new Error(data.message || 'Erro ao remover produto');
            }
        } catch (error) {
            console.error('Erro ao remover do carrinho:', error);
            this.showNotification('Erro ao remover produto do carrinho', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Atualizar quantidade
    async updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) {
            this.removeFromCart(productId);
            return;
        }

        try {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', newQuantity);

            const response = await fetch(`${CONFIG.CART_ENDPOINT}/update`, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount();
                this.updateCartTotals();
            } else {
                throw new Error(data.message || 'Erro ao atualizar quantidade');
            }
        } catch (error) {
            console.error('Erro ao atualizar quantidade:', error);
            this.showNotification('Erro ao atualizar quantidade', 'error');
        }
    }

    // Atualizar contador do carrinho
    async updateCartCount() {
        try {
            const response = await fetch(`${CONFIG.CART_ENDPOINT}/count`);
            const data = await response.json();

            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.totalItems > 0 ? data.totalItems : '';
                cartCount.style.display = data.totalItems > 0 ? 'block' : 'none';
                
                if (data.totalItems > 0) {
                    cartCount.classList.add('animate-pulse');
                    setTimeout(() => cartCount.classList.remove('animate-pulse'), 600);
                }
            }
        } catch (error) {
            console.error('Erro ao atualizar contador do carrinho:', error);
        }
    }

    // Verificar carrinho vazio
    checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length === 0) {
            const cartContent = document.querySelector('.cart-content');
            if (cartContent) {
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-content">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h2 class="empty-cart-title">Sua sacola está vazia</h2>
                            <p class="empty-cart-text">Que tal conhecer nossos produtos?</p>
                            <a href="/" class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-left"></i>
                                Ver produtos
                            </a>
                        </div>
                    </div>
                `;
            }
        }
    }

    // === CONTROLES DE QUANTIDADE ===

    increaseQuantity(button) {
        const input = button.parentElement.querySelector('.qty-input');
        if (input) {
            const currentValue = parseInt(input.value) || 0;
            const maxValue = parseInt(input.getAttribute('max')) || 10;
            
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                
                // Se estamos na página do carrinho, atualizar quantidade
                const productId = input.closest('[data-product-id]')?.getAttribute('data-product-id');
                if (productId) {
                    this.updateQuantity(productId, parseInt(input.value));
                }
            }
        }
    }

    decreaseQuantity(button) {
        const input = button.parentElement.querySelector('.qty-input');
        if (input) {
            const currentValue = parseInt(input.value) || 0;
            const minValue = parseInt(input.getAttribute('min')) || 1;
            
            if (currentValue > minValue) {
                input.value = currentValue - 1;
                
                // Se estamos na página do carrinho, atualizar quantidade
                const productId = input.closest('[data-product-id]')?.getAttribute('data-product-id');
                if (productId) {
                    this.updateQuantity(productId, parseInt(input.value));
                }
            }
        }
    }

    // === FAVORITOS ===

    loadFavorites() {
        const saved = localStorage.getItem(CONFIG.FAVORITES_KEY);
        return saved ? JSON.parse(saved) : [];
    }

    saveFavorites() {
        localStorage.setItem(CONFIG.FAVORITES_KEY, JSON.stringify(this.favorites));
    }

    toggleFavorite(button) {
        const productId = button.getAttribute('data-product-id');
        const icon = button.querySelector('i');
        
        if (this.favorites.includes(productId)) {
            // Remover dos favoritos
            this.favorites = this.favorites.filter(id => id !== productId);
            icon.className = 'far fa-heart';
            this.showNotification('Produto removido dos favoritos', 'info');
        } else {
            // Adicionar aos favoritos
            this.favorites.push(productId);
            icon.className = 'fas fa-heart';
            this.showNotification('Produto adicionado aos favoritos!', 'success');
        }
        
        this.saveFavorites();
        button.classList.add('animate-pulse');
        setTimeout(() => button.classList.remove('animate-pulse'), 300);
    }

    initializeFavorites() {
        const favoriteButtons = document.querySelectorAll('.favorite-btn');
        favoriteButtons.forEach(button => {
            const productId = button.getAttribute('data-product-id');
            const icon = button.querySelector('i');
            
            if (this.favorites.includes(productId)) {
                icon.className = 'fas fa-heart';
            }
        });
    }

    // === BUSCA POR CEP ===

    maskCEP(event) {
        let value = event.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        event.target.value = value;
    }

    async buscarCEP(event) {
        const cep = event.target.value.replace(/\D/g, '');
        
        if (cep.length === 8) {
            try {
                this.showLoading();
                
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();
                
                if (!data.erro) {
                    // Preencher campos automaticamente
                    this.fillAddressFields(data);
                    this.showNotification('CEP encontrado!', 'success');
                } else {
                    this.showNotification('CEP não encontrado', 'warning');
                }
            } catch (error) {
                console.error('Erro ao buscar CEP:', error);
                this.showNotification('Erro ao buscar CEP', 'error');
            } finally {
                this.hideLoading();
            }
        }
    }

    fillAddressFields(data) {
        const fields = {
            'rua': data.logradouro,
            'bairro': data.bairro,
            'cidade': data.localidade,
            'estado': data.uf
        };

        Object.keys(fields).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && fields[fieldName]) {
                field.value = fields[fieldName];
                field.classList.add('field-updated');
                setTimeout(() => field.classList.remove('field-updated'), 1000);
            }
        });

        // Focar no campo número
        const numeroField = document.getElementById('numero');
        if (numeroField) {
            numeroField.focus();
        }
    }

    // === MÁSCARAS DE INPUT ===

    maskTelefone(event) {
        let value = event.target.value.replace(/\D/g, '');
        
        if (value.length <= 10) {
            value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
        } else {
            value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        }
        
        event.target.value = value;
    }

    // === VALIDAÇÃO DE FORMULÁRIOS ===

    setupFormValidation() {
        // Adicionar estilos CSS para validação
        const style = document.createElement('style');
        style.textContent = `
            .field-error {
                border-color: var(--danger) !important;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
            }
            .field-success {
                border-color: var(--success) !important;
                box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1) !important;
            }
            .field-updated {
                background-color: rgba(40, 167, 69, 0.1) !important;
                transition: background-color 1s ease-out;
            }
            .error-message {
                color: var(--danger);
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: block;
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(-20px); }
            }
            .animate-pulse {
                animation: pulse 0.6s ease-in-out;
            }
        `;
        document.head.appendChild(style);
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        let isValid = true;
        let errorMessage = '';

        // Remover mensagens de erro anteriores
        this.clearFieldError(field);

        // Validação de campo obrigatório
        if (isRequired && !value) {
            isValid = false;
            errorMessage = 'Este campo é obrigatório';
        }

        // Validações específicas por tipo
        if (value && field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'E-mail inválido';
            }
        }

        if (value && field.id === 'cep') {
            const cepRegex = /^\d{5}-?\d{3}$/;
            if (!cepRegex.test(value)) {
                isValid = false;
                errorMessage = 'CEP inválido';
            }
        }

        if (value && field.id === 'telefone') {
            const telefoneRegex = /^\(\d{2}\)\s\d{4,5}-\d{4}$/;
            if (!telefoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Telefone inválido';
            }
        }

        // Aplicar estilos visuais
        if (isValid) {
            field.classList.remove('field-error');
            field.classList.add('field-success');
        } else {
            field.classList.remove('field-success');
            field.classList.add('field-error');
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    showFieldError(field, message) {
        const errorElement = document.createElement('span');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        field.parentNode.appendChild(errorElement);
    }

    clearFieldError(field) {
        field.classList.remove('field-error', 'field-success');
        const errorMessage = field.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }

    validateCheckoutForm(event) {
        const form = event.target;
        const fields = form.querySelectorAll('input[required], select[required]');
        let isFormValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            event.preventDefault();
            this.showNotification('Por favor, corrija os erros no formulário', 'error');
            
            // Focar no primeiro campo com erro
            const firstError = form.querySelector('.field-error');
            if (firstError) {
                firstError.focus();
            }
        } else {
            // Mostrar loading no botão de submit
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.classList.add('loading');
                submitButton.disabled = true;
            }
        }
    }

    // === GALERIA DE IMAGENS ===

    changeMainImage(thumbnail) {
        const mainImage = document.getElementById('mainProductImage');
        const newSrc = thumbnail.querySelector('img').src;
        
        if (mainImage && newSrc) {
            // Remover classe ativa de todas as thumbnails
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Adicionar classe ativa na thumbnail clicada
            thumbnail.classList.add('active');
            
            // Trocar imagem principal com efeito
            mainImage.style.opacity = '0.5';
            
            setTimeout(() => {
                mainImage.src = newSrc;
                mainImage.style.opacity = '1';
            }, 150);
        }
    }

    // === BUSCA ===

    handleSearch(event) {
        const searchInput = event.target.querySelector('input[name="q"]');
        const query = searchInput.value.trim();
        
        if (!query) {
            event.preventDefault();
            this.showNotification('Digite algo para buscar', 'warning');
            searchInput.focus();
        }
    }

    // === CAROUSELS ===

    initializeCarousels() {
        // Implementação simples de carousel se necessário
        const carousels = document.querySelectorAll('.products-carousel');
        carousels.forEach(carousel => {
            // Adicionar funcionalidade de carousel se necessário
        });
    }

    // === LAZY LOADING ===

    initializeLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback para navegadores sem suporte
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        }
    }

    // === TOOLTIPS ===

    initializeTooltips() {
        // Implementação simples de tooltips
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', this.showTooltip.bind(this));
            element.addEventListener('mouseleave', this.hideTooltip.bind(this));
        });
    }

    showTooltip(event) {
        const element = event.target;
        const text = element.getAttribute('data-tooltip');
        
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = text;
        tooltip.style.cssText = `
            position: absolute;
            background: var(--text-dark);
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            z-index: 1000;
            white-space: nowrap;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
        tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
        
        element._tooltip = tooltip;
    }

    hideTooltip(event) {
        const element = event.target;
        if (element._tooltip) {
            element._tooltip.remove();
            delete element._tooltip;
        }
    }

    // === MODALS ===

    initializeModals() {
        // Implementação simples de modals se necessário
    }

    // === NOTIFICAÇÕES ===

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${this.getNotificationColor(type)};
            color: white;
            padding: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            z-index: 9999;
            max-width: 300px;
            animation: slideInRight 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        // Auto remover após alguns segundos
        setTimeout(() => {
            this.hideNotification(notification);
        }, CONFIG.NOTIFICATION_DURATION);
        
        // Fechar ao clicar no X
        notification.querySelector('.notification-close').addEventListener('click', () => {
            this.hideNotification(notification);
        });
    }

    hideNotification(notification) {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-triangle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || icons.info;
    }

    getNotificationColor(type) {
        const colors = {
            success: 'var(--success)',
            error: 'var(--danger)',
            warning: 'var(--warning)',
            info: 'var(--primary-color)'
        };
        return colors[type] || colors.info;
    }

    // === LOADING ===

    showLoading() {
        const loader = document.createElement('div');
        loader.id = 'globalLoader';
        loader.innerHTML = `
            <div class="loader-backdrop">
                <div class="loader-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </div>
        `;
        
        loader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9998;
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            .loader-backdrop {
                background: rgba(0, 0, 0, 0.5);
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .loader-spinner {
                background: white;
                padding: 2rem;
                border-radius: var(--border-radius);
                font-size: 2rem;
                color: var(--primary-color);
            }
        `;
        
        if (!document.querySelector('#loaderStyles')) {
            style.id = 'loaderStyles';
            document.head.appendChild(style);
        }
        
        document.body.appendChild(loader);
    }

    hideLoading() {
        const loader = document.getElementById('globalLoader');
        if (loader) {
            loader.remove();
        }
    }

    // === ANIMAÇÕES ===

    animateCartButton() {
        const cartBtn = document.querySelector('.cart-btn');
        if (cartBtn) {
            cartBtn.classList.add('animate-pulse');
            setTimeout(() => cartBtn.classList.remove('animate-pulse'), 600);
        }
    }

    // === UTILITÁRIOS ===

    updateCartTotals() {
        // Atualizar totais na página do carrinho se necessário
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    // Adicionar animações CSS dinâmicas
    addDynamicStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.25rem;
                cursor: pointer;
                margin-left: auto;
            }
        `;
        document.head.appendChild(style);
    }
}

// Funções globais para compatibilidade com o HTML
function addToCart(productId, quantity = 1) {
    if (window.vitaToppApp) {
        window.vitaToppApp.addToCart(productId, quantity);
    }
}

function addToCartWithQuantity(productId) {
    if (window.vitaToppApp) {
        window.vitaToppApp.addToCartWithQuantity(productId);
    }
}

function removeFromCart(productId) {
    if (window.vitaToppApp) {
        window.vitaToppApp.removeFromCart(productId);
    }
}

function updateQuantity(productId, quantity) {
    if (window.vitaToppApp) {
        window.vitaToppApp.updateQuantity(productId, quantity);
    }
}

// Inicializar aplicação quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.vitaToppApp = new VitaToppApp();
    window.vitaToppApp.addDynamicStyles();
});

// Atualizar contador do carrinho periodicamente
setInterval(() => {
    if (window.vitaToppApp) {
        window.vitaToppApp.updateCartCount();
    }
}, 30000);

// Navegação suave para âncoras
document.addEventListener('click', (e) => {
    if (e.target.tagName === 'A' && e.target.getAttribute('href')?.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// Lazy loading para imagens quando o navegador não suporta IntersectionObserver
if (!('IntersectionObserver' in window)) {
    document.addEventListener('scroll', () => {
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            if (img.getBoundingClientRect().top < window.innerHeight) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });
    });
}