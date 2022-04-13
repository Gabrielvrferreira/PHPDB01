<?php

/**
 * Gera conteúdo sempre em UTF-8.
 * DEVE SER sempre a primeira linha de código.
 */
header('Content-Type: text/html; charset=utf-8');

/**
 * Dados de conexão com o banco de dados.
 */
$db = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'vitugo'
);

/**
 * Linha de conexão com o banco de dados.
 */
$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

/**
 * SQL de teste do banco de dados.
 */
$sql = "SELECT * FROM articles WHERE art_status = 'on'";

/**
 * Executa a query, armazenando o resultado em '$res'
 */
$res = $conn->query($sql);

/**
 * Loop para obter cada um dos registros.
 * O método 'fetch_assoc()' retorna cada registro dentro de um array.
 */
while ($article = $res->fetch_assoc()) {

    /**
     * Exibindo valor da array no HTML.
     */
    echo '<pre>';
    print_r($article);
    echo '</pre>';
}

/**
 * SQL de teste com o banco de dados.
 */
$sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('Joca', 'joca@joca', 'Contato do Joca', 'Mensagem do Joca')";

/**
 * Executa a query, armazenando o resultado em '$res'
 */
$conn->query($sql);

<?php

/**
 * Gera conteúdo sempre em UTF-8.
 * DEVE SER sempre a primeira linha de código.
 */
header('Content-Type: text/html; charset=utf-8');

/**
 * Dados de conexão com o banco de dados.
 */
$db = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'vitugo'
);

/**
 * Linha de conexão com o banco de dados.
 */
$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

/**
 * SQL de teste do banco de dados.
 */
$sql = "SELECT * FROM articles WHERE art_status = 'on'";

/**
 * Executa a query, armazenando o resultado em '$res'
 */
$res = $conn->query($sql);

/**
 * Loop para obter cada um dos registros.
 * O método 'fetch_assoc()' retorna cada registro dentro de um array.
 */
while ($article = $res->fetch_assoc()) {

    /**
     * Exibindo valor da array no HTML.
     */
    echo '<pre>';
    print_r($article);
    echo '</pre>';
}

/**
 * SQL de teste com o banco de dados.
 */
$sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('Joca', 'joca@joca', 'Contato do Joca', 'Mensagem do Joca')";

/**
 * Executa a query, armazenando o resultado em '$res'
 */
$conn->query($sql);

