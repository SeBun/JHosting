/**
 * Hosting Component JavaScript
 * @package     com_hosting
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

(function() {
    'use strict';

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeHostingComponent();
    });

    /**
     * Initialize hosting component functionality
     */
    function initializeHostingComponent() {
        initializeBalanceTopup();
        initializeServiceManagement();
        initializeTransactionFilters();
        initializeTicketForm();
        initializeProfileForms();
        initializeSettingsToggles();
        initializeNPSSurvey();
    }

    /**
     * Initialize balance top-up functionality
     */
    function initializeBalanceTopup() {
        const topupButtons = document.querySelectorAll('[data-action="topup-balance"]');
        
        topupButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                showTopupModal();
            });
        });
    }

    /**
     * Show balance top-up modal
     */
    function showTopupModal() {
        // Create modal HTML
        const modalHTML = `
            <div class="modal fade" id="topupModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Пополнить баланс</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="topupForm">
                                <div class="mb-3">
                                    <label for="topupAmount" class="form-label">Сумма пополнения</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="topupAmount" min="100" step="1" required>
                                        <span class="input-group-text">₽</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Способ оплаты</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="robokassa" value="robokassa" checked>
                                        <label class="form-check-label" for="robokassa">
                                            Банковская карта (Robokassa)
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-warning" onclick="processTopup()">Пополнить</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to page
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('topupModal'));
        modal.show();

        // Remove modal from DOM when hidden
        document.getElementById('topupModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    /**
     * Process balance top-up
     */
    window.processTopup = function() {
        const amount = document.getElementById('topupAmount').value;
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (!amount || amount < 100) {
            alert('Минимальная сумма пополнения: 100 рублей');
            return;
        }

        // Show loading state
        const button = document.querySelector('#topupModal .btn-warning');
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Обработка...';
        button.disabled = true;

        // Send request to create payment
        fetch('index.php?option=com_hosting&task=payment.create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                amount: amount,
                payment_method: paymentMethod
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to payment gateway
                window.location.href = data.payment_url;
            } else {
                alert('Ошибка создания платежа: ' + data.message);
                button.innerHTML = 'Пополнить';
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при создании платежа');
            button.innerHTML = 'Пополнить';
            button.disabled = false;
        });
    };

    /**
     * Initialize service management
     */
    function initializeServiceManagement() {
        const serviceActions = document.querySelectorAll('[data-action^="service-"]');
        
        serviceActions.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.dataset.action;
                const serviceId = this.dataset.serviceId;
                
                handleServiceAction(action, serviceId);
            });
        });
    }

    /**
     * Handle service actions
     */
    function handleServiceAction(action, serviceId) {
        const actions = {
            'service-suspend': 'Приостановить услугу',
            'service-resume': 'Возобновить услугу',
            'service-renew': 'Продлить услугу'
        };

        if (confirm(`Вы уверены, что хотите выполнить действие: ${actions[action]}?`)) {
            fetch(`index.php?option=com_hosting&task=service.${action.replace('service-', '')}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    service_id: serviceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Ошибка: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при выполнении действия');
            });
        }
    }

    /**
     * Initialize transaction filters
     */
    function initializeTransactionFilters() {
        const filterButtons = document.querySelectorAll('[name="txnType"]');
        
        filterButtons.forEach(button => {
            button.addEventListener('change', function() {
                filterTransactions(this.value);
            });
        });

        const searchInput = document.querySelector('[data-search="transactions"]');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchTransactions(this.value);
                }, 300);
            });
        }
    }

    /**
     * Filter transactions by type
     */
    function filterTransactions(type) {
        const rows = document.querySelectorAll('[data-transaction-type]');
        
        rows.forEach(row => {
            if (type === 'all' || row.dataset.transactionType === type) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    /**
     * Search transactions
     */
    function searchTransactions(query) {
        const rows = document.querySelectorAll('[data-transaction-description]');
        
        rows.forEach(row => {
            const description = row.dataset.transactionDescription.toLowerCase();
            if (description.includes(query.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    /**
     * Initialize ticket form
     */
    function initializeTicketForm() {
        const ticketForm = document.getElementById('ticketForm');
        if (ticketForm) {
            ticketForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitTicket();
            });
        }
    }

    /**
     * Submit support ticket
     */
    function submitTicket() {
        const form = document.getElementById('ticketForm');
        const formData = new FormData(form);

        fetch('index.php?option=com_hosting&task=ticket.create', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Обращение успешно отправлено');
                form.reset();
            } else {
                alert('Ошибка отправки обращения: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при отправке обращения');
        });
    }

    /**
     * Initialize profile forms
     */
    function initializeProfileForms() {
        const editButtons = document.querySelectorAll('[data-action="edit-profile"]');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const field = this.dataset.field;
                toggleFieldEdit(field);
            });
        });
    }

    /**
     * Toggle field edit mode
     */
    function toggleFieldEdit(field) {
        const input = document.querySelector(`[data-field="${field}"]`);
        const button = document.querySelector(`[data-action="edit-profile"][data-field="${field}"]`);
        
        if (input.hasAttribute('readonly')) {
            input.removeAttribute('readonly');
            input.focus();
            button.innerHTML = '<i class="fas fa-save"></i>';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');
        } else {
            saveProfileField(field, input.value);
        }
    }

    /**
     * Save profile field
     */
    function saveProfileField(field, value) {
        fetch('index.php?option=com_hosting&task=profile.save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                field: field,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const input = document.querySelector(`[data-field="${field}"]`);
                const button = document.querySelector(`[data-action="edit-profile"][data-field="${field}"]`);
                
                input.setAttribute('readonly', true);
                button.innerHTML = '<i class="fas fa-edit"></i>';
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            } else {
                alert('Ошибка сохранения: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при сохранении');
        });
    }

    /**
     * Initialize settings toggles
     */
    function initializeSettingsToggles() {
        const toggles = document.querySelectorAll('[data-setting-toggle]');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const setting = this.dataset.settingToggle;
                const value = this.checked;
                saveSettingToggle(setting, value);
            });
        });
    }

    /**
     * Save setting toggle
     */
    function saveSettingToggle(setting, value) {
        fetch('index.php?option=com_hosting&task=settings.toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                setting: setting,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Ошибка сохранения настройки: ' + data.message);
                // Revert toggle state
                const toggle = document.querySelector(`[data-setting-toggle="${setting}"]`);
                toggle.checked = !value;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при сохранении настройки');
        });
    }

    /**
     * Initialize NPS survey
     */
    function initializeNPSSurvey() {
        const npsButtons = document.querySelectorAll('[name="nps"]');
        
        npsButtons.forEach(button => {
            button.addEventListener('change', function() {
                submitNPSScore(this.value);
            });
        });
    }

    /**
     * Submit NPS score
     */
    function submitNPSScore(score) {
        fetch('index.php?option=com_hosting&task=nps.submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                score: score
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide NPS survey after submission
                const survey = document.querySelector('.nps-survey');
                if (survey) {
                    survey.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    /**
     * Utility function to format currency
     */
    window.formatCurrency = function(amount, currency = 'RUB') {
        const formatter = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 2
        });
        return formatter.format(amount);
    };

    /**
     * Utility function to format date
     */
    window.formatDate = function(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        };
        
        const formatter = new Intl.DateTimeFormat('ru-RU', { ...defaultOptions, ...options });
        return formatter.format(new Date(date));
    };

})();