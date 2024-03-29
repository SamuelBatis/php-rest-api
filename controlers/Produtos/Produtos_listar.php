<?php
include "../../models/Produtos.php";
$resposta = array();
$produto = new Produtos();
$produtos = $produto->listar();
header("HTTP/1.1 200 OK");
echo json_encode($produtos);
