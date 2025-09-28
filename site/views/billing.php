<?php
// История - Billing/Transaction history view
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">История</h2>
    </div>
</div>

<!-- Filter Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100">За все время</button>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Найдите операцию по услуге или сумме">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-filter"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Type Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="btn-group w-100" role="group">
            <input type="radio" class="btn-check" name="txnType" id="refills" checked>
            <label class="btn btn-outline-danger" for="refills">
                <i class="fas fa-plus-circle me-1"></i> Пополнения
            </label>
            
            <input type="radio" class="btn-check" name="txnType" id="payments">
            <label class="btn btn-outline-danger" for="payments">
                <i class="fas fa-credit-card me-1"></i> Оплаты
            </label>
            
            <input type="radio" class="btn-check" name="txnType" id="refunds">
            <label class="btn btn-outline-info" for="refunds">
                <i class="fas fa-undo me-1"></i> Возвраты
            </label>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Дата и время</th>
                                <th>Тип операции</th>
                                <th>Сумма</th>
                                <th>Наименование</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>25.11.2024</div>
                                    <small class="text-muted">15:38</small>
                                </td>
                                <td>Оплата</td>
                                <td class="text-danger">-849 ₽</td>
                                <td>Продление vintehnikum.ru</td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-credit-card me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>25.11.2024</div>
                                    <small class="text-muted">15:38</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+849 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>25.11.2023</div>
                                    <small class="text-muted">15:43</small>
                                </td>
                                <td>Оплата</td>
                                <td class="text-danger">-799 ₽</td>
                                <td>Продление vintehnikum.ru</td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-credit-card me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>25.11.2023</div>
                                    <small class="text-muted">15:44</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+799 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>05.12.2022</div>
                                    <small class="text-muted">10:29</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+799 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>06.12.2021</div>
                                    <small class="text-muted">23:03</small>
                                </td>
                                <td>Оплата</td>
                                <td class="text-danger">-799 ₽</td>
                                <td>Продление vintehnikum.ru</td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-university me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>06.12.2021</div>
                                    <small class="text-muted">23:03</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+799 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>03.12.2020</div>
                                    <small class="text-muted">10:43</small>
                                </td>
                                <td>Оплата</td>
                                <td class="text-danger">-799 ₽</td>
                                <td>Продление vintehnikum.ru</td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-university me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>03.12.2020</div>
                                    <small class="text-muted">10:43</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+799 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>05.12.2019</div>
                                    <small class="text-muted">23:05</small>
                                </td>
                                <td>Оплата</td>
                                <td class="text-danger">-799 ₽</td>
                                <td>Продление vintehnikum.ru</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-wallet me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>05.12.2019</div>
                                    <small class="text-muted">23:05</small>
                                </td>
                                <td>Пополнение</td>
                                <td class="text-success">+799 ₽</td>
                                <td>Оплата</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> Оплата
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Показано 1-10 из 12 записей
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <span class="page-link">Предыдущая</span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Следующая</a>
                            </li>
                        </ul>
                    </nav>
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