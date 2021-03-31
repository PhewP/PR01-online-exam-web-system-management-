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
          <div class="column is-8 is-offset-2">
            <div class="box">
                <h1 class="title">Crear Pregunta</h1>
        <form action="crear_examen.php" >
        <div class="field">
            <label class="label">Enunciado</label>
            <div class="control">
            <textarea class="textarea" placeholder="Escriba el enunciado de la pregunta" name="enunciado" require></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta A</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaA" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta B</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaB" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta C</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaC" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta D</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaD" required>
            </div>
        </div>

        <div class="field">
        <label class="label">Respuesta Correcta</label>
        <div class="control">
            <div class="select">
            <select name="respuestaCorrecta" class="has-text-centered" required>
                <option disabled>Seleccione una opción</option>
                <option>A</option>
                <option>B</option>
                <option>C</option>
                <option>D</option>
            </select>
            </div>
        </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <input type="submit" class="button is-link" value="Crear">
            </div>
            <a href="login.php" class="button is-link is-light">Atrás</a> 
        </div>
        </form>
        </div>
      </div>
      </div>
    </body>
</html>