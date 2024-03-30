<?php
include "../../models/Compras.php";

$resposta = array();

$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$idCompras = $partesRota[2];

$compra = new Compras();
$compra->setIdCompras($idCompras);

$resultado = $compra->excluir();

if ($resultado == true) {
  $resposta['cod'] = "ok";
  $resposta['msg'] = "Excluído com sucesso";
  $resposta['DELETE'] = $compra;
} else {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi excluído";
}

header("HTTP/1.1 200 OK");
echo json_encode($resposta);
