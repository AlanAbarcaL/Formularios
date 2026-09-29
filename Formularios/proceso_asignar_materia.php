<?php
require __DIR__ . '/conexion.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno = filter_input(INPUT_POST, 'alumno', FILTER_VALIDATE_INT);
    $profesor = filter_input(INPUT_POST, 'profesor', FILTER_VALIDATE_INT);
    $destino = filter_input(INPUT_POST, 'destino', FILTER_VALIDATE_INT);
    if (!$alumno || !$profesor || !$destino) {
        $mensaje = 'Selecciona alumno, profesor y materia.';
    } else {
        try {
            $s = $conexion->prepare("INSERT INTO asignacion_materia (id_materia,id_alumno,id_profesor) SELECT t.id_materia,a.id_alumno,p.id_profesor FROM materias t JOIN alumnos a ON a.id_alumno=? JOIN profesores p ON p.id_profesor=? WHERE t.id_materia=? AND a.estatus='ALTA'");
            $s->bind_param('iii', $alumno, $profesor, $destino);
            $s->execute();
            $mensaje = $s->affected_rows === 1 ? 'Asignación guardada.' : 'Comprueba que el alumno esté de alta y el destino esté disponible.';
        } catch (Throwable $e) {
            $mensaje = 'No se guardó. Puede que este alumno ya tenga grupo o esta materia asignada.';
        }
    }
}
$alumnos = consultar("SELECT id_alumno, matricula, nombre, apaterno FROM alumnos WHERE estatus='ALTA' ORDER BY apaterno, nombre");
$profesores = consultar('SELECT id_profesor, nombre, apaterno FROM profesores ORDER BY apaterno, nombre');
$destinos = consultar("SELECT id_materia, descripcion FROM materias ORDER BY descripcion");
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><title>SAE | Asignar materia</title></head>
<body style="background-color:#fef9e7">
<h1>Proceso: asignar materia</h1>
<nav><a href="entrada_alumno.php">Alumno</a> | <a href="entrada_grupo.php">Grupo</a> | <a href="entrada_materia.php">Materia</a> | <a href="entrada_profesor.php">Profesor</a> | <a href="proceso_asignar_grupo.php">Asignar grupo</a> | <a href="proceso_asignar_materia.php">Asignar materia</a> | <a href="salida_alumnos.php">Lista de alumnos</a> | <a href="salida_materias.php">Lista de materias</a> | <a href="salida_grupos.php">Lista de grupos</a> | <a href="salida_grupos_asignados.php">Grupos asignados</a> | <a href="salida_boleta.php">Materias asignadas</a> | <a href="salida_alumnos_baja.php">Alumnos de baja</a></nav><hr>
<p><?= h($mensaje) ?></p>
<form method="post">
<label>Alumno <select name="alumno" required><option value="">Selecciona</option>
<?php foreach ($alumnos as $a): ?><option value="<?= h($a['id_alumno']) ?>"><?= h($a['matricula'].' - '.$a['nombre'].' '.$a['apaterno']) ?></option><?php endforeach; ?>
</select></label><br><br>
<label>Materia <select name="destino" required><option value="">Selecciona</option>
<?php foreach ($destinos as $d): ?><option value="<?= h($d['id_materia']) ?>"><?= h($d['descripcion']) ?></option><?php endforeach; ?>
</select></label><br><br>
<label>Profesor <select name="profesor" required><option value="">Selecciona</option>
<?php foreach ($profesores as $f): ?><option value="<?= h($f['id_profesor']) ?>"><?= h($f['nombre'].' '.$f['apaterno']) ?></option><?php endforeach; ?>
</select></label><br><br>
<button>Asignar materia</button>
</form></body></html>
