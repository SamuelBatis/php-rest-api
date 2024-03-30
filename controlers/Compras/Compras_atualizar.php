<?php
include "../../models/Compras.php";

$resposta = array();

$jsonRecebido = file_get_contents('php://input');

$obj = json_decode($jsonRecebido);

$cliente = strip_tags($obj->cliente);
$produtos = strip_tags($obj->produtos); // Supondo que $produtos seja um array de IDs de produtos
$quantidade = strip_tags($obj->quantidade);
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$idCompras = $partesRota[2];

if ($cliente == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Cliente não preenchido";
} else if (empty($produtos)) {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Produtos não selecionados";
} else if ($quantidade == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Quantidade não preenchida";
} else {

  $compra = new Compras();
  $compra->setIdCompras($idCompras);
  $compra->setCliente($cliente);
  $compra->setProdutos($produtos);
  $compra->setQuantidade($quantidade);

  $resultado = $compra->atualizar();
}

if ($resultado == true) {
  header('HTTP/1.1 200 OK');
  $resposta['cod'] = "ok";
  $resposta['msg'] = "Compra atualizada com sucesso";
  $resposta['compra'] = $compra;
} else {
  header('HTTP/1.1 200 OK');
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi possível atualizar a compra";
}

echo json_encode($resposta);
