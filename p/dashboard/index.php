<?php
header ('Content-type: text/html; charset=UTF-8');
    $CaixaAbertoCOD = 0;
    include_once '../../includes/db.php';
    session_start();
      $nome = $_SESSION['usunom'];
      $usuniv = $_SESSION['usuniv'];
      $usucod = $_SESSION['usucod'];
      $usuloja = $_SESSION['usuloja'];
      $loja = $_SESSION['lojanome'];
    if ($_SESSION['logado'] == false) {
      header("Location: ../login");
    }

    $DataHjj = date("Y-m-d");
    $CxAbOTT = $pdo->prepare("SELECT * from cdcai000 c where c.caidatab not like '%".$DataHjj."%' and c.caist = 0 and cailoja = ".$usuloja);
    $CxAbOTT->execute();
    function VerificaCaixa($usuloja){
      include '../../includes/db.php';
      // VERIFICA SE CAIXA ESTA ABERTO
        $DataHj = date("Y-m-d");
        $CxAb = $pdo->prepare("SELECT * FROM cdcai000 WHERE caidatab like '%".$DataHj."%' and caist = 0 and cailoja = ".$usuloja);
        $CxAb->execute();
        if ($CxAb->rowCount() > 0) {
          return true;
        }else{
          $CxAbO = $pdo->prepare("SELECT * from cdcai000 c where c.caidatab not like '%".$DataHj."%' and c.caist = 0 and cailoja = ".$usuloja);
          $CxAbO->execute();
          if ($CxAbO->rowCount() > 0) {
            $FetCxAbO =$CxAbO->fetchAll(PDO::FETCH_OBJ);
            foreach($FetCxAbO as $co):
              $CaiCod = $co->caicod;
            endforeach;

            return false;
          }else{
            return false;
          }
        }
    }
   VerificaCaixa($usuloja);


  //PEGA CAIXA QUE ESTA ABERTO
  $SelCaixaAberto = $pdo->prepare("SELECT * FROM cdcai000 c WHERE c.caist = 0 and cailoja = ".$usuloja);
  $SelCaixaAberto->execute();
  $FetCaixaAberto = $SelCaixaAberto->fetchAll(PDO::FETCH_OBJ);
  foreach($FetCaixaAberto as $cx):
    @$CaixaAbertoCOD = $cx->caicod;
    @$CaixaAbertoDAT = $cx->caidatab;
  endforeach;
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Food - Automaçao de Restaurantes e Hotéis</title>

  <!-- CSS  -->
  <link href="../../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" type="text/css" href="../../assets/font-awesome-4.7.0/css/font-awesome.css">
  <style>
            .image {
              display: inline-block;
              position: relative;
            }

            .image figcaption {
              position: absolute;
              top: 15px;
              right: 20px;
              font-size: 30px;
              color: white;
              text-shadow: 0px 0px 5px blue;
            }
            body{
                background-image: url('../../img/backgrounds/bg2.jpg');
                background-repeat: repeat-y;
                background-size:100%;
            }
   </style>
