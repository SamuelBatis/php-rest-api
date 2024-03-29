<?php
include "../../models/Produtos.php";

$resposta = array();

$jsonRecebido = file_get_contents('php://input');

$obj = json_decode($jsonRecebido);

$codigoDoItem = strip_tags($obj->codigo_do_item);
$valor = strip_tags($obj->valor);
$quantidade = strip_tags($obj->quantidade);

if ($codigoDoItem == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Nome não preenchido";
} else if ($valor == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Valor não preenchido";
} else if ($quantidade == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Quantidade não preenchido";
} else {

  $produto = new Produtos();

  $produto->setCodigoDoItem($codigoDoItem);
  $produto->setValor($valor);
  $produto->setQuantidade($quantidade);

  $resultado = $produto->cadastrar();
}

if ($resultado == true) {
  header('HTTP/1.1 201 Created');
  $resposta['cod'] = "ok";
  $resposta['msg'] = "cadastrado com sucesso";
  $resposta['POST'] = $produto;
} else {
  header('HTTP/1.1 200 ok');
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi cadastrado";
}

echo json_encode($resposta);
