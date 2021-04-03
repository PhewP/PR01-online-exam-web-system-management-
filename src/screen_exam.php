<?php



function examenCreado(){
    ?>
        <div class="field is-grouped">
                <div class="control">
                <a href="screen_exam.php" class="button is-link">Crear Otro</a> 
    
                </div>
                <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
        </div>
    <?php
}

function CrearExamen() {
    ?>
    <form action="screen_exam.php" method="POST">
    <div class="field">
        <label class="label">Titulo</label>
        <div class="control">
            <input name="titulo" class="input" type="text" placeholder="Inserte un título" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Número de preguntas</label>
        <div class="control">
            <input name="numeroPreguntas" class="input" type="number" placeholder="Inserte un número mayor que 5" min="5" step="1" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Fecha </label>
        <div class="control">
            <input name="fecha" class="input" type="date" name="fechaInicio" min="'.getDatetimeNow().'" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Hora Inicio</label>
        <div class="control">
            <input name="horaInicio" class="input" type="time" name="horaInicio" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Hora Fin</label>
        <div class="control">
            <input name="horaFin" class="input" type="time" name="horaFin" required>
        </div>
    </div>

    <div class="field">
    <label class="label">Temas</label>
    <div class="control">
        <div class="select is-multiple">
        <select name="temas[]" multiple required>
            <option disabled>Seleccione un o varios temas</option>
            <option value="1">Tema 1</option>
            <option value="2">Tema 2</option>
            <option value="all">Todos</option>
        </select>
        </div>
    </div>
    </div>
    <div class="field">
    <label class="label">Descripción</label>
    <div class="control">
        <textarea name="descripcion" class="textarea" placeholder="Escriba una descripción para los alumnos"></textarea>
    </div>
    </div>

    <div class="field is-grouped">
    <div class="control">
        <input name="crear" type="submit" class="button is-link" value="Crear">
    </div>
    <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
    </div>
    </form>
<?php
}
    include("base.php");
    session_start();

    $env = parse_ini_file("../.env");

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    if(isset($_POST['crear'])) {

        $idSubject = $_SESSION['asignaturaActual'];
        $user =  unserialize($_SESSION['user']);
        $userId = $user->getId();
        //Hacer query de crear examen
        //Mostrar crear otro o atras
        echo "Examen creado";
        echo "Asignatura: ".$idSubject;
        echo "user: ".$user;

        $nombre = $_POST['titulo'];
        $numPreguntas = $_POST['numeroPreguntas'];
        $fecha = $_POST['fecha'];
        $fecha_ini = $fecha." ".$_POST['horaInicio']."</br>";
        $fecha_fin = $fecha." ".$_POST['horaFin'];
        $descripcion = $_POST['descripcion'];

        echo $fecha_ini;
        echo $fecha_fin;
        //Tema es un array de temas
        $temas= $_POST['temas'];
   

        $examen = $api->createExam($userId, $idSubject, $fecha_ini, $fecha_fin, $nombre, $descripcion, $temas, $numPreguntas);
        Base("Examen creado con Exito", "examenCreado");
    }
    else { 
        Base("Crear Examen", 'CrearExamen');
    }

?>
