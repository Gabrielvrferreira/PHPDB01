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

// Se usuário já está logado, redireciona para a página de perfil dele.
if(isset($_COOKIE['user'])) header('Location: /user/profile/');

// Variáveis principais
$email = $password = $feedback = '';

// O cookie durará somente a sessão. Navegador aberto.
$logged = 0;

// Processa o formulário, somente se ele foi enviado...
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Obtém os dados do formulário para as variáveis
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = trim(htmlspecialchars($_POST['password']));

    // Se o usuário quer manter-se logado...
    if (isset($_POST['logged'])) :

        // O cookie durará 365 dias em segundos;
        $logged = time() + (86400 * 365);

    endif;

    // Verifica sem tem algum campo vazio
    if ($email === '' or $password === '') :

        // Mensagem de erro para usuário
        $feedback = "Os campos não podem estar vazios.";

    // Se todos os campos foram preenchidos.
    else :

        // SQL para verificar no banco de dados
        $sql = <<<SQL

SELECT *,
    DATE_FORMAT(user_birth, '%d/%m/%Y') AS birth_br
FROM `users`
WHERE user_email = '{$email}'
	AND user_password = SHA1('{$password}')
    AND user_status = 'on';

SQL;

        // Executa a query
        $res = $conn->query($sql);

        // Se não achou o usuário...
        if ($res->num_rows != 1) :

            // Mensagem de erro para usuário
            $feedback = "Usuário e/ou senha não encontrados.";

        // Se achou o usuário...
        else :

            // Obtém dados do usuário
            $user_data = $res->fetch_assoc();

            // Apaga a senha
            unset($user_data['user_password']);

            // Grava o cookie no navegador
            // OBS:  cookies devem ser criados antes de enviar qualquer coisa para o navegador.
            setcookie(
                'user',                 // nome do cookie criado
                serialize($user_data),       // valor do cookie
                $logged,                // tempo de vida do cookie em segundos
                '/'                     // Domínio do cookie "/" de localhost
            );

            // envia usuário para a página inicial
            header('Location: /');

        endif;

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

        <?php

        // Exibe mensagens de erro
        if ($feedback != '') :

            echo '<p class="feedback">';
            echo $feedback;
            echo '</p>';

        endif;
        ?>

        <p>Logue-se para ter acesso ao conteúdo exclusivo. Se ainda não se cadastrou, <a href="/user/new/">cadastre-se aqui</a>.</p>

        <p>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" autocomplete="off" required class="valid" value="set@brino.com">
        </p>

        <p>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" autocomplete="off" required class="valid" value="Qw3rtyui0P" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{7,}$">
        </p>

        <!--  -->

        <p>
            <label>
                <input type="checkbox" name="logged" id="logged" value="true">
                <span>Mantenha-me logada(o).</span>
            </label>
        </p>

        <p>
            <button type="submit">Entrar</button>
        </p>

        <hr>

        <p class="user-links">
            <a href="/user/newpass/"><i class="fa-solid fa-key fa-fw"></i> Lembrar senha</a>
            <a href="/user/new/"><i class="fa-solid fa-user-plus fa-fw"></i> Cadastre-se</a>
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
