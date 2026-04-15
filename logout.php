<?php
/**
 * Lógica de Logout.
 *
 * Desenvolvido por Leonardo Estevão Alves — RA: 00250458-1
 */

require_once 'classes/Database.php';
require_once 'classes/User.php';

$user = new User();
$user->logout();

header('Location: index.php');
exit;
