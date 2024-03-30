<?php
include "../../models/Compras.php";

$resposta = array();

$compra = new Compras();
$compras = $compra->listar();

header("HTTP/1.1 200 OK");
echo json_encode($compras);
