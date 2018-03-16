<?php
include_once '../../includes/db.php';
switch ($_POST['acao']) {
	//LISTA MESAS
	case 'ListaMesas':
		$loja = $_POST['loja'];
		 //SELECIONA MESAS
        $SelMesas = $pdo->prepare("SELECT * FROM cdmesa000 WHERE mesa_loja = ".$loja);
        $SelMesas->execute();
        $FetMesas = $SelMesas->fetchAll(PDO::FETCH_OBJ);
        foreach($FetMesas as $m):
            if ($m->mesa_status == 1) {
                $img = '../../img/mesas/AbertaVerde.png';
                $alt = "Mesa aberta";
            }elseif($m->mesa_status == 2){
                $img = '../../img/mesas/Ocupada.png';
                $alt = 'Mesa ocupada';
            }else{
                $img = '../../img/mesas/Fechamento.png';
                $alt = 'Mesa em fechamento';
            }
	        ?>
	        <div class="col s4 m3 l1 image">
	        	<a class="eOpt" id="<?=$m->mesa_cod?>" st="<?=$m->mesa_status?>">
		            <img src="<?=$img?>" width="100%" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?=$alt?>">
		            <figcaption><?=$m->mesa_cod?></figcaption>
		        </a>
	        </div>
	        <?php
    	endforeach;
	break;
	
	//SOLICITA FECHAMENTO DE MESA
	case 'SolicitaFechamento':
		$MesaCod = $_POST['mesa_cod'];
		$loja 	 = $_POST['loja'];
		$caixa 	 = $_POST['caixa'];
		// VERIFICA SE MESA JA NAO ESTA COM STATUS  = 3
		$SelMesa = $pdo->prepare('SELECT mesa_status FROM cdmesa000 WHERE mesa_cod = '.$MesaCod.' and mesa_loja = '.$loja);
		$SelMesa->execute();
		$FetMesa = $SelMesa->fetchAll(PDO::FETCH_OBJ);
		foreach($FetMesa as $m):
			$MesaStatus = $m->mesa_status;
		endforeach;
		if ($MesaStatus <> 3) {
			// ALTERA STATUS DA MESA PARA 3
			$AltStatus = $pdo->prepare('UPDATE cdmesa000 SET mesa_status = 3 WHERE mesa_cod = '.$MesaCod.' and mesa_loja = '.$loja);
			if ($AltStatus->execute()) {
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 3;
		}
	break;

	//ABRE MESA
	case 'AbrirMesa':
		$MesaCod = $_POST['mesa_cod'];
		$loja 	 = $_POST['loja'];
		$caixa 	 = $_POST['caixa'];
		$usucod  = $_POST['usucod'];

		//ALTERA O STATUS DA MESA PARA OCUPADO (2)
		$AltStatus = $pdo->prepare('UPDATE cdmesa000 SET mesa_status = 2 WHERE mesa_cod = '.$MesaCod.' and mesa_loja = '.$loja);
		if ($AltStatus->execute()) {
			$sql = 'INSERT INTO cdvnd000(vnd_mesa, vnd_usu, vnd_caixa, vnd_loja, vnd_enc) VALUES ("'.$MesaCod.'", "'.$usucod.'" , "'.$caixa.'", "'.$loja.'", "N")';
			$InsereVenda = $pdo->prepare($sql);
			if ($InsereVenda->execute()) {
				echo 1;
			}
		}
	break;

	//ABRE CAIXA
	case 'AbreCaixa':
		$usucod = $_POST['usucod'];
		$valor = $_POST['valor'];
		$loja = $_POST['loja'];

		// ABRE CAIXA
		$AbreCaixa = $pdo->prepare("INSERT INTO cdcai000 (caival, caiusu, cailoja) VALUE('".$valor."', '".$usucod."', '".$loja."')");
		if ($AbreCaixa->execute()) {
			echo 1;
		}


		// MUDA STATUS DE TODAS AS MESAS PARA 1
		$UpStatus = $pdo->prepare("UPDATE cdmesa000 SET mesa_status = 1");
		$UpStatus->execute();


		// MUDA STATUS DE TODAS ENCERRA TODAS AS VENDAS
		$UpVnd = $pdo->prepare("UPDATE cdvnd000 SET vnd_enc = 'S'");
		$UpVnd->execute();

	break;

	//LISTA PRODUTOS DA MESA
	case 'ListaProdutosMesa':
	?>
		<table class="striped">
		    <thead>
		        <tr>
		            <th>Produto</th>
		            <th>Quantidade</th>
		            <th>Valor Un.</th>
		    	</tr>
		    </thead>
		    <tbody>

	<?php
		$MesaCod = $_POST['MesaCod'];
		$loja 	 = $_POST['loja'];
		$caixa 	 = $_POST['caixa'];
		//echo 'M '.$MesaCod.' | L: '.$loja.' | C: '.$caixa;

		//SELECIONA OS PRODUTOS DESSA MESA
		$ListaProdutosDaMesa = $pdo->prepare("SELECT * FROM cdvnd000 v join cdvnd00p p ON p.vnd_cod = v.vnd_cod and v.vnd_mesa = :mesa and v.vnd_loja = :loja and v.vnd_caixa = :caixa and v.vnd_enc = 'N'");
		$ListaProdutosDaMesa->bindParam(':mesa', $MesaCod);
		$ListaProdutosDaMesa->bindParam(':loja', $loja);
		$ListaProdutosDaMesa->bindParam(':caixa', $caixa);
		$ListaProdutosDaMesa->execute();

		$FetListaProdutosDaMesa = $ListaProdutosDaMesa->fetchAll(PDO::FETCH_OBJ);
		$c = 0;
		$soma = array();
		foreach ($FetListaProdutosDaMesa as $p) {
			
			$soma[$c] = $p->vnd_qnt * $p->vnd_val_unit;
			?>
		        <tr>
		          <td><?=$p->vnd_prod_nome?></td>
		          <td><?=$p->vnd_qnt?></td>
		          <td><b style="color: #247E20FF;">R$ <?=str_replace('.',',',$p->vnd_val_unit)?></b></td>
		        </tr>

			<?php
			$c++;
		}
		?>
		
		    </tbody>
		</table>
		<?php
		$total = array_sum($soma);
		echo '<b>Total: </b><strong style="font-size: 20pt; color: #EA0000FF;">R$ '.number_format($total, 2, ',', '.').'</strong>';
	break;



	//LISTA PRODUTOS DA COMANDA
	case 'ListaProdutosCom':
	?>
		<table class="striped">
		    <thead>
		        <tr>
		            <th>Produto</th>
		            <th>Quantidade</th>
		            <th>Valor Un.</th>
		            <th>#</th>
		    	</tr>
		    </thead>
		    <tbody>

	<?php
		$MesaCod = $_POST['MesaCod'];
		$loja 	 = $_POST['loja'];
		$caixa 	 = $_POST['caixa'];
		//echo 'M '.$MesaCod.' | L: '.$loja.' | C: '.$caixa;

		//SELECIONA OS PRODUTOS DESSA MESA
		$ListaProdutosDaComanda = $pdo->prepare("SELECT * FROM cdvnd000 v join cdcom000 c ON c.com_vnd = v.vnd_cod and v.vnd_mesa = :mesa and v.vnd_loja = :loja and v.vnd_caixa = :caixa and v.vnd_enc = 'N'");
		$ListaProdutosDaComanda->bindParam(':mesa', $MesaCod);
		$ListaProdutosDaComanda->bindParam(':loja', $loja);
		$ListaProdutosDaComanda->bindParam(':caixa', $caixa);
		$ListaProdutosDaComanda->execute();

		$FetListaProdutosDaComanda = $ListaProdutosDaComanda->fetchAll(PDO::FETCH_OBJ);
		$c = 0;
		$soma = array();
		foreach ($FetListaProdutosDaComanda as $p) {
			
			$soma[$c] = $p->com_qnt * $p->com_val_unit;
			?>
		        <tr>
		          <td><?=$p->com_prod_nome?></td>
		          <td><?=$p->com_qnt?></td>
		          <td><b style="color: #247E20FF;">R$ <?=str_replace('.',',',$p->com_val_unit)?></b></td>
		          <td><a class="btnRemoveItem" cod="<?=$p->com_cod?>"><i class="fa fa-times" style="color: red; font-size: 12pt;"></i></a></td>
		        </tr>

			<?php
			$c++;
		}
		?>
		
		    </tbody>
		</table>
		<?php
		$total = array_sum($soma);
		echo '<b>Total: </b><strong style="font-size: 20pt; color: #EA0000FF;">R$ '.number_format($total, 2, ',', '.').'</strong>';
	break;


	//PESQUISA DE PRODUTOS PARA INSERIR NA COMANDA
	case 'pesquisaproduto':
		?>
		<table class="striped">
		    <thead>
		        <tr>
		            <th>#</th>
		            <th>Produto</th>
		            <th>Valor Un.</th>
		    	</tr>
		    </thead>
		    <tbody>

	<?php
		$termo = $_POST['termo'];
		$loja = $_POST['loja'];
		$mesa = $_POST['mesa'];

		//SELECIONA OS PRODUTOS
		$PesquisaProduto = $pdo->prepare("SELECT * FROM cdprod000 WHERE (prod_nome like '%".$termo."%' or prod_cod like '%".$termo."%') and prod_loja = ".$loja);
		$PesquisaProduto->execute();
		$FetPesquisaProduto = $PesquisaProduto->fetchAll(PDO::FETCH_OBJ);
		foreach ($FetPesquisaProduto as $p) {
			?>
		        <tr>
		          <td><?=$p->prod_cod?></td>
		          <td><?=$p->prod_nome?></td>
		          <td><b style="color: #247E20FF;">R$ <?=str_replace('.',',',$p->prod_valor_unit)?></b></td>
		          <td><a class="btnAbreModalQnt" nome="<?=$p->prod_nome?>" loja="<?=$loja?>" mesa="<?=$mesa?>" cod="<?=$p->prod_cod?>"><i class="fa fa-plus-square" style="color: #21D801FF; font-size: 12pt;"></i></a></td>
		        </tr>

			<?php
		}
		?>
		
		    </tbody>
		</table>
		<?php
	break;
	case 'addprodutocom':
		$loja = $_POST['loja'];
		$mesa = $_POST['mesa'];
		$prodCod = $_POST['prodCod'];
		$qnt = $_POST['qnt'];

		//SELECIONA O PRODUTO
		$SelecionaProduto = $pdo->prepare('SELECT * FROM cdprod000 WHERE prod_cod = '.$prodCod.' and prod_loja = '.$loja);
		$SelecionaProduto->execute();
		$FetSelecionaProduto = $SelecionaProduto->fetchAll(PDO::FETCH_OBJ);
		foreach ($FetSelecionaProduto as $p) {
			$prod_nome = $p->prod_nome;
			$prod_valor_unit = $p->prod_valor_unit;
		}


		//SELECIONA A VENDA
		$SelVenda = $pdo->prepare('SELECT * FROM cdvnd000 WHERE vnd_mesa = '.$mesa.' and vnd_enc <> "S" order by vnd_data desc limit 1');
		$SelVenda->execute();
		$FetVenda = $SelVenda->fetchAll(PDO::FETCH_OBJ);
		foreach ($FetVenda as $v) {
			$vnd_cod = $v->vnd_cod;
		}

		//INSERE PRODUTO NA VENDA DA MESA
		$InsereProduto = $pdo->prepare("INSERT INTO cdcom000 (com_vnd, com_prod_nome, com_prod, com_qnt, com_val_unit) VALUES('".$vnd_cod."', '".$prod_nome."', '".$prodCod."', '".$qnt."', '".$prod_valor_unit."')");
		if($InsereProduto->execute()){
			echo 1;
		}
	break;
	case 'removeitem':
		$codItem = $_POST['codItem'];
		//EXCLUI ITEM
		$ExcluiItem = $pdo->prepare('DELETE FROM cdcom000 WHERE com_cod = '.$codItem);
		if ($ExcluiItem->execute()) {
			echo 1;
		}
	break;
	case 'insereprodcomandamesa':
		$loja = $_POST['loja'];
		$mesa = $_POST['mesa'];

		//SELECIONA A VENDA
		$SelVenda = $pdo->prepare('SELECT * FROM cdvnd000 WHERE vnd_mesa = '.$mesa.' and vnd_enc <> "S" order by vnd_data desc limit 1');
		$SelVenda->execute();
		$FetVenda = $SelVenda->fetchAll(PDO::FETCH_OBJ);
		foreach ($FetVenda as $v) {
			$vnd_cod = $v->vnd_cod;
		}

		//SELECIONA OS PRODUTOS DA COMANDA DESTA MESA
		$SelProdComMesa = $pdo->prepare("SELECT * FROM cdcom000 WHERE com_vnd = ".$vnd_cod);
		$SelProdComMesa->execute();
		$FetProdComMesa = $SelProdComMesa->fetchAll(PDO::FETCH_OBJ);
		foreach ($FetProdComMesa as $p) {
			// INSERE PRODUTOS NA MESA
			$InsProdMesa = $pdo->prepare("INSERT INTO cdvnd00p(vnd_cod, vnd_prod_nome, vnd_prod, vnd_qnt, vnd_val_unit, vnd_data)VALUES('".$p->com_vnd."', '".$p->com_prod_nome."', '".$p->com_prod."', '".$p->com_qnt."', '".$p->com_val_unit."', '".$p->com_data."')");
			if ($InsProdMesa->execute()) {
				//DELETA PRODUTOS DA COMANDA
				$DelProdCom = $pdo->prepare("DELETE FROM cdcom000 WHERE com_vnd = ".$vnd_cod);
				
				if ($DelProdCom->execute()) {
					echo 1;
				}else{
					echo 'erro';
				}
			}
			
		}
	break;
	default:
		# code...
		break;
}
?>