<?php
require __DIR__ . '/conexion.php';
$resultado = $conexion->query("SELECT m.descripcion AS materia,COUNT(am.id_alumno) AS alumnos_asignados FROM materias m LEFT JOIN asignacion_materia am ON am.id_materia=m.id_materia GROUP BY m.id_materia,m.descripcion ORDER BY m.descripcion");
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><title>SAE | Lista de materias</title></head>
<body style="background-color:#e8f8f5">
<h1>Salida: lista de materias</h1>
<nav><a href="entrada_alumno.php">Alumno</a> | <a href="entrada_grupo.php">Grupo</a> | <a href="entrada_materia.php">Materia</a> | <a href="entrada_profesor.php">Profesor</a> | <a href="proceso_asignar_grupo.php">Asignar grupo</a> | <a href="proceso_asignar_materia.php">Asignar materia</a> | <a href="salida_alumnos.php">Lista de alumnos</a> | <a href="salida_materias.php">Lista de materias</a> | <a href="salida_grupos.php">Lista de grupos</a> | <a href="salida_grupos_asignados.php">Grupos asignados</a> | <a href="salida_boleta.php">Materias asignadas</a> | <a href="salida_alumnos_baja.php">Alumnos de baja</a></nav><hr>
<?php if ($resultado->num_rows === 0): ?>
<p>Sin registros por ahora.</p>
<?php else: ?>
<table border="1" cellpadding="6"><thead><tr>
<?php foreach ($resultado->fetch_fields() as $campo): ?><th><?= h(str_replace('_', ' ', ucfirst($campo->name))) ?></th><?php endforeach; ?>
</tr></thead><tbody>
<?php while ($fila = $resultado->fetch_assoc()): ?><tr><?php foreach ($fila as $valor): ?><td><?= h($valor) ?></td><?php endforeach; ?></tr><?php endwhile; ?>
</tbody></table>
<?php endif; ?>
</body></html>
