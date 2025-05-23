<?php
    include_once 'LOGIC/session.php';
    include_once 'LOGIC/SQL_connection.php';
    include_once 'LOGIC/functions.php';
    if ($_SESSION['user']['loged'] === false) {
        header("Location: /DailyGreen-Project/SCRIPTS/PHP/loginAdm.php");
        exit();
    }
?>

<div class="menu_principal" id="menu_principal" name="menu_principal">
    <div class="all-buttons">
        <div class="button-row">
            <div class="btn_users">
                <button class="btn-users-list" id="btn-users-list" name="btn-users-list" onclick="loadPage('/DailyGreen-Project/SCRIPTS/PHP/listUsers.php')">Lista de Usuários</button>
            </div>
            <div class="btn-report">
                <button class="btn-report-list" id="btn-report-list" name="btn-report-list" onclick="loadPage('/DailyGreen-Project/SCRIPTS/PHP/listReport.php')">Lista de Denúncias</button>
            </div>
        </div>
        <div class="button-row">
            <div class="btn_suspenso">
                <button class="btn-suspenso-list" id="btn-suspenso-list" name="btn-suspenso-list">Lista de Suspensos</button>
            </div>
            <div class="btn_banido">
                <button class="btn-banido-list" id="btn-banido-list" name="btn-banido-list">Lista de Banidos</button>
            </div>
        </div>
    </div>
</div>