<?php
include "../../models/Cliente.php";

$resposta = array();

$jsonRecebido = file_get_contents('php://input');

$obj = json_decode($jsonRecebido);

$nome = strip_tags($obj->nome);
$telefone = strip_tags($obj->telefone);
$cpf = strip_tags($obj->cpf);

if ($nome == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Nome não preenchido";
} else if ($telefone == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Telefone não preenchido";
} else if ($cpf == "") {
  $resposta['cod'] = "erro";
  $resposta['msg'] = "CPF não preenchido";
} else {

  $cliente = new Cliente();

  $cliente->setNome($nome);
  $cliente->setTelefone($telefone);
  $cliente->setCpf($cpf);

  $resultado = $cliente->cadastrar();
}

if ($resultado == true) {
  header('HTTP/1.1 201 Created');
  $resposta['cod'] = "ok";
  $resposta['msg'] = "cadastrado com sucesso";
  $resposta['POST'] = $cliente;
} else {
  header('HTTP/1.1 200 ok');
  $resposta['cod'] = "erro";
  $resposta['msg'] = "Não foi cadastrado";
}

echo json_encode($resposta);
