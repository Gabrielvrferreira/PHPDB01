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

// Variáveis principais
$email = $password = $feedback = '';

// Processa o formulário, somente se ele foi enviado...
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Obtém os dados do formulário para as variáveis
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = trim(htmlspecialchars($_POST['password']));

    // Verifica sem tem algum campo vazio
    if ($email === '' or $password == '') :

        // Mensagem de erro para usuário
        $feedback = "Os campos não podem estar vazios.";

    endif;


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
$title = "Login...";

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <h2>Login / Entrar</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

        <p>Logue-se para ter acesso ao conteúdo exclusivo.</p>

        <p>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" autocomplete="off" required class="valid" value="set@brino.com">
        </p>

        <p>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" autocomplete="off" required class="valid" value="123">
        </p>

        <!-- pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{7,}$" -->

        <p>
            <label>
                <input type="checkbox" name="logged" id="logged" value="true">
                <span>Mantenha-me logada(o).</span>
            </label>
        </p>

        <p>
            <button type="submit">Entrar</button>
        </p>

    </form>

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
