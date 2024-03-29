<?php
include "modelo/Cliente.php";
$resposta = array();
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$id = $partesRota[2];
$cliente = new Cliente();
$clientes = $cliente->buscar($id);
header("HTTP/1.1 200 OK");
echo json_encode($clientes);
