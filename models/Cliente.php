<?php
include "../Banco.php";

class Cliente implements JsonSerializable
{
  private $idCliente;
  private $nome;
  private $telefone;
  private $cpf;
  private $banco;

  function __construct()
  {
  }

  public function getIdCliente()
  {
    return $this->idCliente;
  }

  public function getNome()
  {
    return $this->nome;
  }
  public function getTelefone()
  {
    return $this->telefone;
  }

  public function getCpf()
  {
    return $this->cpf;
  }



  public function setCpf($cpf)
  {
    $this->cpf = $cpf;
  }

  public function setIdCliente($idCliente)
  {
    $this->idCliente = $idCliente;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function setTelefone($telefone)
  {
    $this->telefone = $telefone;
  }

  public function jsonSerialize()
  {
    $json = array();
    $json['idCliente'] = $this->getIdCliente();
    $json['nome'] = $this->getNome();
    $json['cpf'] = $this->getCpf();
    $json['telefone'] = $this->getTelefone();
  }

  public function cadastrar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("insert into Cliente (nome, telefone,cpf )values(?,?,?)");
    $stmt->bind_param("sss", $this->nome, $this->telefone, $this->cpf);
    $resposta = $stmt->execute();
    $idCadastrado = $this->banco->getConexao()->insert_id;
    $this->setIdCliente($idCadastrado);
    return $resposta;
  }

  public function excluir()
  {
    $stmt = $this->banco->getConexao()->prepare("delete from Cliente where idCliente = ?");
    $stmt->bind_param("i", $this->idCliente);
    return $stmt->execute();
  }

  public function atualizar()
  {
    $stmt = $this->banco->getConexao()->prepare("update cliente
    set nome=?,
    telefone=?,
    cpf=?,
    where idCliente = ?");
    $stmt->bind_param("sssi", $this->nome, $this->telefone, $this->cpf, $this->idCliente);
    $stmt->execute();
  }

  public function buscar($idCliente)
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("select * from cliente where idCliente = ?");
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($linha = $resultado->fetch_object()) {
      $this->setIdCliente($linha->idCliente);
      $this->setNome($linha->nome);
      $this->setTelefone($linha->email);
      $this->setCpf($linha->senha);
    }
    return $this;
  }

  public function listar()
  {
    $this->banco = new Banco();
    $stmt = $this->banco->getConexao()->prepare("Select * from Cliente");
    $stmt->execute();
    $result = $stmt->get_result();
    $vetorClientes = array();
    $i = 0;
    while ($linha = mysqli_fetch_object($result)) {
      $vetorClientes[$i] = new Cliente();
      $vetorClientes[$i]->setIdCliente($linha->idCliente);
      $vetorClientes[$i]->setNome($linha->nome);
      $vetorClientes[$i]->setTelefone($linha->telefone);
      $vetorClientes[$i]->setCpf($linha->cpf);
      $i++;
    }
    return $vetorClientes;
  }
}
