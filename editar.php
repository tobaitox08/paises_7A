<?php
require_once __DIR__ . '/config/db.php';

$pais_id = (int) ($_GET['pais_id'] ?? 0);
$error   = '';

$stmt = db()->prepare('SELECT pais_id, pais_descripcion FROM paises WHERE pais_id = ?');
$stmt->execute([$pais_id]);
$pais = $stmt->fetch();

if (!$pais) {
    http_response_code(404);
    $titulo = 'País no encontrado';
    require __DIR__ . '/includes/header.php';
    ?>
    <div class="alert alert-danger">El país solicitado no existe.</div>
    <a class="btn btn-secondary" href="index.php">Volver al listado</a>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['pais_descripcion'] ?? '');

    if ($nombre === '' || mb_strlen($nombre) > 50) {
        $error = 'Ingresá un nombre de hasta 50 caracteres.';
    } else {
        $stmt = db()->prepare('UPDATE paises SET pais_descripcion = ? WHERE pais_id = ?');
        $stmt->execute([$nombre, $pais_id]);
        redirect('index.php?msg=actualizado');
    }
} else {
    $nombre = $pais['pais_descripcion'];
}

$titulo = 'Editar país';
require __DIR__ . '/includes/header.php';
?>
<h1 class="h3 mb-3">Editar país #<?= (int) $pais['pais_id'] ?></h1>

<?php if ($error !== ''): ?>
  <div class="alert alert-danger" style="max-width: 560px;"><?= e($error) ?></div>
<?php endif; ?>

<form method="post" class="card card-body shadow-sm" style="max-width: 560px;">
  <div class="mb-3">
    <label for="pais_descripcion" class="form-label">Nombre del país</label>
    <input type="text" class="form-control" id="pais_descripcion" name="pais_descripcion"
           maxlength="50" value="<?= e($nombre) ?>" required autofocus>
  </div>
  <div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a class="btn btn-link" href="index.php">Cancelar</a>
  </div>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
