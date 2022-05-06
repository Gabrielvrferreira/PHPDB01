<?php

/**
 * Este arquivo é apenas um exemplo que não faz parte da aplicação completa.
 * Pode ser removido depois que o assunto for entendido.
 */

// Recebe dados do formulário
echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>';

// 3) Salva arquivo enviado no servidor
move_uploaded_file(
    $_FILES['arquivo']['tmp_name'], // Origem -> pasta 'tmp'
    'arquivos/teste' // Destino
);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Upload de Arquivo</title>
</head>

<body>

    <!-- 1) enctype="..." obrigatório para upload de arquivos -->
    <form action="upload.php" method="post" enctype="multipart/form-data">

        <p> Nome: <input type="text" name="nome" value="joca"> </p>
        <p> E-mail: <input type="email" name="email" value="teste@teste"> </p>

        <!-- 2) Campo que pesquisa o arquivo a ser enviado (upload) no computador. -->
        <p> Arquivo: <input type="file" name="arquivo"> </p>

        <p> <button type="submit">Enviar</button> </p>

    </form>

</body>

</html>