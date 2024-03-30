<?php
include "../../models/Compras.php";

$resposta = array();

$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$id = $partesRota[2];

$compra = new Compras();
$compraEncontrada = $compra->buscar($id);

if ($compraEncontrada) {
    header("HTTP/1.1 200 OK");
    echo json_encode($compraEncontrada);
} else {
    header("HTTP/1.1 404 Not Found");
    $resposta['cod'] = "erro";
    $resposta['msg'] = "Compra não encontrada";
    echo json_encode($resposta);
}
