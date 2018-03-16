<?php
include_once "../../includes/db.php";
session_start();
ob_start();
$senha = $_POST['senha'];
//echo $senha;
//LOGA
$SelUsu = $pdo->prepare("SELECT * FROM cdusu000 u join cdloj000 l on l.loj_cod = u.usuloja and u.ususen = '".$senha."'");
$SelUsu->execute();
if ($SelUsu->rowCount() > 0) {
	$FetUsu = $SelUsu->fetchAll(PDO::FETCH_OBJ);
	foreach($FetUsu as $u):
		$_SESSION['logado'] = true;
		$_SESSION['usucod'] = $u->usucod;
		$_SESSION['usunom'] = $u->usunom;
		$_SESSION['usuniv'] = $u->usuniv;
		$_SESSION['usuloja'] = $u->usuloja;
		$_SESSION['lojanome'] = $u->loj_nome;
		//echo $u->usucod;
		header("Location: ../dashboard");
	endforeach;
}else{
	header("Location: index.php?erro=true");
}

?>