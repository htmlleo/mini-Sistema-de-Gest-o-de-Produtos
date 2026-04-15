<?php
/**
 * Página de Login e Registro.
 *
 * Desenvolvido por Leonardo Estevão Alves — RA: 00250458-1
 */

require_once 'classes/Database.php';
require_once 'classes/User.php';

if (User::isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($user->login($email, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'E-mail ou senha incorretos.';
        }
    } elseif ($action === 'register') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($name && $email && $password) {
            if ($user->register($name, $email, $password)) {
                $success = 'Usuário cadastrado com sucesso! Faça login.';
            } else {
                $error = 'Erro ao cadastrar usuário. E-mail já existe?';
            }
        } else {
            $error = 'Preencha todos os campos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistema de Gestão</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="login-container">
        <h2 class="login-title">Sistema de Gestão</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Cadastro</button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="tab-pane fade" id="register" role="tabpanel">
                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
