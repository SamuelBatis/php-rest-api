<?php
include "../Banco.php";

class Produtos implements JsonSerializable
{
  private $idProdutos;
  private $codigoDoItem;
  private $valor;
  private $quantidade;
  private $banco;

  public function __construct()
  {
  }

  public function getIdProdutos()
  {
    return $this->idProdutos;
  }
  public function setIdProdutos($idProdutos)
  {
    $this->idProdutos = $idProdutos;
  }
  public function getCodigoDoItem()
  {
    return $this->codigoDoItem;
  }
  public function setCodigoDoItem($codigoDoItem)
  {
    $this->codigoDoItem = $codigoDoItem;
  }
  public function getValor()
  {
    return $this->valor;
  }
  public function setValor($valor)
  {
    $this->valor = $valor;
  }
  public function getQuantidade()
  {
    return $this->quantidade;
  }
  public function setQuantidade($quantidade)
  {
    $this->quantidade = $quantidade;
  }
  public function jsonSerialize()
  {
    $json = array();
    $json['idProdutos'] = $this->getIdProdutos();
    $json['codigoDoItem'] = $this->getCodigoDoItem();
    $json['valor'] = $this->getValor();
    $json['quantidade'] = $this->getQuantidade();
  }

  public function cadastrar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("insert into Produtos (codigo_do_item, valor, quntidade )values(?,?,?)");
    $stmt->bind_param("sff", $this->codigoDoItem, $this->valor, $this->quantidade);
    $resposta = $stmt->execute();
    $idCadastrado = $this->banco->getConexao()->insert_id;
    $this->setIdProdutos($idCadastrado);
    return $resposta;
  }

  public function excluir()
  {
    $stmt = $this->banco->getConexao()->prepare("delete from Produtos where idProdutos = ?");
    $stmt->bind_param("i", $this->idProdutos);
    return $stmt->execute();
  }

  public function atualizar()
  {
    $stmt = $this->banco->getConexao()->prepare("update Produtos
    set nome=?,
    telefone=?,
    cpf=?,
    where idProdutos = ?");
    $stmt->bind_param("sfii", $this->codigoDoItem, $this->valor, $this->quantidade, $this->idProdutos);
    $stmt->execute();
  }

  public function buscar($idProdutos)
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("select * from Produtos where idProdutos = ?");
    $stmt->bind_param("i", $idProdutos);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($linha = $resultado->fetch_object()) {
      $this->setIdProdutos($linha->idProdutos);
      $this->setCodigoDoItem($linha->codigo_do_item);
      $this->setValor($linha->valor);
      $this->setQuantidade($linha->quantidade);
    }
    return $this;
  }

  public function listar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("Select * from Produtos");
    $stmt->execute();
    $result = $stmt->get_result();
    $vetorProdutoss = array();
    $i = 0;
    while ($linha = mysqli_fetch_object($result)) {
      $vetorProdutoss[$i] = new Produtos();
      $this->setIdProdutos($linha->idProdutos);
      $this->setCodigoDoItem($linha->codigo_do_item);
      $this->setValor($linha->valor);
      $this->setQuantidade($linha->quantidade);
      $i++;
    }
    return $vetorProdutoss;
  }
}
