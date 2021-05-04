<?php
//ECHO DE TESTE
echo("chamou o arquivo");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";

function fazconexao(){
    //charset=utf8; previne SQL INJECTION!!!!
    $stringDeConexao = 'mysql:host=localhost;charset=utf8;dbname=bancoatv3;';
    $usuario = 'root';
    $senha = '';
    //conexao via PDO
    //try = tenta fazer o que há no bloco
    try{
        $link = new PDO($stringDeConexao,$usuario,$senha);
         $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $link;
        } //caso de algum erro, executa o catch
    catch(PDOException $ex){
    //encerra e apresenta mensagem de erro
    die($ex->getMessage());
    }

}
function fazConsulta($sql,$parametros=array()){
    try {
          //conecta
        $conexaoBD = fazConexao();
        //cria o objeto de consulta
        $consulta = $conexaoBD->prepare($sql);
        //testa se foram passados parâmetros
        
    
            $resultado=$consulta->execute($parametros);
            
            return $resultado;
    }
    catch (PDOException $e) {
        return($e);
    }
}

function ConsultaSelect($sql,$parametros=array()){
    try {
        //conecta
        $conexaoBD = fazConexao();
        //cria o objeto de consulta
        $consulta = $conexaoBD->prepare($sql);
        //executa a consulta
        if (sizeof($parametros) > 0) { 
           $result = $consulta->execute($parametros);
        } 
        else{

            $result = $consulta->execute();
        }  

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return($resultado);
    }
    catch (PDOException $e) {
        return($e);
    }
}

function enviaEmail($email_destinatario,$email_remetente, $mensagem, $assunto)
{
   
    // instanciando a classe
    $mail = new PHPMailer();
    // habilitando SMTP	
    $mail->isSMTP();
    // habilitando tranferêcia segura 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPDebug = 0; // Debug

    // habilitando autenticação	
    $mail->SMTPAuth = true;

    // Configurações para utilização do SMTP do Gmail 
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // porta gmail
    $mail->SMTPOptions = [
     'ssl' => [
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true,
        ]
    ];

    $mail->Username = 'contato.modarocker@gmail.com'; ////Usuário para autenticação 
    $mail->Password = '@amanha27'; //senha autenticação

// Remetente da mensagem - sempre usar o mesmo usuário da autenticação  
    $mail->setFrom('contato.modarocker@gmail.com','Atividade 3');
// Endereço de destino do email
    $mail->addAddress($email_destinatario);
    $mail->CharSet = "utf-8";
// Endereço para resposta
    $mail->addReplyTo($email_remetente);
// Assunto e Corpo do email
    $mail->Subject = $assunto;
    $mail->Body = $mensagem;
// Enviando o email
    if (!$mail->send()) {
        $retorno=false;
    } else {
        $retorno= $mensagem;
    }

    return $retorno;
}
header("Location:contato.html");
?>