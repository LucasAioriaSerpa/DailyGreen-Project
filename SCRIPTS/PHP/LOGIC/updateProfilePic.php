<?php
include_once 'session.php';
include_once 'uploadImage.php';
include_once 'functions.php';
include_once 'SQL_connection.php';
$sqlConnection = new SQLconnection();
debug_var($_POST);
debug_var($_FILES);
$_UPLOAD_IMAGE = new ImageUploader('/xampp/htdocs/DailyGreen-Project/IMAGES/PROFILES/');
$profile_pic = $_UPLOAD_IMAGE->upload($_FILES['profile_pic']);
$idParticipante = $_SESSION['user']['account'][0]['id_participante'];

$sqlQuery = "
UPDATE participante SET 
profile_pic = '{$profile_pic}'
WHERE id_participante = '{$idParticipante}'
";

$sqlConnection->insertQueryBD($sqlQuery);
$_SESSION['user']['account'][0]['profile_pic'] = $profile_pic;
header("Location: /DailyGreen-Project/SCRIPTS/PHP/pagina_perfil.php");