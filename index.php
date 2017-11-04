<?php 

require_once("config.php");

// Carrega um usuário
// $root = new Usuario();
// $root->loadById(1);
// echo $root;

// Carrega uma lista de usuários
// $lista = Usuario::getList();
// echo json_encode($lista);


// Carrega uma lista de usuários buscando pelo login
// $search = Usuario::search("ano");
// echo json_encode($search);


// Carrega um usuário usando o login e a senha
// $usuario = new Usuario();
// $usuario->login("Fulano", "11223344");
// echo $usuario; 

// Criando um novo usuário
// $aluno = new Usuario("Aluno", "123456");
// $aluno->insert();
// echo $aluno; 

// Alterando um usuário pelo seu ID
// $usuario = new Usuario();
// $usuario->loadById(4);
// $usuario->update("Beltrano", "09876543"); 
// echo $usuario;

// Deletando um usuário pelo seu ID
$usuario = new Usuario();
$usuario->loadById(5);
$usuario->delete(); 
echo $usuario;
 ?>