<?php
include "../../models/Produtos.php";
$resposta = array();
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$id = $partesRota[2];
$produto = new Produtos();
$produtos = $produto->buscar($id);
header("HTTP/1.1 200 OK");
echo json_encode($produtos);
