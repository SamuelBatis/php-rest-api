<?php
include "../../models/Cliente.php";
$resposta = array();

$jsonRecebido = file_get_contents('php://input');
$obj = json_decode($jsonRecebido);


$nome = strip_tags($obj->nome);
$telefone = strip_tags($obj->telefone);
$cpf = strip_tags($obj->cpf);
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
$idCliente = $partesRota[2];


if ($nome == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Nome não preenchido";
} else if ($telefone == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Telefone não preenchido";
} else if ($cpf == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "CPFnão preenchido";
} else {
  $cliente = new Cliente();
  $cliente->setIdCliente($idCliente);
  $cliente->setNome($nome);
  $cliente->setTelefone($telefone);
  $cliente->setCpf($cpf);
  $resultado = $cliente->atualizar();
}
if ($resultado == true) {
  header("HTTP/1.1 200 OK");
  $resposta['cod'] = "ok";
  $resposta['msg'] = "Atualizado com sucesso";
  $resposta['PUT'] = $cliente;
} else {
  header("HTTP/1.1 200 OK");
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi atualizado";
}

echo json_encode($resposta);
