<?php
require_once __DIR__ . '/config/db.php';

$pais_id = (int) ($_GET['pais_id'] ?? 0);
$pais    = null;
$provincias = [];

$paises = db()->query('SELECT pais_id, pais_descripcion FROM paises ORDER BY pais_descripcion')->fetchAll();

if ($pais_id > 0) {
    $stmt = db()->prepare('SELECT pais_id, pais_descripcion FROM paises WHERE pais_id = ?');
    $stmt->execute([$pais_id]);
    $pais = $stmt->fetch();

    if ($pais) {
        $stmt = db()->prepare('SELECT pro_id, pro_descripcion FROM provincias WHERE pais_id = ? ORDER BY pro_descripcion');
        $stmt->execute([$pais_id]);
        $provincias = $stmt->fetchAll();
    }
}

$titulo = 'Maestro-detalle de provincias';
require __DIR__ . '/includes/header.php';
?>
<h1 class="h3 mb-3">Provincias por país</h1>

<form method="get" class="card card-body shadow-sm mb-4" style="max-width: 560px;">
  <label for="pais_id" class="form-label">Seleccioná un país</label>
  <div class="d-flex gap-2">
    <select class="form-select" id="pais_id" name="pais_id" required>
      <option value="">-- Elegir país --</option>
      <?php foreach ($paises as $opcion): ?>
        <option value="<?= (int) $opcion['pais_id'] ?>" <?= (int) $opcion['pais_id'] === $pais_id ? 'selected' : '' ?>>
          <?= e($opcion['pais_descripcion']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">Ver provincias</button>
  </div>
</form>

<?php if ($pais_id > 0 && !$pais): ?>
  <div class="alert alert-danger">El país seleccionado no existe.</div>
<?php elseif ($pais): ?>
  <h2 class="h5">
    <?= e($pais['pais_descripcion']) ?>
    <span class="badge bg-secondary"><?= count($provincias) ?> provincias</span>
  </h2>

  <?php if (!$provincias): ?>
    <div class="alert alert-info">Este país no tiene provincias cargadas.</div>
  <?php else: ?>
    <table class="table table-sm table-striped bg-white shadow-sm" style="max-width: 720px;">
      <thead class="table-primary">
        <tr>
          <th scope="col" style="width: 90px;">ID</th>
          <th scope="col">Provincia</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($provincias as $provincia): ?>
        <tr>
          <td><?= (int) $provincia['pro_id'] ?></td>
          <td><?= e($provincia['pro_descripcion']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
<?php elseif ($pais_id === 0): ?>
  <div class="alert alert-info">Elegí un país para ver sus provincias.</div>
<?php endif; ?>

<a class="btn btn-outline-secondary" href="index.php">Volver al listado de países</a>
<?php require __DIR__ . '/includes/footer.php'; ?>
