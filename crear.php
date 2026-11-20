<?php
require_once __DIR__ . '/config/db.php';

$error  = '';
$nombre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['pais_descripcion'] ?? '');

    if ($nombre === '' || mb_strlen($nombre) > 50) {
        $error = 'Ingresá un nombre de hasta 50 caracteres.';
    } else {
        $stmt = db()->prepare('INSERT INTO paises (pais_descripcion) VALUES (?)');
        $stmt->execute([$nombre]);
        redirect('index.php?msg=creado');
    }
}

$titulo = 'Nuevo país';
require __DIR__ . '/includes/header.php';
?>
<h1 class="h3 mb-3">Nuevo país</h1>

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
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-link" href="index.php">Cancelar</a>
  </div>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
