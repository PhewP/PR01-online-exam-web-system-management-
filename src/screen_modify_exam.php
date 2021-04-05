<?php
include('base.php');




function infoExam() {
    $env = parse_ini_file("../.env");

    if(!isset($_SESSION['idExamen'])) {
        $_SESSION['idExamen'] = $_POST['exam'];
    }

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);
    $infoExam = $api->getExamInformation($_SESSION['idExamen']);
    $IdTemas = $api->getTemasExamen($_SESSION['idExamen']);

    foreach($IdTemas as $idTema) {
        $temas[] = $api->getTheme($idTema)->getNumero();
    }
    sort($temas);

?>
    <h1 class="title is-3">Titulo:<h1>
    <h1 class="subtitle is-4"><?php echo $infoExam['nombre']?><h1>
    <h1 class="title is-3">Descripcion<h1>
    <h1 class="subtitle is-4"><?php echo $infoExam['descripcion']?><h1>
    <h1 class="title is-3">Número de pregutnas<h1>
    <h1 class="subtitle is-4"><?php echo $infoExam['numeroPreguntas']?><h1>
    <h1 class="title is-3">Fecha Inicio<h1>
    <h1 class="subtitle is-4"><?php echo $infoExam['fecha_ini']?><h1>
    <h1 class="title is-3">Fecha Fin<h1>
    <h1 class="subtitle is-4"><?php echo $infoExam['fecha_fin']?><h1>
    <h1 class="title is-3">Temas<h1>
    <h1 class="subtitle is-4"><?php echo implode(', ', $temas)?><h1>

<div class="field is-grouped">
    <div class="control">
        <form action="screen_modify_exam.php" method="POST">
                <input type = "hidden" name = "borrar" value = "<?php echo $_SESSION['idExamen']; ?>">
                <button class = "button if-light is-danger">Borrar</button>
        </form>
    </div> 
    <a href="screen_teacher.php" class="button is-link is-light">Atrás</a>
</div>

<?php
}

function examenBorrado(){
?>
    <div class="field is-grouped">
        <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
    </div>
<?php
}
$env = parse_ini_file("../.env");
      
$api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

if(isset($_POST['borrar'])){
    $api->deleteExamen($_POST['borrar']);
    base("Examen Borrado con Éxito", 'examenBorrado');

}else{
    base("Examen", 'infoExam');
}
?>