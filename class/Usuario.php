<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario(){

		return $this->idusuario;

	}

	public function setIdusuario($idusuario){

		$this->idusuario = $idusuario;

	}

	public function getDeslogin(){

		return $this->deslogin;

	}

	public function setDeslogin($deslogin){

		$this->deslogin = $deslogin;

	}

	public function getDessenha(){

		return $this->dessenha;

	}

	public function setDessenha($dessenha){

		$this->dessenha = $dessenha;

	}

	public function getDtcadastro(){

		return $this->dtcadastro;

	}

	public function setDtcadastro($dtcadastro){

		$this->dtcadastro = $dtcadastro;

	}

	// Carregar um usuário pelo ID
	public function loadById($id){

		$sql = new Sql();

		$results = $sql -> select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

		if (count($results) > 0) {
			
			$this->setData($results[0]);

		}

	}

	// Carregar uma lista de usuário
	public static function getList() {

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

	}

	// Carregar um usuário pelo seu login
	public static function search($login){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH'=>"%".$login."%"));

	}

	// Carregar um usuário pelo seu login e senha, caso seja algum usuário 
	// que não exista no banco, será mostrado uma mensagem de erro
	public function login($login, $password){

		$sql = new Sql();

		$results = $sql -> select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			":LOGIN"=>$login, 
			":PASSWORD"=>$password
		));

		if (count($results) > 0) {
			
			$this->setData($results[0]);

		} else {

			throw new Exception("Login e/ou senha inválidos!");
		
		}

	} 

	// Método para chamar todos os dados de um usuário		
	public function setData($data) {

			$this->setIdusuario($data['idusuario']);
			$this->setDeslogin($data['deslogin']);
			$this->setDessenha($data['dessenha']);
			$this->setDtcadastro(new DateTime($data['dtcadastro']));

	}

	// Método para inserir um usuário no banco atráves de um PROCEDURE
	// Criada no banco de dados, passando como parâmetros LOGIN e SENHA
	public function insert(){

		$sql = new Sql();

		$results =  $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(), 
			':PASSWORD'=>$this->getDessenha()
		));

		if (count($results) > 0) {
			$this->setData($results[0]); 
		}

	}

	// Método para alterar dados de um usuário passando como parâmetros
	// LOGIN e SENHA
	public function update($login, $password) {

		$this->setDeslogin($login);
		$this->setDessenha($password);
		
		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(':LOGIN'=>$this->getDeslogin(), ':PASSWORD'=>$this->getDessenha(), ':ID'=>$this->getIdusuario()));

	}

	// Método para deletar um usuário pelo seu ID
	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());

	}

	public function __construct($login = "", $password = ""){

		$this->setDeslogin($login);
		$this->setDessenha($password);

	}

	public function __toString() {

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		));

	}

}

 ?>