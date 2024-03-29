<?php
include "../../models/Produtos.php";
$resposta = array();
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$idProdutos = $partesRota[2];
$produtos = new Produtos();
$produtos->setIdProdutos($idProdutos);
$resultado = $produtos->excluir();

if ($resultado == true) {
  $resposta['cod'] = "ok";
  $resposta['msg'] = "Excluido com sucesso";
  $resposta['DELETE'] = $produtos;
} else {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi Excluido";
}
header("HTTP/1.1 200 Ok");
echo json_encode($resposta);
