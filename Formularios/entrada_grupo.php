<?php
require __DIR__ . '/conexion.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estatus = trim($_POST['estatus'] ?? '');
        if ($descripcion === '' || !in_array($estatus, ['ACTIVO','INACTIVO'], true)) throw new RuntimeException('Faltan datos obligatorios.');
        $s = $conexion->prepare('INSERT INTO grupos (descripcion,estatus) VALUES (?,?)');
        $s->bind_param('ss', $descripcion, $estatus);
        $s->execute();
        $mensaje = 'Grupo registrado correctamente.';
    } catch (Throwable $e) {
        $mensaje = 'No se guardó. Revisa los datos y que no exista un registro repetido.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><title>SAE | Grupo</title></head>
<body style="background-color:#eaf2f8">
<h1>Entrada: grupo</h1>
<nav><a href="entrada_alumno.php">Alumno</a> | <a href="entrada_grupo.php">Grupo</a> | <a href="entrada_materia.php">Materia</a> | <a href="entrada_profesor.php">Profesor</a> | <a href="proceso_asignar_grupo.php">Asignar grupo</a> | <a href="proceso_asignar_materia.php">Asignar materia</a> | <a href="salida_alumnos.php">Lista de alumnos</a> | <a href="salida_materias.php">Lista de materias</a> | <a href="salida_grupos.php">Lista de grupos</a> | <a href="salida_grupos_asignados.php">Grupos asignados</a> | <a href="salida_boleta.php">Materias asignadas</a> | <a href="salida_alumnos_baja.php">Alumnos de baja</a></nav>
<p><?= h($mensaje) ?></p><hr>
<h2>Registrar grupo</h2><form method="post">
<label>Descripción <input name="descripcion" placeholder="4T1" maxlength="50" required></label>
<label>Estatus <select name="estatus"><option>ACTIVO</option><option>INACTIVO</option></select></label>
<button>Guardar grupo</button></form></body></html>
