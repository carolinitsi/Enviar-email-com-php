<?php
 include_once("funcoes.php");

 if (isset($_POST['cadastrar'])){
	$email=$_POST['email'];
	$senha=$_POST['senha'];
			
	$query = "insert into usuarios (email, senha) values (?,?)";
    $array = array($email, $senha);
    $usuario=fazConsulta($query,'query',$array);
    if($usuario)
    {
        echo"Usuario Cadastrado com Sucesso";

    }
    else
    {
        echo"Erro ao inserir";
    }
    
}


 if (isset($_POST['login']))
 {
     session_start();
 
     $email=$_POST["email"];
     $senha=$_POST["senha"];
 
     if (!(empty($email) OR empty($senha))) // testa se os campos do formulário não estão vazios
     {
          $array = array($email,$senha);
 
          $query= "select * from usuarios where email=? and senha=?";
 
          $resultado=ConsultaSelect($query,$array);
 
         if ($resultado) // testa se retornou uma linha de resultado da tabela pessoa com email e senha válidos
         {
         $_SESSION["logado"]=true; // armazena TRUE na variável de sessão logado
         $_SESSION["email"]=$email; // armazena na variável de sessão email o conteúdo do campo email do formulário
         $_SESSION["id"]=$resultado['id'];		
 
         header("Location:contato.html"); 
         }
         else
         {
             $_SESSION["msg"]="Usuário ou senha inválidos";
             header("Location:ops.html");
         }
     }
     else 
     {
         $_SESSION["msg"]="Preencha campos email e senha"; 
         header("Location:login.php"); 
     }
 }
 

#ENVIAR MENSAGEM

if (isset($_POST['enviar'])) 
{
    //AQUI DEFINI O ADM DO "SITE", QUEM RECEBE O EMAIL.
    $email_destinatario = "caroline.oliveira1800@gmail.com";
    $email_remetente    = $_POST['email_remetente'];
    $mensagem = $_POST['mensagem'];
    $assunto = [''];

    enviaEmail($email_destinatario, $email_remetente, $mensagem, $assunto);
}
?>