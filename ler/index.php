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
	    -- DATE_FORMAT(art_date, '%d/%m/%Y às %H:%i') AS date_br,
        DATE_FORMAT(art_date, '%d/%m/%Y') AS date_br,
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

// dump($artigo);

// Formata HTML para o navegador
$html_article = <<<HTML

<h2>{$artigo['art_title']}</h2>

<div class="author-date">
    Por {$artigo['user_name']} em {$artigo['date_br']}.
</div>

<div>{$artigo['art_content']}</div>

HTML;

// Primeiro nome do autor
$nome = explode(' ', $artigo['user_name'])[0];

// Obtém a idade do autor
$idade = get_years_old($artigo['user_birth']);

// Formata HTML para o autor
$html_author = <<<HTML

<div class="author-meta">

    <img src="{$artigo['user_photo']}" alt="{$artigo['user_name']}">
    <h3>{$nome}</h3>
    <ul>
        <li><strong>{$artigo['user_name']}</strong></li>
        <li>E-mail: <a href="mailto:{$artigo['user_email']}" target="_blank">{$artigo['user_email']}</a></li>
        <li>Nasceu em {$artigo['birth_br']} ({$idade} anos)</li>
        <li>{$artigo['user_profile']}</li>
    </ul>

</div>

HTML;

/**
 * Verifica se autor tem mais artigos.
 * Se tiver, obtém até 4 de forma aleatória.
 * E, não pega o artigo atual.
 */
$sql = <<<SQL

SELECT art_id, art_title, art_intro 
FROM `articles`
WHERE art_author = '{$artigo['user_id']}'
    AND art_id != '{$artigo['art_id']}'
	AND art_status = 'on'
    AND art_date <= NOW()
ORDER BY RAND()
LIMIT 4;

SQL;

// Executa a query
$res = $conn->query($sql);

// Se tem mais artigos dete author...
if ($res->num_rows > 0) :

    // Exibe a chamada para os artigos encontrados.
    $html_author .= <<<HTML

<div class="author-articles">

    <hr class="divider">

    <h3>+ Artigos de {$nome}</h3>

HTML;

    // Loop para pegar todos os artigos recebidos
    while ($mais_artigos = $res->fetch_assoc()) :

        // Monta lista de artigos
        $html_author .= <<<HTML

    <div class="author-article" onclick="location.href='/ler/?id={$mais_artigos['art_id']}'">
        <h4>{$mais_artigos['art_title']}</h4>
        <small>{$mais_artigos['art_intro']}</small>
    </div>

HTML;

    endwhile;

    // Fecha lsita de artigos
    $html_author .= "</div>";

endif;

/**
 * Tarefas:
 * Eibir o perfil do autor na aside
 * Exibir mais artigos do autor
 * Exibir a idade do autor (tarefa de casa)
 */

/************************************************
 * Seus códigos PHP desta página terminam aqui! *
 ************************************************/

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <?php

    // Exibe o conteúdo do artigo completo
    echo $html_article;

    ?>

</section>

<aside>

    <?php

    // Exibe os dados do autor do artigo
    echo $html_author;

    ?>

</aside>

<?php

/**
 * Inclui o rodapé da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
