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

// Se usuário NÃO está logado, envia para 'login'.
if (!isset($_COOKIE['user'])) header('Location: /user/login/');

// Variáveis principais
$id = $name = $email = $birth = $profile = $error = '';
$feedback = false;

// Se formulário foi enviado...
if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Recebe o campo 'nome' do formulário, sanitiza e valida.
    $name = trim(htmlspecialchars($_POST['name']));
    if (strlen($name) < 3)
        $error .= '<li>Seu nome está muito curto;</li>';

    // Recebe o campo 'email' do formulário, sanitiza e valida.
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :

        $error .= '<li>Seu e-mail está inválido;</li>';

    else :

        // Se editou o e-mail.
        if ($email !== $user['user_email']) :

            // Verifica se e-mail já está cadastrado.
            $res = $conn->query("SELECT user_id FROM users WHERE user_email = '{$email}';");
            if ($res->num_rows != 0)
                $error .= '<li>Este e-mail já está em uso;</li>';

        endif;

    endif;

    // Recebe a 'data de nascimento' do formulário, sanitiza e valida.
    $birth = trim(htmlspecialchars($_POST['birth']));
    if ($birth > date('Y-m-d', time() - 284018400))
        $error .= '<li>Você deve ter mais de 9 anos;</li>';

    // Recebe o 'perfil' do formulário e sanitiza.
    $profile = trim(htmlspecialchars($_POST['profile']));

    // Se não exitem erros.
    if ($error === '') :

        // Query de atualização do cadastro.
        $sql = <<<SQL

UPDATE `users` SET 
	user_name = '{$name}',
	user_email = '{$email}',
	user_birth = '{$birth}',
	user_profile = '{$profile}'
WHERE user_id = '{$user['user_id']}'
    AND user_status = 'on';

SQL;

        // Executa a query.
        $conn->query($sql);

        // SQL para obter TODOS os dados do usuário e gerar o cookie novamente.
        $sql = <<<SQL

SELECT *,
    DATE_FORMAT(user_birth, '%d/%m/%Y') AS birth_br
FROM `users`
WHERE user_email = '{$email}'
    AND user_status = 'on';
                
SQL;

        // Executa a query.
        $res = $conn->query($sql);

        // Obtém dados do usuário.
        $user_data = $res->fetch_assoc();

        // Apaga a senha.
        unset($user_data['user_password']);

        // Adiciona expiração do cookie.
        $user_data['expires'] = $user['expires'];

        // Grava o cookie no navegador
        setcookie(
            'user',                 // nome do cookie criado
            serialize($user_data),  // valor do cookie
            $user['expires'],       // tempo de vida do cookie em segundos
            '/'                     // Domínio do cookie "/" de localhost
        );

        // Feedback
        $feedback = true;

    endif;

// Obtendo os dados do banco e preenchendo o formulário.
else :

    // Obtém dados do banco de dados.
    $sql = <<<SQL

SELECT `user_id`, `user_name`, `user_email`, `user_birth`, `user_profile` FROM `users`
WHERE `user_id` = '{$user['user_id']}'
	AND `user_status` = 'on';

SQL;

    // Executa a query.
    $res = $conn->query($sql);

    // Se não recebeu os dados, envia para login.
    if ($res->num_rows != 1) header('Location: /user/login/');

    // Obtém dados do usuário.
    $user_data = $res->fetch_assoc();

    // Atribuindo aos campos do formulário.
    $id = $user_data['user_id'];
    $name = $user_data['user_name'];
    $email = $user_data['user_email'];
    $birth = $user_data['user_birth'];
    $profile = $user_data['user_profile'];

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
$title = "Editar perfil";

/**
 * Inclui o cabeçalho da página.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <h3>Editar Perfil</h3>

    <?php
    // Se o cadastyro foi finalizado com sucesso...
    if ($feedback) :
    ?>

        <div class="block-center">

            <h3>Oba!</h3>
            <p>Seu cadastro foi atualizado com sucesso!</p>
            <hr class="divider">
            <p class="text-center"><a href="/"><i class="fa-solid fa-house fa-fw"></i> Página inicial</a></p>

        </div>

        <script>
            // JavaScript que bloqueia reenvio do form caso a página seja recarregada.
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>

    <?php else : ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="edituser">

            <p>Altere somente os campos que deseja editar.</p>

            <?php if ($error != '') echo '<div class="error">' . $error . '</div>'; ?>

            <p>
                <label for="name">Nome completo:</label>
                <input type="text" name="name" id="name" required minlength="3" class="valid" autocomplete="off" value="<?php echo $name ?>">
            </p>

            <p>
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" required class="valid" autocomplete="off" value="<?php echo $email ?>">
            </p>

            <p>
                <label for="birth">Data de nascimento:</label>
                <input type="date" name="birth" id="birth" required class="valid" autocomplete="off" value="<?php echo $birth ?>">
            </p>

            <p>
                <label for="profile">Prefil resumido: <small>(Opcional)</small></label>
                <textarea name="profile" id="profile" class="valid" autocomplete="off"><?php echo $profile ?></textarea>
            <div class="form-help">
                <ul>
                    <li>Escreva sobre você, de forma resumida.</li>
                </ul>
            </div>
            </p>

            <p>
                <button type="submit">Enviar</button>
            </p>

        </form>

    <?php endif; ?>

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
