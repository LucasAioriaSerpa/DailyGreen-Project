<?php
    include_once 'LOGIC/session.php';
    include_once 'LOGIC/SQL_connection.php';
    include_once 'LOGIC/functions.php';
    if ($_SESSION['user']['loged'] === false) {
        header("Location: /DailyGreen-Project/SCRIPTS/PHP/loginAdm.php");
        exit();
    }

    $sqlConnection = new SQLconnection();
    $admArray = $sqlConnection->callTableBD('administrador');
    $denunciaArray = $sqlConnection->callTableBD('denuncia');
    $midiaArray = $sqlConnection->callTableBD('midia');
    $id_adm = ((int) $_SESSION['user']['account']['id_administrador']);
    $id_denuncia = (int) $_GET['id'];


    // JOIN para pegar os dados do relator, relatado, post, midia e adm
    $join = "SELECT denuncia.*,
        relator.username AS relator_username,
        relator.email AS relator_email,
        relator.profile_pic AS relator_profile_pic,
        relator.create_time AS relator_creation_date,
        relatado.username AS relatado_username,
        relatado.email AS relatado_email,
        relatado.profile_pic AS relatado_profile_pic,
        relatado.create_time AS relatado_creation_date,
        administrador.email AS administrador_email,
        post.titulo AS post_titulo,
        post.descricao AS post_descricao,
        post.create_time AS post_creation_date,
        midia.midia_ref AS post_midia_ref
        FROM denuncia
        JOIN participante AS relator ON denuncia.id_relator = relator.id_participante
        JOIN participante AS relatado ON denuncia.id_relatado = relatado.id_participante
        LEFT JOIN administrador ON denuncia.id_administrador = administrador.id_administrador
        JOIN post ON denuncia.id_post = post.id_post
        LEFT JOIN midia ON post.id_post = midia.id_post
        WHERE denuncia.id_denuncia = {$id_denuncia};";

    $joinQuery = $sqlConnection->joinQueryBD($join);

    // Setando as variáveis do JOIN para exibir os dados
    if ($joinQuery && count($joinQuery) > 0) {
        // Relatado
        $relatado_id = $joinQuery[0]['id_relatado'];
        $relatado = $joinQuery[0]['relatado_username'];
        $relatado_email = $joinQuery[0]['relatado_email'];
        $relatado_pic = $joinQuery[0]['relatado_profile_pic'];
        $relatado_creation_date = $joinQuery[0]['relatado_creation_date'];
        // Relator
        $relator_id = $joinQuery[0]['id_relator'];
        $relator = $joinQuery[0]['relator_username'];
        $relator_email = $joinQuery[0]['relator_email'];
        $relator_pic = $joinQuery[0]['relator_profile_pic'];
        $relator_creation_date = $joinQuery[0]['relator_creation_date'];
        // Post
        $post_id = $joinQuery[0]['id_post'];
        $post_titulo = $joinQuery[0]['post_titulo'];
        $post_descricao = $joinQuery[0]['post_descricao'];
        $post_creation_date = $joinQuery[0]['post_creation_date'];
        $midia_post = $joinQuery[0]['post_midia_ref'];
        // Denuncia
        $denuncia_id = $joinQuery[0]['id_denuncia'];
        $denuncia_data = $joinQuery[0]['data_registro'];
        $denuncia_motivo = $joinQuery[0]['titulo'];
        $denuncia_descricao = $joinQuery[0]['motivo'];
        $denuncia_status = $joinQuery[0]['status'];
        $data_inicio_analise = $joinQuery[0]['data_inicio_analise'];
        $data_fim_analise = $joinQuery[0]['data_fim_analise'];
        // Administrador
        $admnistrador_id = $joinQuery[0]['id_administrador'];
        $admnistrador_email = $joinQuery[0]['administrador_email'];
        //Formato Data
        $relatado_create_time = new DateTime($relatado_creation_date);
        $relator_create_time = new DateTime($relator_creation_date);
        $denuncia_registro = new DateTime($denuncia_data);
        $data_inicio = new DateTime($data_inicio_analise);
        if ($data_fim_analise != null){
            $data_fim = new DateTime($data_fim_analise);
        }
    } 

    if (!isset($midia_post))  {
        $midia_post = "Esse post não possui imagens.";
    }


    $checkAndUpdate = "UPDATE denuncia
        SET 
            id_administrador = {$id_adm}, 
            status = 'Em Análise', 
            data_inicio_analise = NOW()
        WHERE 
            id_denuncia = {$id_denuncia}
            AND id_administrador IS NULL
            AND status = 'Pendente';
    ";

    $sqlConnection->rawQueryBD($checkAndUpdate);

?>