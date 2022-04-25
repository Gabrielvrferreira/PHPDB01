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