</head>
<body>
  <div class="navbar" style="">
    <nav class="light-blue lighten-1" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"><i class="fa fa-user"></i> <?=$nome?></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="../login" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="SAIR"><i class="fa fa-power-off" aria-hidden="true" style="font-size: 40px;"></i></a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="../login" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="SAIR"><i class="fa fa-power-off" aria-hidden="true"></i> SAIR</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fas fa-user">menu</i></a>
      </div>
    </nav>
  </div>
  <div class="container">
      <div class="row"> 
        <div class="col s12">
          <?php @$DataCaixa = substr($CaixaAbertoDAT, 0, 10); ?>
          <h5 style="text-align: right; color: white;">CAIXA: <?=@date('d/m/Y', strtotime($CaixaAbertoDAT))?> <?=@substr($CaixaAbertoDAT, -8)?> | <?=$loja?></h5>
        </div>
      </div> 
  </div>
  <div class="container mesas">
    <?php if (VerificaCaixa($usuloja)): ?>
        <div class="row lista-mesas">
        </div>
    <?php else: ?>
      <?php if (VerificaCaixa($usuloja) == false and $CxAbOTT->rowCount() > 0): ?>
        <div class="row lista-mesas">
        </div>
      <?php else: ?>
        <h2>CAIXA FECHADO</h2>
      <?php endif; ?>
    <?php endif; ?>
  </div>
    <!-- Modal abrir caixa -->
      <div id="AbreCaixa" class="modal">
          <div class="modal-content">
            <h4>ABRIR CAIXA!</h4>
              <div class="row">
                 <div class="col s12">
                    <input type="number" name="valor" placeholder="Valor inicial" autocomplete="false">
                 </div>
              </div>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat BtAbrir">Abrir</a>
          </div>
      </div>
    <!-- //Modal abrir caixa -->
	  <!-- Modal Funcoes MEsa -->
	  <div id="FuncVnd" class="modal">
	    <div class="modal-content">
	      <h4>Mesa <span class="CodMesaTitulo"></span></h4>
	      	<div class="row">
	      	   <div class="col s6">

  		      	<a class="waves-effect waves-light btn-large tooltipped btnAbreCom" data-position="bottom" data-delay="50" data-tooltip="Novo Pedido" style="width: 100%"><i class="fa fa-shopping-cart" style="font-size: 40px"></i></a>

  		       </div>
  		       <div class="col s6">
  		      	<a class="waves-effect waves-light btn-large tooltipped SolFec" data-position="bottom" data-delay="50" data-tooltip="Solicitar fechamento" style="width: 100%"><i class="fa fa-close" style="font-size: 40px"></i></a>
  		       </div>
             <div class="col s12">
             <hr>
               <div class="listaProdutos">
                 
               </div>
             </div>
	        </div>
	    </div>
	    <div class="modal-footer">
	    	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
	    </div>
	  </div>
	  <!-- //Modal Funcoes MEsa -->
    <!-- Modal Funcoes ABERTURA MESA -->
    <div id="FuncVndf" class="modal">
      <div class="modal-content">
        <h4>Mesa <span class="CodMesaTitulo"></span></h4>
          <div class="row">
             <div class="col s12">
                <a class="waves-effect waves-light btn-large tooltipped AbrirMesa" data-position="bottom" data-delay="50" data-tooltip="Abrir mesa" style="width: 100%"><i class="fa fa-lock" style="font-size: 40px"></i></a>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      </div>
    </div>
    <!-- //Modal Funcoes ABERTURA MESA -->
    <!-- MODAL COMANDA MESA -->
    <div id="mComMesa" class="modal">
      <div class="modal-content">
        <h4>Comanda Mesa <span class="idMesa"></span></h4>
          <div class="row">
            <div class="col s12">
              <a class="waves-effect waves-light btn-large tooltipped AddProd" data-position="bottom" data-delay="50" data-tooltip="Adicionar produto" style="width: 100%"><i class="fa fa-shopping-cart" style="font-size: 40px"></i></a>
            </div>
            <div class="listaProdutosCom">
              
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
        <a class="waves-effect waves-green btn-flat btnLancarProd">Lançar</a>
      </div>
    </div>
    <!-- // MODAL COMANDA MESA -->
    <!-- MODAL  PRODUTOS -->
    <div id="mAddProd" class="modal">
      <div class="modal-content">
        <h4>Adicionar Produto | Mesa <span class="idMesa"></span></h4>
          <div class="row">
            <div class="col s12">
              <input type="text" class="inputPesquisa" name="pesquisa" class="form-control" placeholder="Digite o nome ou código do produto" autocomplete="false">
            </div>
            <div class="resultado-pesquisa">
              
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      </div>
    </div>
    <!-- // MODAL ADICIONAR PRODUTOS -->
    <!-- MODAL QUANTIDADE -->
    <div id="mQntProd" class="modal">
      <div class="modal-content">
        <h4>Produto: <span class="nProd"></span></h4>
          <div class="row">
            <div class="col s12">
              <label>Quantidade</label>
              <input type="number" class="inputQnt" name="pesquisa" class="form-control" autocomplete="false">
            </div>
            <a class="waves-effect waves-light btn-large tooltipped btnAddProd" data-position="bottom" data-delay="50" data-tooltip="Abrir mesa" style="width: 100%"><i class="fa fa-plus-circle" style="font-size: 40px"></i></a>
          </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      </div>
    </div>
    <!-- // MODAL QUANTIDADE -->
	  <!--  Scripts-->
    <button style="display: none;" class="btnAtcListaProdCom"></button>
    <button style="display: none;" class="btnAtcListaProdMesa"></button>
  <script type="text/javascript" src="../../js/jquery-3.2.1.js"></script>
  <script src="../../js/materialize.js"></script>
  <script src="../../js/init.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.js"></script>
  <script>
  	$(document).ready(function(){
   		 // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
   		 $('.modal').modal();
       Materialize.toast('Seja bem vindo novamente '+'<?=$nome?>', 5000, 'rounded');

        <?php if(VerificaCaixa($usuloja) == false and $CxAbOTT->rowCount() > 0): ?>
              Materialize.toast('CAIXA <?=date("d/m/Y", strtotime($CaixaAbertoDAT))?> <?=substr($CaixaAbertoDAT, -8)?> ABERTO!', 5000, 'rounded');
              Materialize.toast('CAIXA <?=date("d/m/Y", strtotime($CaixaAbertoDAT))?> <?=substr($CaixaAbertoDAT, -8)?> ABERTO!', 5000, 'rounded');
              Materialize.toast('CAIXA <?=date("d/m/Y", strtotime($CaixaAbertoDAT))?> <?=substr($CaixaAbertoDAT, -8)?> ABERTO!', 5000, 'rounded');
              Materialize.toast('CAIXA <?=date("d/m/Y", strtotime($CaixaAbertoDAT))?> <?=substr($CaixaAbertoDAT, -8)?> ABERTO!', 5000, 'rounded');
        <?php endif; ?>
       <?php if(VerificaCaixa($usuloja) == false and $CxAbOTT->rowCount() == 0 and $usuniv == 2): ?>
          $("#AbreCaixa").modal("open");

       <?php endif; ?>

      // ABRE CAIXA
      $(".BtAbrir").click(function(){
        var usucod = <?=$usucod?>;
        var valor = $("input[name='valor']").val();
        $.ajax({
          url:  'controler.php',
          type: 'POST',
          data:   'acao=AbreCaixa&usucod='+usucod+'&valor='+valor+'&loja='+<?=$usuloja?>,
          beforeSend: '',
          error:    '',
          success: function(retorno){
            //alert(retorno);
            if (retorno == 1) {
              Materialize.toast('Caixa aberto, aguarde...', 5000, 'rounded');
              setTimeout('location.reload();', 1000);
            }
          }
        });//*/
      });

      setInterval(function(){ ListaMesas(); }, 1000);

      //FUNCAO QUE LISTA MESAS
      function ListaMesas(){
        $.ajax({
          url:  'controler.php',
          type: 'POST',
          data:   'acao=ListaMesas&loja='+<?=$usuloja?>,
          beforeSend: '',
          error:    '',
          success: function(retorno){
            $(".lista-mesas").empty();
            $(".lista-mesas").html(retorno);

            //PREPARE MODAL FUNCOES VENDA
            $(".eOpt").click(function(){
              var id = $(this).attr("id");
              var status = $(this).attr("st");
              PrepareFuncoesVenda(id,status); //PREPARA OS  MODAIS CONFORME NECESSÁRIO
              ListaProdutosMesa(id,status,<?=$usuloja?>); //LISTA OS PRODUTOS DA MESA
              $('.inputPesquisa').val(''); //LIMPA O CAMPO DE PESQUISA DE PRODUTO
              $('.resultado-pesquisa').empty(); // LIMPA OS RESULTADOS DA PESQUISA DE PRODUTOS
            });

            //BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS DA COMANDA
            $(".btnAtcListaProdCom").click(function(){
              var id = $(this).attr('id');
               ListaProdutosComanda(id,0,<?=$usuloja?>);
            });

            //BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS DA MESA
            $(".btnAtcListaProdMesa").click(function(){
              var id = $(this).attr('id');
               ListaProdutosMesa(id,0,<?=$usuloja?>);
            });

            //LISTA OS PRODUTOS DA COMANDA
            function ListaProdutosComanda(id,status,loja){
              $.ajax({
                url:  'controler.php',
                type: 'POST',
                data:   'acao=ListaProdutosCom&MesaCod='+id+'&loja='+<?=$usuloja?>+'&caixa='+<?=$CaixaAbertoCOD?>,
                beforeSend: '',
                error:    '',
                success: function(retorno){
                  //alert(retorno);
                  $(".listaProdutosCom").empty();
                  $(".listaProdutosCom").html(retorno);

                    //BOTAO QUE REMOVE ITEM DA LISTA DA COMANDA
                    $(".btnRemoveItem").click(function(){
                      var codItem = $(this).attr('cod');
                      $.ajax({
                        url: 'controler.php',
                        type: 'POST',
                        data: 'acao=removeitem&codItem='+codItem,
                        beforeSend: '',
                        error: '',
                        success: function(retorno){
                          if(retorno == 1){
                            ListaProdutosComanda(id, 0, loja);
                          }
                        }
                      });
                    });


                  if (retorno == 3) {
                    Materialize.toast('Erro ao listar produtos', 5000, 'rounded');
                  }
                }
              });//*/
            }

            //LISTA OS PRODUTOS DA MESA
            function ListaProdutosMesa(id,status,loja){
              $.ajax({
                url:  'controler.php',
                type: 'POST',
                data:   'acao=ListaProdutosMesa&MesaCod='+id+'&loja='+<?=$usuloja?>+'&caixa='+<?=$CaixaAbertoCOD?>,
                beforeSend: '',
                error:    '',
                success: function(retorno){
                  //alert(retorno);
                  $(".listaProdutos").empty();
                  $(".listaProdutos").html(retorno);

                  if (retorno == 3) {
                    Materialize.toast('Erro ao listar produtos', 5000, 'rounded');
                  }
                }
              });//*/
            }


            function PrepareFuncoesVenda(id,status){ //FUNÇÃO DE ADAPTAÇAO DOS MODAIS
              //alert(status);
              if (status == 1) { //SE O STATUS DA MESA FOR 1 = ABERTA
                $(".CodMesaTitulo").empty();  // LIMPA TITULO DO MODAL

                $(".CodMesaTitulo").append(id); // INSERE O ID DA MESA NO TITULO DO MODAL

                $(".AbrirMesa").attr("id", ''); // LIMPA O ATRIBUTO ID DO BOTAO DE ABRIR MESA

                $(".AbrirMesa").attr("id", id); // INSERE ID DA MESA NO ATRIBUTO ID DO BOTAO DE ABRIR MESA

                $(".AbrirMesa").attr("st", status); // INSERE O STATUS DA MESA NO ATRIBUTO ST DO BOTAO DE ABRIR MESA
                $("#FuncVndf").modal('open'); // ABRE O MODAL DE MESA FECHADA (COM O BOTAO DE ABRIR MESA)
              }else{ //  SE O STATUS FOR DIFERENTE DE 1
                $(".CodMesaTitulo").empty(); // LIMPA TITULO DO MODAL
                $(".CodMesaTitulo").append(id); // INSERE O ID DA MESA NO TITULO DO MODAL

                $(".SolFec").attr("id",''); // LIMPA ATRIBUTO ID DO BOTAO DE SOLICITACAO DE FECHAMENTO
                $(".SolFec").attr("id",id); // INSERE O ID DA MESA NO ATRIBUTO ID DO BOTAO DE SOLITICACAO DE FECHAMENTO

                $(".btnAbreCom").attr("id", ''); // LIMPA ATRIBUTO ID DO BOTAO DE ABRIR NOVO PEDIDO
                $(".btnAbreCom").attr("id", id); // INSERE O ID DA MESA NO ATRIBUTO ID DO BOTAO DE ABRIR NOVO PEDIDO

                $(".btnAbreCom").attr("st", ''); // LIMPA ATRIBUTO ST DO BOTAO DE ABRIR NOVO PEDIDO
                $(".btnAbreCom").attr("st", status); // INSERE O STATUS DA MESA NO ATRIBUTO ST DO BOTAO DE ABRIR NOVO PEDIDO
                $("#FuncVnd").modal('open'); // ABRE O MODAL DE MESA OCUPADA
              }
            }//FIM FUNÇÃO DE ADAPTAÇAO DOS MODAIS
            
          }
        });//*/
      } //FIM DA FUNCAO DE LISTAR MESAS
      ListaMesas(); // CHAMA FUNÇÃO DE LISTAR MESAS

      //ABRE MODAL COMANDA
      $('.btnAbreCom').click(function(){ // AO CLICAR NO BOTAO DE ABRIR NOVO PEDIDO
        var $mesa = $(this).attr('id');
        var status = $(this).attr('st');
        if (status != 3) {
          $('#mComMesa').modal("open"); // ABRE O MODAL DE NOVO PEDIDO
          $('.idMesa').empty(); // LIMPA A TAG COM A CLASS idMesa
          $('.idMesa').append($mesa); // INSERE O ID DA MESA NA TAG COM A CLASS idMesa

          $(".AddProd").attr("id", ''); // LIMPA ATRIBUTO ID DO BOTAO DE ADICIONAR PRODUTO
          $(".AddProd").attr("id", $mesa); // INSERE ID DA MESA NO ATRIBUTO ID DO BOTAO DE ADICIONAR PRODUTO



          $(".btnAtcListaProdCom").attr('id', $mesa);// INSERE O ID DA MESA NO ATRIBUTO ID DO BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS NA COMANDA

          $(".btnAtcListaProdCom").click(); // ATIVA CLICK NO BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS NA COMANDA

          $(".btnLancarProd").attr('id', $mesa);
          //COLOCA ID DA MESA NO ATRIBUTO ID DO BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS DA MESA
          $('.btnAtcListaProdMesa').attr('id', '');
          $('.btnAtcListaProdMesa').attr('id', $mesa);
        }else{
          Materialize.toast('Mesa em Fechamento', 5000, 'rounded');
        }
      });// FIM

      //FUNCAO QUE LANCA PRODUTOS
      $(".btnLancarProd").click(function() {
        var mesa = $(this).attr('id');


        //CLICK NO BOTAO PARA LISTAR OS PRODUTOS DA MESA

         $.ajax({ // ENVIA REQUISICAO PARA O CONTROLER.PHP PARA PESQUISAR O PRODUTO COM AQUELE TERMO
          url: 'controler.php',
          type: 'POST',
          data: 'acao=insereprodcomandamesa&loja='+<?=$usuloja?>+'&mesa='+mesa,
          beforeSend: '',
          error: '',
          success: function(retorno){
            $('.btnAtcListaProdMesa').click();
            Materialize.toast('Produtos lançados, imprimindo...', 5000, 'rounded');
          }
        });

        $('#mComMesa').modal('close');

      });
    //ABRE MODAL DE INSERÇÃO DE PRODUTOS
    $(".AddProd").click(function(){
      ListaMesas();
      var $mesa = $(this).attr('id'); // GUARDA O ID DA MESA VINDO DO ATRIBUTO ID DO BOTAO DE ADICIONAR PRODUTO
      var $loja = <?=$usuloja?>; //GUARDA ID DA LOJA
      $('.inputPesquisa').val('');//LIMPA INPUT DE PESQUISA DE PRODUTOS
      $('.resultado-pesquisa').empty(); // LIMPA RESULTADO DA PESQUISA DE PRODUTOS
      $('.idMesa').empty();// LIMPA A TAG COM A CLASS idMesa
      $('.idMesa').append($mesa); // INSERE O ID DA MESA NA TAG COM A CLASS idMesa
      $("#mAddProd").modal('open'); // ABRE MODAL DE ADICIONAR PRODUTO
      $('.inputPesquisa').keydown(function(){ // QUANDO UMA TECLA FOR PRESSIONADA
        var termo = $(this).val(); // RECUPERA O VALOR DO INPUT

        $.ajax({ // ENVIA REQUISICAO PARA O CONTROLER.PHP PARA PESQUISAR O PRODUTO COM AQUELE TERMO
          url: 'controler.php',
          type: 'POST',
          data: 'acao=pesquisaproduto&termo='+termo+'&loja='+<?=$usuloja?>+'&mesa='+$mesa,
          beforeSend: '',
          error: '',
          success: function(retorno){
            $(".resultado-pesquisa").empty();
            $(".resultado-pesquisa").html(retorno);

            //PREPARA MODAL DE QUANTIDADE
            $('.btnAbreModalQnt').click(function(){
              var loja = $(this).attr('loja'); // GUARDA ID DA LOJA
              var mesa = $(this).attr('mesa'); // GUARDA ID DA MESA
              var prodCod = $(this).attr('cod'); // GUARDA CODIGO DO PRODUTO
              var nome = $(this).attr('nome'); // GUARDA NOME DO PRODUTO
              $(".ppp").addClass('btnAddProd');
              $('.inputQnt').val(""); // LIMPA CAMPO DE QUANTIDADE

              // LIMPA BOTAO DE ADICIONAR PRODUTO E INSERE O ATRIBUTO LOJA COM O ID DA LOJA
              $('.btnAddProd').attr('loja', '');
              $('.btnAddProd').attr('loja', loja);

              // LIMPA BOTAO DE ADICIONAR PRODUTO E INSERE O ATRIBUTO MESA COM O ID DA MESA
              $('.btnAddProd').attr('mesa', '');
              $('.btnAddProd').attr('mesa', mesa);

              // LIMPA BOTAO DE ADICIONAR PRODUTO E INSERE O ATRIBUTO COD COM O ID DO PRODUTO
              $('.btnAddProd').attr('cod', '');
              $('.btnAddProd').attr('cod', prodCod);

              // LIMPA O TITULO DO MODAL DE QUANTIDADE E INSERE O NOME DO PRODUTO
              $('.nProd').empty();
              $('.nProd').text(nome);

              ListaMesas(); // LISTA MESAS
              $('#mQntProd').modal('open'); // ABRE MODAL DE QUANTIDADE
            });

          }
        });

      }); //FIM PESQUISA AO DIGITAR
              
        });
        //FIM ABRE MODAL DE INSERÇÃO DE PRODUTOS

        //ADICIONAR PRODUTO APOS DIGITADO A QUANTIDADE
        $('.btnAddProd').click(function() {
          var loja = $(this).attr('loja');
          var mesa = $(this).attr('mesa');
          var prodCod = $(this).attr('cod');
          var qnt = $('.inputQnt').val();
          $(".btnAtcListaProdCom").attr('id', mesa); // INSERE ID DA MESA NO ATRIBUTO ID DO BOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS NA COMANDA
          $.ajax({
            url: 'controler.php',
            type: 'POST',
            data: 'acao=addprodutocom&loja='+loja+'&mesa='+mesa+'&prodCod='+prodCod+'&qnt='+qnt,
            beforeSend: '',
            error: '',
            success: function(retorno){
              if (retorno == 1){
                $('#mQntProd').modal('close'); // FECHA MODAL DE QUANTIDADE
                $('#mAddProd').modal('close'); // FECHA MODAL DE ADICIONAR PRODUTO
                $(".btnAtcListaProdCom").click(); // ATIVA CLICK NO VOTAO QUE ATIVA A FUNCAO DE LISTAR PRODUTOS NA COMANDA
                $(".ppp").removeClass('btnAddProd');
                ListaMesas(); // LISTAR MESAS
              }
            }
          });
        });
        
      // SOLICITA FECHAMENTO DE MESA
       $(".SolFec").click(function(){
          var mesa_cod = $(this).attr('id');
          var caixa = <?=$CaixaAbertoCOD?>;
          //alert(mesa_cod);
          $.ajax({
            url:  'controler.php',
            type: 'POST',
            data:   'acao=SolicitaFechamento&mesa_cod='+mesa_cod+'&loja='+<?=$usuloja?>+'&caixa='+caixa,
            beforeSend: '',
            error:    '',
            success: function(retorno){
              //alert(retorno);
              if (retorno == 1) {
                Materialize.toast('Solicitação de fechamento da mesa '+mesa_cod+' realizado com sucesso!', 5000, 'rounded');
                $("#FuncVnd").modal('close');
                ListaMesas();
              }

              if (retorno == 3) {
                Materialize.toast('Essa mesa já está em fechamento!', 5000, 'rounded');
              }
            }
          });//*/
       });

       // ABRE MESA
       $(".AbrirMesa").click(function(){
          var id = $(this).attr('id');
          var status = $(this).attr('st');
          //alert(mesa_cod);
          $.ajax({
            url:  'controler.php',
            type: 'POST',
            data:   'acao=AbrirMesa&mesa_cod='+id+'&loja='+<?=$usuloja?>+'&caixa='+<?=$CaixaAbertoCOD?>+'&usucod='+<?=$usucod?>,
            beforeSend: '',
            error:    '',
            success: function(retorno){
              //alert(retorno);
              if (retorno == 1) {
                Materialize.toast('Mesa '+id+' aberta!', 5000, 'rounded');
                $("#FuncVndf").modal('close');
                ListaMesas();
              }
            }
          });//*/
       });


  	});
  </script>

  </body>
</html>
