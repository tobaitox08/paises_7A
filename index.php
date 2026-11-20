<?php
require_once __DIR__ . '/config/db.php';

$paises = db()->query(
    'SELECT p.pais_id, p.pais_descripcion, COUNT(pr.pro_id) AS total_provincias
     FROM paises p
     LEFT JOIN provincias pr ON pr.pais_id = p.pais_id
     GROUP BY p.pais_id, p.pais_descripcion
     ORDER BY p.pais_descripcion'
)->fetchAll();

$mensajes = [
    'creado'      => ['success', 'País creado correctamente.'],
    'actualizado' => ['success', 'País actualizado correctamente.'],
    'eliminado'   => ['warning', 'País eliminado junto con sus provincias.'],
];
$msg = is_string($_GET['msg'] ?? null) ? $_GET['msg'] : '';

$titulo = 'Listado de países';
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 mb-0">Países</h1>
  <a class="btn btn-success" href="crear.php">Nuevo país</a>
</div>

<?php if (isset($mensajes[$msg])): ?>
  <div class="alert alert-<?= $mensajes[$msg][0] ?>"><?= e($mensajes[$msg][1]) ?></div>
<?php endif; ?>

<?php if (!$paises): ?>
  <div class="alert alert-info">No hay países cargados.</div>
<?php else: ?>
<table class="table table-striped table-hover align-middle bg-white shadow-sm">
  <thead class="table-primary">
    <tr>
      <th scope="col" style="width: 80px;">ID</th>
      <th scope="col">País</th>
      <th scope="col" class="text-center" style="width: 110px;">Provincias</th>
      <th scope="col" class="text-end" style="width: 280px;">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($paises as $pais): ?>
    <tr>
      <td><?= (int) $pais['pais_id'] ?></td>
      <td><?= e($pais['pais_descripcion']) ?></td>
      <td class="text-center"><?= (int) $pais['total_provincias'] ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-primary" href="provincias.php?pais_id=<?= (int) $pais['pais_id'] ?>">Provincias</a>
        <a class="btn btn-sm btn-outline-secondary" href="editar.php?pais_id=<?= (int) $pais['pais_id'] ?>">Editar</a>
        <form class="d-inline" method="post" action="eliminar.php" onsubmit="return confirm('¿Eliminar este país y sus provincias?');">
          <input type="hidden" name="pais_id" value="<?= (int) $pais['pais_id'] ?>">
          <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
