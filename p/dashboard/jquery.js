// LISTA AS MESAS DE TEMPO EM TEMPO
$(document).ready(function(){
  var intervalo = window.setInterval(function() {
    $.ajax({
      url:  'controler.php',
      type: 'POST',
      data:   'acao=ListaMesas',
      beforeSend: '',
      error:    '',
      success: function(retorno){
        $(".lista-mesas").empty();
        $(".lista-mesas").html(retorno);

        //PREPARE MODAL FUNCOES VENDA
        $(".eOpt").click(function(){
          var id = $(this).attr("id");
          var status = $(this).attr("st");
          PrepareFuncoesVenda(id,status)
        });


    		function PrepareFuncoesVenda(id,status){
          //alert(status);
          if (status == 1) {
            $(".CodMesaTitulo").empty();
            $(".CodMesaTitulo").append(id);
            $(".AbrirMesa").attr("id", '');
            $(".AbrirMesa").attr("id", id);
            $(".AbrirMesa").attr("st", status);
            $("#FuncVndf").modal('open');
          }else{
      			$(".CodMesaTitulo").empty();
      			$(".CodMesaTitulo").append(id);

            $(".SolFec").attr("id",'');
            $(".SolFec").attr("id",id);

            $(".AddProd").attr("id", '');
            $(".AddProd").attr("id", id);
      			$("#FuncVnd").modal('open');
          }
    		}


      }
    });//*/
  }, 300);
   // SOLICITA FECHAMENTO DE MESA
   $(".SolFec").click(function(){
      var mesa_cod = $(this).attr('id');
      //alert(mesa_cod);
      $.ajax({
        url:  'controler.php',
        type: 'POST',
        data:   'acao=SolicitaFechamento&mesa_cod='+mesa_cod,
        beforeSend: '',
        error:    '',
        success: function(retorno){
          //alert(retorno);
          if (retorno == 1) {
            Materialize.toast('Solicitação de fechamento da mesa '+mesa_cod+' realizado com sucesso!', 5000, 'rounded');
            $("#FuncVnd").modal('close');
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
        data:   'acao=AbrirMesa&mesa_cod='+id,
        beforeSend: '',
        error:    '',
        success: function(retorno){
          //alert(retorno);
          if (retorno == 1) {
            Materialize.toast('Mesa '+id+' aberta!', 5000, 'rounded');
            $("#FuncVndf").modal('close');
          }
        }
      });//*/
   });

});


