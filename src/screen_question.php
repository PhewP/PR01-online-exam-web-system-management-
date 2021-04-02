<?php 
include("base.php");

function question () {
?>

<form action="crear_pregunta.php" method="POST" >
        <div class="field">
            <label class="label">Enunciado</label>
            <div class="control">
            <textarea class="textarea" placeholder="Escriba el enunciado de la pregunta" name="enunciado" required></textarea>
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
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            </div>
        </div>
        </div>
        <div class="field">
        <label class="label">Tema</label>
        <div class="control">
            <div class="select">
            <select name="tema" class="has-text-centered" required>
                <option disabled>Seleccione un tema</option>
                <option value="tema 1">Tema 1</option>
                <option value="tema 2">Tema 2</option>
                <option value="tema 3">Tema 3</option>
                <option value="tema 4">Tema 4</option>
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

<?php
}

base('Crear Pregunta', 'question');
?>
