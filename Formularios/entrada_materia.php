<?php
require __DIR__ . '/conexion.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $descripcion = trim($_POST['descripcion'] ?? '');
        if ($descripcion === '') throw new RuntimeException('Faltan datos obligatorios.');
        $s = $conexion->prepare('INSERT INTO materias (descripcion) VALUES (?)');
        $s->bind_param('s', $descripcion);
        $s->execute();
        $mensaje = 'Materia registrado correctamente.';
    } catch (Throwable $e) {
        $mensaje = 'No se guardó. Revisa los datos y que no exista un registro repetido.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><title>SAE | Materia</title></head>
<body style="background-color:#eaf2f8">
<h1>Entrada: materia</h1>
<nav><a href="entrada_alumno.php">Alumno</a> | <a href="entrada_grupo.php">Grupo</a> | <a href="entrada_materia.php">Materia</a> | <a href="entrada_profesor.php">Profesor</a> | <a href="proceso_asignar_grupo.php">Asignar grupo</a> | <a href="proceso_asignar_materia.php">Asignar materia</a> | <a href="salida_alumnos.php">Lista de alumnos</a> | <a href="salida_materias.php">Lista de materias</a> | <a href="salida_grupos.php">Lista de grupos</a> | <a href="salida_grupos_asignados.php">Grupos asignados</a> | <a href="salida_boleta.php">Materias asignadas</a> | <a href="salida_alumnos_baja.php">Alumnos de baja</a></nav>
<p><?= h($mensaje) ?></p><hr>
<h2>Registrar materia</h2><form method="post">
<label>Descripción <input name="descripcion" maxlength="100" required></label>
<button>Guardar materia</button></form></body></html>
