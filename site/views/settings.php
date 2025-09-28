<?php
// Настройки - Settings view
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Настройки</h2>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Account Owner -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Владелец аккаунта</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="Иван Селезнев" readonly>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Электронная почта</label>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" value="troff@bk.ru" readonly>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Phone -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Номер телефона</label>
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="form-control" value="+79197346237" readonly>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Подписки</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Управление подписками" readonly>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <!-- Password -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Пароль</label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="password" class="form-control" value="••••••••" readonly>
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">Изменить</button>
                    </div>
                </div>

                <!-- Plan -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Тариф</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="Личный" readonly>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Settings -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Настройки безопасности</h5>
            </div>
            <div class="card-body">
                <!-- SMS Login -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>Вход по SMS-коду</strong>
                        <div class="text-muted small">Дополнительная защита входа в аккаунт</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="smsLogin" checked>
                        <label class="form-check-label" for="smsLogin">Включено</label>
                    </div>
                </div>

                <!-- Email Confirmation -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>Вход с подтверждением по Email</strong>
                        <div class="text-muted small">Подтверждение входа через электронную почту</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="emailConfirm" checked>
                        <label class="form-check-label" for="emailConfirm">Включено</label>
                    </div>
                </div>

                <!-- Session Binding -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>Привязка сессии к IP-адресу</strong>
                        <div class="text-muted small">Автоматический выход при смене IP</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="ipBinding" checked>
                        <label class="form-check-label" for="ipBinding">Включено</label>
                    </div>
                </div>

                <!-- 2FA -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>Кодовое слово и вопрос</strong>
                        <div class="text-muted small">Дополнительная проверка личности</div>
                    </div>
                    <div>
                        <span class="badge bg-success">Настроено</span>
                    </div>
                </div>

                <!-- IP Restrictions -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Ограничение входа по IP</strong>
                        <div class="text-muted small">Разрешить вход только с определенных IP</div>
                    </div>
                    <div>
                        <span class="badge bg-danger">Выключено</span>
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