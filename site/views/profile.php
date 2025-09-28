<?php
// Профили - Profile management view
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Профили</h2>
            <button class="btn btn-outline-secondary">Добавить комментарий</button>
        </div>
    </div>
</div>

<!-- Profile Search -->
<div class="row mb-4">
    <div class="col-12">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" placeholder="Поиск профилей">
        </div>
    </div>
</div>

<!-- Profile Card -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">Профиль Nichik Denis Nichik</h5>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4">Фамилия:</dt>
                                        <dd class="col-sm-8">Nichik</dd>
                                        
                                        <dt class="col-sm-4">Имя:</dt>
                                        <dd class="col-sm-8">Denis</dd>
                                        
                                        <dt class="col-sm-4">Отчество:</dt>
                                        <dd class="col-sm-8">М.</dd>
                                        
                                        <dt class="col-sm-4">Фамилия (на русском):</dt>
                                        <dd class="col-sm-8">Ничик</dd>
                                        
                                        <dt class="col-sm-4">Имя (на русском):</dt>
                                        <dd class="col-sm-8">Денис</dd>
                                        
                                        <dt class="col-sm-4">Отчество (на русском):</dt>
                                        <dd class="col-sm-8">Михайлович</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4">Дата Рождения:</dt>
                                        <dd class="col-sm-8">10.05.1988</dd>
                                        
                                        <dt class="col-sm-4">Email:</dt>
                                        <dd class="col-sm-8">dennichik@gmail.com</dd>
                                        
                                        <dt class="col-sm-4">Телефон:</dt>
                                        <dd class="col-sm-8">+79620102491</dd>
                                        
                                        <dt class="col-sm-4">Почтовый индекс:</dt>
                                        <dd class="col-sm-8">-</dd>
                                        
                                        <dt class="col-sm-4">Область / Край:</dt>
                                        <dd class="col-sm-8">А</dd>
                                        
                                        <dt class="col-sm-4">Адрес:</dt>
                                        <dd class="col-sm-8">-</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> Редактировать
                        </button>
                    </div>
                </div>
                
                <!-- Passport Information -->
                <div class="mt-4 pt-4 border-top">
                    <h6 class="mb-3">Паспортные данные</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Серия паспорта:</dt>
                                <dd class="col-sm-8">-</dd>
                                
                                <dt class="col-sm-4">Номер:</dt>
                                <dd class="col-sm-8">-</dd>
                                
                                <dt class="col-sm-4">Орган, выдавший паспорт:</dt>
                                <dd class="col-sm-8">-</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Дата выдачи:</dt>
                                <dd class="col-sm-8">09.12.2008</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-4 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-danger">Удалить профиль</button>
                        <div class="text-muted small">
                            Последнее обновление: 15 минут назад
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Profile -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-dashed">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
                <h5>Добавить новый профиль</h5>
                <p class="text-muted">Создайте дополнительный профиль для регистрации доменов</p>
                <button class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Создать профиль
                </button>
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

<style>
.border-dashed {
    border: 2px dashed #dee2e6 !important;
}
</style>