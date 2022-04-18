<<?php

/**
 * Arquivo que faz a configuração incial da página.
 * Por exemplo, conecta-se ao banco de dados.
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

/***********************************************
 * Seus códigos PHP desta página iniciam aqui! *
 ***********************************************/

// Processa o formulário, se ele foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Cria e inicializa as variáveis usadas no script
    $nome = $email = $assunto = $mensagem = $feedback = '';

    // Recebe o campo 'nome' do formulário e sanitiza
    $nome = trim(htmlspecialchars($_POST['nome']));

    // Recebe o campo 'email' dor formulário e sanitiza
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Recebe o campo 'assunto' do formulário e sanitiza
    $assunto = trim(htmlspecialchars($_POST['assunto']));

    // Recebe o campo 'mensagem' do formulário e sanitiza
    $mensagem = trim(htmlspecialchars($_POST['mensagem']));

    // Verifica se tem algum campo vazio
    if ($nome === '' or $email === '' or $assunto === '' or $mensagem === '') {

        // Exibe mensagem de erro para o usuário e não faz mais nada
        $feedback = <<<HTML

<h3>Oooops!</h3>
<p>Não foi possível enviar o contato.</p>
<p>Você precisa preencher todos os campos do formulário.</p>
<p><button onclick="history.go(-1)">&larr; Voltar</button></p>

HTML;
    } else {

        /**
         * Se todos os campos estão preenchidos.
         * Salva dados no banco de dados.
         */

        // Query de escrita no banco
        $sql = <<<SQL

INSERT INTO contacts (
    name,
    email,
    subject,
    message
) VALUES (
    '{$nome}',
    '{$email}',
    '{$assunto}',
    '{$mensagem}'
);

SQL;

        // Escreve no banco de dados
        $conn->query($sql);

        

        // Abradecer ao usuário
        $feedback = <<<HTML



HTML;
    }
} else {

    /**
     * Se o formulário NÃO foi enviado
     * sai desta página e mostra o formulário para o usuário.
     */
    header('Location: index.php');
}

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
$title = "Faça contato";

/**
 * Inclui o cabeçalho da página.
 * A superglobal "$_SERVER['DOCUMENT_ROOT']" retorna o caminho da raiz do site no Windows.
 * Ex.: C:\xampp\htdocs 
 *     Referências:
 *     → https://www.w3schools.com/php/php_includes.asp
 *     → https://www.php.net/manual/pt_BR/function.include.php
 *     → https://www.php.net/manual/pt_BR/language.variables.superglobals.php
 */
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

?>

<section>

    <h2>Faça contato</h2>
    <?php echo $feedback ?>

</section>

<aside>

    <h3>Lateral</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officia, aperiam corporis culpa consequatur
        iusto.</p>

</aside>

<?php

// Inclui o rodapé da página
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
