<?php
// Связаться с нами - Support tickets view
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Связаться с нами</h2>
    </div>
</div>

<!-- Contact Methods -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="text-primary mb-3">
                    <i class="fas fa-envelope fa-3x"></i>
                </div>
                <h5 class="card-title">Email поддержка</h5>
                <p class="card-text text-muted">Отправьте нам письмо с вашим вопросом</p>
                <a href="mailto:support@rameva.ru" class="btn btn-primary">
                    support@rameva.ru
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="text-success mb-3">
                    <i class="fab fa-telegram fa-3x"></i>
                </div>
                <h5 class="card-title">Telegram</h5>
                <p class="card-text text-muted">Быстрые ответы в мессенджере</p>
                <a href="https://t.me/rameva_support" target="_blank" class="btn btn-success">
                    @rameva_support
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Contact Form -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Новое обращение</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ticketSubject" class="form-label">Тема обращения *</label>
                            <input type="text" class="form-control" id="ticketSubject" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ticketPriority" class="form-label">Приоритет</label>
                            <select class="form-select" id="ticketPriority">
                                <option value="low">Низкий</option>
                                <option value="normal" selected>Обычный</option>
                                <option value="high">Высокий</option>
                                <option value="urgent">Срочный</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ticketCategory" class="form-label">Категория</label>
                            <select class="form-select" id="ticketCategory">
                                <option value="">Выберите категорию</option>
                                <option value="technical">Техническая поддержка</option>
                                <option value="billing">Вопросы по оплате</option>
                                <option value="domain">Домены</option>
                                <option value="hosting">Хостинг</option>
                                <option value="vps">VPS/VDS</option>
                                <option value="ssl">SSL сертификаты</option>
                                <option value="other">Другое</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ticketService" class="form-label">Связанная услуга</label>
                            <select class="form-select" id="ticketService">
                                <option value="">Не связано с услугой</option>
                                <option value="1">vintehnikum.ru</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="ticketMessage" class="form-label">Сообщение *</label>
                        <textarea class="form-control" id="ticketMessage" rows="6" 
                                  placeholder="Опишите вашу проблему или вопрос подробно..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="ticketAttachment" class="form-label">Прикрепить файлы</label>
                        <input type="file" class="form-control" id="ticketAttachment" multiple 
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                        <div class="form-text">Максимальный размер файла: 10 МБ. Разрешенные форматы: JPG, PNG, PDF, DOC, TXT, ZIP</div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="emailNotification" checked>
                            <label class="form-check-label" for="emailNotification">
                                Уведомлять об ответах на email
                            </label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2">Сохранить черновик</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Отправить обращение
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Previous Tickets -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Мои обращения</h5>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="ticketFilter" id="filterAll" checked>
                        <label class="btn btn-outline-primary btn-sm" for="filterAll">Все</label>
                        
                        <input type="radio" class="btn-check" name="ticketFilter" id="filterOpen">
                        <label class="btn btn-outline-primary btn-sm" for="filterOpen">Открытые</label>
                        
                        <input type="radio" class="btn-check" name="ticketFilter" id="filterClosed">
                        <label class="btn btn-outline-primary btn-sm" for="filterClosed">Закрытые</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <h5>У вас пока нет обращений</h5>
                    <p>Когда вы создадите обращение, оно появится здесь</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Часто задаваемые вопросы</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Как продлить домен?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Для продления домена перейдите в раздел "Мои услуги", найдите нужный домен и нажмите кнопку "Продлить".
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Как пополнить баланс?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                В разделе "Баланс" нажмите кнопку "Пополнить баланс" и выберите удобный способ оплаты.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Время ответа службы поддержки
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Мы отвечаем на обращения в течение 24 часов в рабочие дни. В срочных случаях обращайтесь в Telegram.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copyright -->
<div class="row mt-4">
    <div class="col-12 text-center">
        <small class="text-muted">© 2domains.ru, 2024</small>
    </div>
</div>