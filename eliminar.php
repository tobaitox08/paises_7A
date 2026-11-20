<?php
require_once __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$pais_id = (int) ($_POST['pais_id'] ?? 0);

if ($pais_id > 0) {
    $stmt = db()->prepare('DELETE FROM paises WHERE pais_id = ?');
    $stmt->execute([$pais_id]);
}

redirect('index.php?msg=eliminado');
