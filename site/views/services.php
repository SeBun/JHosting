<?php
// Мои услуги - Services view
?>

<div class="row mb-4">
    <div class="col-12">
        <!-- NPS Survey Banner -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <strong>Оцените по шкале от 0 до 10, насколько вы готовы рекомендовать 2DOMAINS другу или коллеге</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <div class="mt-3">
                <div class="btn-group" role="group">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <input type="radio" class="btn-check" name="nps" id="nps<?= $i ?>" value="<?= $i ?>">
                        <label class="btn btn-outline-primary btn-sm" for="nps<?= $i ?>"><?= $i ?></label>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Мои услуги</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="me-3">
                <span class="text-muted">0 услуг приостановлено</span><br>
                <span class="text-muted">0 услуг заканчивается</span>
            </div>
            <div>
                <span class="badge bg-primary">1</span>
            </div>
        </div>
    </div>
</div>

<!-- Services Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-tabs" id="servicesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                    Все <span class="badge bg-warning ms-1">1</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="domains-tab" data-bs-toggle="tab" data-bs-target="#domains" type="button" role="tab">
                    Домены <span class="badge bg-secondary ms-1">1</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hosting-tab" data-bs-toggle="tab" data-bs-target="#hosting" type="button" role="tab">
                    Хостинг
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ssl-tab" data-bs-toggle="tab" data-bs-target="#ssl" type="button" role="tab">
                    SSL
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sites-tab" data-bs-toggle="tab" data-bs-target="#sites" type="button" role="tab">
                    Сайты
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab">
                    Другие
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Services Search -->
<div class="row mb-3">
    <div class="col-md-8">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" placeholder="Поиск по услугам">
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <button class="btn btn-outline-secondary">
                <i class="fas fa-filter"></i>
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fas fa-cog"></i>
            </button>
        </div>
    </div>
</div>

<!-- Services List -->
<div class="tab-content" id="servicesTabContent">
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service1">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <i class="fas fa-globe fa-2x text-primary"></i>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <strong>vintehnikum.ru</strong>
                            <div class="text-muted small">ns1.rameva.ru</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span class="badge bg-danger">Требует продления</span>
                    </div>
                    <div class="col-md-2">
                        <div class="text-danger">
                            <strong>до 04.12.2024</strong>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm">Управление</button>
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Редактировать</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Продлить</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-exchange-alt me-2"></i>Трансфер</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-pause me-2"></i>Приостановить</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Service -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-dashed">
            <div class="card-body text-center py-5">
                <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                <h5>Заказать новую услугу</h5>
                <p class="text-muted">Выберите нужную услугу и оформите заказ</p>
                <div class="btn-group">
                    <button class="btn btn-primary">Домен</button>
                    <button class="btn btn-outline-primary">Хостинг</button>
                    <button class="btn btn-outline-primary">VPS</button>
                    <button class="btn btn-outline-primary">SSL</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-dashed {
    border: 2px dashed #dee2e6 !important;
}
.nav-tabs .nav-link {
    color: #6c757d;
}
.nav-tabs .nav-link.active {
    color: #495057;
    font-weight: 500;
}
</style>