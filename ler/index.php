<?php

/**
 * Arquivo que faz a configuração incial da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

/**
 * Variável que define o título desta página.
 */
$title = "Quem tem fome tem pressa...";

/***********************************************
 * Seus códigos PHP desta página iniciam aqui! *
 ***********************************************/

// Obtém o ID do artigo da URL da página. 
if (isset($_GET['id'])) $id = intval($_GET['id']);
else $id = 0;

// Se está tentando acessar de forma incorreta, retorna para a index.
if ($id === 0) header('Location: /index.php');

// Monta a query que obtém o artigo
$sql = <<<SQL

SELECT *,
	DATE_FORMAT(art_date, '%d/%m/%Y às %H:%i') AS date_br,
    DATE_FORMAT(user_birth, '%d/%m/%Y') AS birth_br
FROM `articles`
INNER JOIN `users` ON art_author = user_id
WHERE art_id = '{$id}'
AND art_status = 'on'
AND art_date <= NOW();

SQL;

// Executa a query
$res = $conn->query($sql);

// Se não retornou UM (1) artigo, retorna para a index.
if ($res->num_rows != 1) header('Location: /index.php');

// Tudo certo, vamos obter os dados do registro obtido
$artigo = $res->fetch_assoc();



print_r($id);
exit;

/************************************************
 * Seus códigos PHP desta página terminam aqui! *
 ************************************************/

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <h2>Título da página</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum, iste aliquam aperiam voluptatem molestias nemo odit unde modi cupiditate exercitationem doloremque quaerat soluta rerum quidem dignissimos officiis sapiente, aut alias!</p>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio soluta voluptatum consequatur voluptatibus cupiditate temporibus qui, nostrum deserunt minus laudantium in officia rem dignissimos facilis modi culpa error aliquam? Quam?</p>

</section>

<aside>

    <h3>Lateral</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officia, aperiam corporis culpa consequatur iusto.</p>

</aside>

<?php

/**
 * Inclui o rodapé da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
