<?php
date_default_timezone_set('America/Sao_Paulo');

$vData_ = date("Y-m-dH:i:s");
$time_start = microtime(true);
echo "<br> inicio: ".$vData_;
echo "<hr>";

require 'Comandos.php';
$comandos = new Comandos();
$comandos->criaTabela();
$comandos->processa();

echo "<hr>";
//imprimindo os times finais
$vData_ = date("Y-m-dH:i:s");
$time_end = microtime(true);
echo "<br>fim: ".$vData_;
echo "<hr>";

//calculando o tempo total
$time = $time_end - $time_start;
echo "tempo de processamento do <b>Insert</b>=>".$time;