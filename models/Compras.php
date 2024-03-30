<?php
include "../Banco.php";

class Compras implements JsonSerializable
{
    private $idCompras;
    private $cliente;
    private $produtos;
    private $quantidade;
    private $banco;

    function __construct()
    {
    }

    public function getIdCompras()
    {
        return $this->idCompras;
    }

    public function getCliente()
    {
        return $this->cliente;
    }
    public function getProdutos()
    {
        return $this->produtos;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }



    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function setIdCompras($idCompras)
    {
        $this->idCompras = $idCompras;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;
    }

    public function jsonSerialize()
    {
        $json = array();
        $json['idCompras'] = $this->getIdCompras();
        $json['cliente'] = $this->getCliente();
        $json['produtos'] = $this->getProdutos();
        $json['quantidade'] = $this->getQuantidade();
    }

    public function cadastrar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("insert into Compras (cliente, produto, quantidade )values(?,?,?)");
    $stmt->bind_param("iii", $this->cliente, $this->produtos, $this->quantidade);
    $resposta = $stmt->execute();
    $idCompras = $this->banco->getConexao()->insert_id;
    $this->setIdCompras($idCompras);
    return $resposta;
  }

  public function excluir()
  {
    $stmt = $this->banco->getConexao()->prepare("delete from Compras where idCompras = ?");
    $stmt->bind_param("i", $this->idCompras);
    return $stmt->execute();
  }

  public function atualizar()
  {
    $stmt = $this->banco->getConexao()->prepare("update Compras
    set cliente=?,
    produtos=?,
    quantidade=?,
    where idCompras = ?");
    $stmt->bind_param("iiii", $this->cliente, $this->produtos, $this->quantidade, $this->idCompras);
    $stmt->execute();
  }

  public function buscar($idCliente)
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("select * from Compras where idCompras = ?");
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($linha = $resultado->fetch_object()) {
      $this->setIdCompras($linha->getIdCompras);
      $this->setCliente($linha->cliente);
      $this->setProdutos($linha->produtos);
      $this->setQuantidade($linha->quantidade);
    }
    return $this;
  }

  public function listar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("Select * from Compras");
    $stmt->execute();
    $result = $stmt->get_result();
    $vetorClientes = array();
    $i = 0;
    while ($linha = mysqli_fetch_object($result)) {
      $vetorClientes[$i] = new Compras();
      $vetorClientes[$i]->setIdCompras($linha->getIdCompras);
      $vetorClientes[$i]->setCliente($linha->cliente);
      $vetorClientes[$i]->setProdutos($linha->produtos);
      $vetorClientes[$i]->setQuantidade($linha->quantidade);
      $i++;
    }
    return $vetorClientes;
  }
}
