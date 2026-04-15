<?php
/**
 * Dashboard Principal — Área Logada.
 * Organizado em 4 Áreas conforme solicitado no trabalho acadêmico.
 *
 * Desenvolvido por Leonardo Estevão Alves — RA: 00250458-1
 */

require_once 'classes/Database.php';
require_once 'classes/User.php';

if (!User::isAuthenticated()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistema de Gestão</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-box-seam me-2"></i>Gestão ERP</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-inline">Olá, <strong><?= $_SESSION['user_name'] ?></strong> (RA: 00250458-1)</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Sair</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    
    <!-- Alert Container -->
    <div id="alert-container"></div>

    <div class="row g-4">
        
        <!-- ÁREA 1: CADASTRO (Produtos e Fornecedores) -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white fw-bold"><i class="bi bi-plus-circle me-2 text-primary"></i>ÁREA 1: CADASTRO</div>
                <div class="card-body">
                    <h6 class="text-muted mb-3">Cadastrar Fornecedor</h6>
                    <form id="form-supplier" class="mb-4">
                        <div class="row g-2">
                            <div class="col-7">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome do Fornecedor" required>
                            </div>
                            <div class="col-5">
                                <input type="text" name="contact" class="form-control form-control-sm" placeholder="Contato" required>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Salvar Fornecedor</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <h6 class="text-muted mb-3">Cadastrar Produto</h6>
                    <form id="form-product">
                        <div class="row g-2">
                            <div class="col-8">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome do Produto" required>
                            </div>
                            <div class="col-4">
                                <input type="number" step="0.01" name="price" class="form-control form-control-sm" placeholder="Preço R$" required>
                            </div>
                            <div class="col-12 mt-2">
                                <select name="supplier_id" id="product-supplier-id" class="form-select form-select-sm" required>
                                    <option value="">Selecione um fornecedor</option>
                                    <!-- AJAX Load -->
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Salvar Produto</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ÁREA 2: AJAX (Listagem de Dados) -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white fw-bold"><i class="bi bi-arrow-repeat me-2 text-primary"></i>ÁREA 2: ATUALIZAÇÃO AJAX</div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill" id="ajaxTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active py-2 small" id="prod-tab" data-bs-toggle="tab" data-bs-target="#prod-list" type="button">Produtos</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-2 small" id="supp-tab" data-bs-toggle="tab" data-bs-target="#supp-list" type="button">Fornecedores</button>
                        </li>
                    </ul>
                    <div class="tab-content p-2">
                        <div class="tab-pane fade show active" id="prod-list">
                            <div class="table-responsive" style="max-height: 250px;">
                                <table class="table table-sm table-hover small">
                                    <thead><tr><th>Nome</th><th>Preço</th><th>Fornecedor</th></tr></thead>
                                    <tbody id="ajax-products-list"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="supp-list">
                            <div class="table-responsive" style="max-height: 250px;">
                                <table class="table table-sm table-hover small">
                                    <thead><tr><th>Nome</th><th>Contato</th></tr></thead>
                                    <tbody id="ajax-suppliers-list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-center py-1">
                    <small class="text-muted">Dados atualizados via AJAX automaticamente</small>
                </div>
            </div>
        </div>

        <!-- ÁREA 3: SELEÇÃO (Checkbox e Inclusão na Cesta) -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check2-square me-2 text-primary"></i>ÁREA 3: SELEÇÃO DE PRODUTOS</span>
                    <button class="btn btn-success btn-sm" id="btn-add-to-cart">
                        <i class="bi bi-cart-plus me-1"></i>Incluir na Cesta
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40" class="text-center">#</th>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                    <th>Fornecedor</th>
                                </tr>
                            </thead>
                            <tbody id="selection-products-list">
                                <!-- AJAX Load -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ÁREA 4: CESTA (Exibição e Resumo) -->
        <div class="col-md-12">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cart3 me-2"></i>ÁREA 4: CESTA DE COMPRAS (RESUMO)</span>
                    <button class="btn btn-light btn-sm text-danger fw-bold" id="btn-clear-cart">Limpar Cesta</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead><tr><th>Produto</th><th>Preço</th><th>Fornecedor</th><th width="50"></th></tr></thead>
                                    <tbody id="cart-items-list"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded border">
                                <h5 class="mb-3 border-bottom pb-2">Resumo do Pedido</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Produtos Selecionados:</span>
                                    <strong id="cart-total-items">0</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Valor Total:</span>
                                    <strong class="text-primary fs-4" id="cart-total-value">R$ 0,00</strong>
                                </div>
                                <button class="btn btn-primary w-100 fw-bold" id="btn-finalize-sale">Finalizar Compra</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="bg-white border-top py-3 mt-5">
    <div class="container text-center">
        <p class="mb-0 text-muted small">Desenvolvido por <strong>Leonardo Estevão Alves</strong> — RA: 00250458-1</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
