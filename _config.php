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
 * Seta transações entre MySQL/MariaDB e PHP para UTF-8.
 */
$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');

/**
 * Seta dias da semana e meses do MySQL/MariaDB para "português do Brasil".
 */
$conn->query('SET GLOBAL lc_time_names = pt_BR');
$conn->query('SET lc_time_names = pt_BR');

/**
 * Define o fuso horário (opcional + recomendado).
 */
date_default_timezone_set('America/Sao_Paulo');

/**
 * Se usuário está logado, cria variável (array) '$user'
 */
if (isset($_COOKIE['user']))
    $user = unserialize($_COOKIE['user']);
else
    $user = false;

// dump($user, false);

/*************************
 * Funções de uso geral. *
 *************************/
/* Essas funções estão acessíveis para qualquer parte do aplicativo. */

/**
 * Função que calcula a idade.
 *
 * A data de nascimento, passada como parâmetro, deve estar no
 * formato 'system date', ou seja, 'aaaa-mm-dd'.
 * 
 * Exemplo de uso
 * 
 *      $nascimento = '1982-06-19';          // Data de nascimento no formato "system date"
 *      $idade = get_years_old($nascimento); // Chamando a função
 *      echo "{$idade} anos.";               // Saída
 * 
 * Lembre-se que existem outras formas de fazer esse cálculo.
 */
function get_years_old($birth)
{

    // O array '$n' contém a data atual
    $n = array(date('Y'), date('m'), date('d'));

    // O array '$b' contém a data de nascimento
    $b = explode('-', $birth);

    // Calculando a idade pelo ano (ano_atual - ano_nascimento)
    $yo = $n[0] - $b[0];

    // Se o mês é menor que o mês de nascimento...
    if ($n[1] < $b[1]) {

        // ... subtrai 1 ano
        $yo--;

        // Se é o mesmo mês e o dia é menor que o dia de nascimento...
    } elseif ($n[1] == $b[1] and $n[2] <= $b[2]) {

        // ... subtrai 1 ano
        $yo--;
    }

    // Retorno
    return $yo;
}

/**
 * Função que imprime uma variável.
 * 
 * Esta função é usada apenas em desenvolvimento, para fins de DEBUG.
 * 
 * Sintaxe: debug(var, pre, exit)
 * 
 *      var --> Variável a ser debugada.
 *              Default: undefined
 *      pre --> Se true, exibe saída pré-formatada; se false exibe sem formatação.
 *              Default: $pre = true
 *      exit --> Se true, encerra o script com 'exit'. Se false, continua o script.
 *              Default: $exit = true
 * 
 * Exemplo de uso:
 * 
 *      1) degub($variavel);
 *         Envia o "DUMP" da "$variável" para a saída (navegador).
 *         O DUMP é exibido pré-formatado.
 *         O script é interrompido com 'exit'.
 * 
 *      2) debug($variavel, false);
 *         Envia o "DUMP" da "$variável" para a saída (navegador).
 *         O DUMP é exibido pré-formatado.
 *         O script NÃO é interrompido com 'exit'.
 * 
 *      3) debug($variavel, true, false);
 *         Envia o "DUMP" da "$variável" para a saída (navegador).
 *         O DUMP é exibido sem pré-formatação.
 *         O script é interrompido com 'exit'.
 * 
 *      3) debug($variavel, false, false);
 *         Envia o "DUMP" da "$variável" para a saída (navegador).
 *         O DUMP é exibido sem pré-formatação.
 *         O script NÃO é interrompido com 'exit'.
 */
function dump($variable, $exit = true, $pre = true)
{
    if ($pre) echo '<pre>';
    print_r($variable);
    if ($pre) echo '</pre>';
    if ($exit) exit;
}
