<?php

include("base.php");

function CrearExamen() {
?>
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
            <input class="input" type="date" name="fechaInicio" min="'.getDatetimeNow().'" required>
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
        <input type="submit" class="button is-link" value="Crear">
    </div>
    <a href="login.php" class="button is-link is-light">Atrás</a> 
    </div>
    </form>
<?php
}

Base("Crear Examen", 'CrearExamen');

?>
