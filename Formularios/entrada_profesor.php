<?php
require __DIR__ . '/conexion.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $matricula = trim($_POST['matricula'] ?? '');
        $numero_empleado = trim($_POST['numero_empleado'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apaterno = trim($_POST['apaterno'] ?? '');
        $amaterno = trim($_POST['amaterno'] ?? '');
        if ($matricula === '' || $numero_empleado === '' || $nombre === '' || $apaterno === '') throw new RuntimeException('Faltan datos obligatorios.');
        $s = $conexion->prepare('INSERT INTO profesores (matricula,numero_empleado,nombre,apaterno,amaterno) VALUES (?,?,?,?,?)');
        $s->bind_param('sssss', $matricula, $numero_empleado, $nombre, $apaterno, $amaterno);
        $s->execute();
        $mensaje = 'Profesor registrado correctamente.';
    } catch (Throwable $e) {
        $mensaje = 'No se guardó. Revisa los datos y que no exista un registro repetido.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><title>SAE | Profesor</title></head>
<body style="background-color:#eaf2f8">
<h1>Entrada: profesor</h1>
<nav><a href="entrada_alumno.php">Alumno</a> | <a href="entrada_grupo.php">Grupo</a> | <a href="entrada_materia.php">Materia</a> | <a href="entrada_profesor.php">Profesor</a> | <a href="proceso_asignar_grupo.php">Asignar grupo</a> | <a href="proceso_asignar_materia.php">Asignar materia</a> | <a href="salida_alumnos.php">Lista de alumnos</a> | <a href="salida_materias.php">Lista de materias</a> | <a href="salida_grupos.php">Lista de grupos</a> | <a href="salida_grupos_asignados.php">Grupos asignados</a> | <a href="salida_boleta.php">Materias asignadas</a> | <a href="salida_alumnos_baja.php">Alumnos de baja</a></nav>
<p><?= h($mensaje) ?></p><hr>
<h2>Registrar profesor</h2><form method="post">
<label>Matrícula <input name="matricula" maxlength="20" required></label><br><br>
<label>Número de empleado <input name="numero_empleado" maxlength="20" required></label><br><br>
<label>Nombre <input name="nombre" maxlength="60" required></label><br><br>
<label>Apellido paterno <input name="apaterno" maxlength="60" required></label><br><br>
<label>Apellido materno <input name="amaterno" maxlength="60"></label><br><br>
<button>Guardar profesor</button></form>
</body></html>
