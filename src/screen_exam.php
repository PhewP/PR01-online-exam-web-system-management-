<?php 
    function getDatetimeNow() {
        $tz_object = new DateTimeZone('Europe/Madrid');

        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y-m-d');
    }
?>

<!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Crear Examen</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
        <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
      </head>
      <body>
      <div class="container has-text-centered">
          <div class="column is-4 is-offset-4">
            <div class="box">
                <h1 class="title">Crear Examen</h1>
        <form action="crear_examen.php" >
        <div class="field">
            <label class="label">Titulo</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte un título" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Número de preguntas</label>
            <div class="control">
                <input class="input" type="number" placeholder="Inserte un número mayor que 5" min="5" step="1" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Fecha </label>
            <div class="control">
                <input class="input" type="date" name="fechaInicio" min="<?php echo (getDatetimeNow()) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Hora Inicio</label>
            <div class="control">
                <input class="input" type="time" name="horaInicio" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Hora Fin</label>
            <div class="control">
                <input class="input" type="time" name="horaFin" required>
            </div>
        </div>

        <div class="field">
        <label class="label">Temas</label>
        <div class="control">
            <div class="select is-multiple">
            <select name="temas" multiple required>
                <option disabled>Seleccione un o varios temas</option>
                <option>Tema 1</option>
                <option>Tema 2</option>
                <option>Todos</option>
            </select>
            </div>
        </div>
        </div>

        <div class="field">
        <label class="label">Descripción</label>
        <div class="control">
            <textarea class="textarea" placeholder="Escriba una descripción para los alumnos"></textarea>
        </div>
        </div>

        <div class="field is-grouped">
        <div class="control">
            <button class="button is-link">Submit</button>
        </div>
        </div>
        
        </form>
        <div class="control">
            <button class="button is-link is-light">Atrás</button>
        </div>
        </div>
      </div>
      </div>
    </body>

</html>