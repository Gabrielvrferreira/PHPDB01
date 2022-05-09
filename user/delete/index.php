<?php

/**
 * Arquivo que faz a configuração incial da página.
 * Por exemplo, conecta-se ao banco de dados.
 * 
 * A superglobal "$_SERVER['DOCUMENT_ROOT']" retorna o caminho da raiz do site no Windows.
 * Ex.: C:\xampp\htdocs 
 *     Referências:
 *     → https://www.w3schools.com/php/php_includes.asp
 *     → https://www.php.net/manual/pt_BR/function.include.php
 *     → https://www.php.net/manual/pt_BR/language.variables.superglobals.php
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

/***********************************************
 * Seus códigos PHP desta página iniciam aqui! *
 ***********************************************/

// Se confirmou o cancelamento...
if ($_SERVER['QUERY_STRING'] === 'delete') :

    // SQL que atualiza o banco de dados.
    $sql = <<<SQL

UPDATE users SET user_status = 'deleted'
WHERE user_id = '{$user['user_id']}'

SQL;

    // Executa a query.
    $conn->query($sql);

    // Apaga cookie.
    setcookie('user', '', -1, '/');

    // Redireciona para a home.
    header('Location: /');

endif;

/************************************************
 * Seus códigos PHP desta página terminam aqui! *
 ************************************************/

/**
 * Variável que define o título desta página.
 * Essa variável é usada no arquivo "_header.php".
 * OBS: para a página inicial (index.php) usaremos o 'slogan' do site.
 *     Referências:
 *     → https://www.w3schools.com/php/php_variables.asp
 *     → https://www.php.net/manual/pt_BR/language.variables.basics.php
 */
$title = "Cancelar Cadastro";

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <h2>Cancelar Cadastro</h2>
    <p class="text-center" style="color: grey"><i class="fa-solid fa-user-xmark fa-fw fa-4x"></i></p>
    <p>Tem certeza que deseja cancelar seu cadastro? Se cancelar, não será mais possível acessar o conteúdo exclusivo.</p>
    <p>Clique no botão abaixo para cancelar o cadastro.</p>
    <p class="text-center">
        <button class="btn-logout" type="button" onclick="location.href = '?delete'">
            <i class="fa-solid fa-user-xmark fa-fw"></i>
            &nbsp;Cancelar cadastro
        </button>
    </p>

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
