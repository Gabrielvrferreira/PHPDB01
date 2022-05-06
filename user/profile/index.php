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

// Se usuário não está logado, redireciona para a página inicial.
if (!isset($_COOKIE['user'])) header('Location: /');

// Primeiro nome do usuário
$nome = explode(' ', $user['user_name'])[0];

// Obtém a idade do usuário
$idade = get_years_old($user['user_birth']);

// Formata perfil para exibição
$html = <<<HTML

<div class="author-meta">

    <h2>{$nome}</h2>
    <div class="user-photo">
        <img src="{$user['user_photo']}" alt="{$user['user_name']}">
        <a href="/user/profile/" title="Alterar foto de perfil."><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
    </div>
    &nbsp;
    <ul>
        <li><strong>{$user['user_name']}</strong></li>
        <li>E-mail: <a href="mailto:{$user['user_email']}" target="_blank">{$user['user_email']}</a></li>
        <li>Nasceu em {$user['birth_br']} ({$idade} anos)</li>
        <li>{$user['user_profile']}</li>
    </ul>
<hr class="divider">
    <div class="user-links">

        <a href="/user/edit/">
            <i class="fa-solid fa-address-card fa-fw"></i>
            Editar Perfil
        </a>

        <a href="/user/logout/">
            <i class="fa-solid fa-right-from-bracket fa-fw"></i>
            Logout / Sair
        </a>

    </div>

</div>

HTML;

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
$title = "Perfil.";

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <?php echo $html ?>

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
