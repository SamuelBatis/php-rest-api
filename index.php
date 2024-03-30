<?php
$metodo = $_SERVER['REQUEST_METHOD'];
$partesRota = explode("/", $_SERVER['REQUEST_URI']);
if ($partesRota[1] == "clientes") {
  if ($metodo == "POST") {
    require_once "controlers/Clientes/Cliente_cadastrar.php";
  } elseif ($metodo == "PUT") {
    require_once "controlers/Clientes/Cliente_atualizar.php";
  } elseif ($metodo == "DELETE") {
    require_once "controlers/Clientes/Cliente_excluir.php";
  } elseif ($metodo == "GET") {
    if (isset($partesRota[2])) {
      if (is_numeric($partesRota[2])) {
        require_once "controlers/Clientes/Cliente_buscar.php";
      } else if ($partesRota[2] == "") {
        require_once "controlers/Clientes/Cliente_listar.php";
      }
    } else {
      require_once "controlers/Clientes/Cliente_listar.php";
    }
  } else {
    header("HTTP/1.1 404 Not Found");
  }
} else {
  header("HTTP/1.1 404 Not Found");
}

if ($partesRota[1] == "produtos") {
  if ($metodo == "POST") {
    require_once "/controlers/Produtos/Produtos_cadastrar.php";
  } elseif ($metodo == "PUT") {
    require_once "/controlers/Produtos/Produtos_atualizar.php";
  } elseif ($metodo == "DELETE") {
    require_once "/controlers/Produtos/Produtos_excluir.php";
  } elseif ($metodo == "GET") {
    if (isset($partesRota[2])) {
      if (is_numeric($partesRota[2])) {
        require_once "/controlers/Produtos/Produtos_buscar.php";
      } else if ($partesRota[2] == "") {
        require_once "/controlers/Produtos/Produtos_listar.php";
      }
    } else {
      require_once "/controlers/Produtos/Produtos_listar.php";
    }
  } else {
    header("HTTP/1.1 404 Not Found");
  }
}

