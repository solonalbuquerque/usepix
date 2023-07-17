<?php

$tema = "framePagamento";
$titulo = "Frame de Pagamento";

global $_GET;

$valorCheio = (isset($_GET['part'])) ? false : true;

$c = '

<!-- inicio fluxo load -->
<div id="fluxoLoadding" class="fluxoPay">
  <div class="progress mb-3">
    <div class="progress-bar progress-bar-indeterminate"></div>
  </div>
</div>
<!-- fim fluxo load -->
        
<div id="cronometro" class="fluxoPay mb-2">
  <div class="border d-block p-2 bg-white">
    <div class="row align-items-center">
      <div class="col-auto">
        <div class="spinner-border"></div>
      </div>
      <div class="col">
        Conclua esse pagamento em até <span id="cronometroFalta"></span>
      </div>
    </div>
  </div>
</div>


<!-- inicio fluxo 1 -->
<div id="fluxo1" class="fluxoPay">
  ';
if($valorCheio==true) {
  $c.= '<input type="hidden" id="floating-input" value="'.$chave->valor_diferenca.'">';
} else {
  $c.= '
  <div class="mb-3">
    <div class="form-floating mb-3">
      <input type="tel" class="form-control moneyMask" id="floating-input" value="'.$chave->valor_diferenca.'" max="'.$chave->valor_diferenca.'" min="1" autocomplete="off">
      <label for="floating-input">Valor a Pagar</label>
    </div>
  </div>';
}
  $c.= '

  <div class="mb-3">
    <label class="form-label">Escolha o método</label>
    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
    ';
    
    $i = 1;
    $primeiroMetodo = "";
    foreach($_meiosDePagamento as $item) {
      if($item['pagamento']['ativo']==true && $item['pagamento']['destaque']==true){
        $c.= '
        <label class="form-selectgroup-item flex-fill" title="'.$item['pagamento']['textoSelect'].'">
          <input type="radio" name="form-payment" value="'.$item['modulo'].'" class="form-selectgroup-input pgtotp1"';
          if($i==1) {
            $primeiroMetodo = $item['modulo'];
            $c.= ' checked="true"';
          }
          $c.= '>
          <div class="form-selectgroup-label d-flex align-items-center p-3">
            <div class="me-3">
              <span class="form-selectgroup-check"></span>
            </div>
            <div>
              <span class="payment payment-provider-mercadopago payment-xs me-2 text-center"><img src="'.$item['logo'].'" class="m-1" alt="'.$item['nome'].'" ></span>
              '.$item['pagamento']['textoBotao'].'
            </div>
          </div>
        </label>';
        $i++;
      }
    }

    $itensOutrasOpcoes = "";
    foreach($_meiosDePagamento as $item) {
      if($item['pagamento']['ativo']==true && $item['pagamento']['destaque']==false){
        $itensOutrasOpcoes.= '<option value="'.$item['modulo'].'">'.$item['pagamento']['textoSelect'].'</option>';
      }
    }

    if($itensOutrasOpcoes!="") {
      $c.= '
      <div class="mb-3">
        <div class="form-floating">
          <select class="form-select pgtotp2" id="floatingSelect" aria-label="Floating label select example">
            <option value="x">Outro...</option>
            '
            .$itensOutrasOpcoes
            .'
          </select>
          <label for="floatingSelect">Selecione outro método:</label>
        </div>
      </div>
      ';
    }

    $c.= '
    
    </div>
  </div>

  <input type="hidden" id="metodoPagamento" name="metodoPagamento" value="'.$primeiroMetodo.'">

  <div class="mt-1">
    <button class="btn btn-primary btnPayf" type="button">
      Continuar
      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-1 me-0" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="5" y1="12" x2="19" y2="12" />
        <line x1="13" y1="18" x2="19" y2="12" />
        <line x1="13" y1="6" x2="19" y2="12" />
      </svg>
    </button>
  </div>
</div>
<!-- fim fluxo 1 -->



<!-- inicio fluxo 2 -->
<div id="fluxo2" class="fluxoPay">
    fl2
</div>
<!-- fim fluxo 2 -->

';

//$c.= '<pre>'.print_r($chave, 1).'</pre>';

$c.= '

<script type="text/template" id="countdown-tpl">
<%= m %> minutos e <%= s %> segundos
</script>

<script>


function cronometroStart(minutos, segundos, doneFunction) {
  var options = {
    autostart: true,
    m: minutos,
    s: segundos,
    done: doneFunction,
    tpl: function(el,opts) {
      // use underscore to generate the markup to be displayed from the countdown-tpl template
      var template = _.template(
        $("#countdown-tpl").html()
      );
      $(el).html(template(opts));
    }
  }
  // instantiate the countdown
  $("#cronometroFalta").countdown(options);
  
  $("#cronometro").show();

}

function payfLoad() {
  $(".fluxoPay").hide();
  $("#fluxoLoadding").show();
}

function payfInit() {
  $(".fluxoPay").hide();
  $(".pgtotp1").first().prop("checked", true).focus();
  $(".pgtotp2").val("x");
  $("#metodoPagamento").val($(".pgtotp1:checked").first().val());
  $("#floating-input").val("'.$chave->valor_diferenca.'");
  $("#fluxo1").show();
}

function payfEscolha() {
  $(".fluxoPay").hide();
  $("#fluxo2").show();
}

function payfConsultaPgto(cod) {
  console.log("payfConsultaPgto cod: ", cod);
  
  setInterval(function() {
    $.getJSON("'.$base_url.'/api/payfpgto?cod="+cod, function(resultado){
      console.log("resultado", resultado);
      if(resultado.msg == "NO") {
        
      } else {
        window.location.href = "'.$chave->link.'";
      }
    });
  }, 2000);

}

// jquery function load page
$(document).ready(function(){
  // if . pgtotp1 is checked
  $(".pgtotp1").click(function(){
    // get the value of the checked option and set to #metodoPagamento
    $("#metodoPagamento").val($(".pgtotp1:checked").val());
    // if . pgtotp1 is checked
    if($(".pgtotp1").is(":checked")){
      // unselect options in .pgtotp2
      $(".pgtotp2").val("x");
    }
  });
  // if . pgtotp2 is changed
  $(".pgtotp2").change(function(){
    // if . pgtotp2 is not equal to x
    if($(".pgtotp2").val() != "x"){
      // unselect options in .pgtotp1
      $(".pgtotp1").prop("checked", false);
      // get the value of the checked option and set to #metodoPagamento
      $("#metodoPagamento").val($(".pgtotp2").val());
    } else {
      // set .pgtotp1 to checked in first element
      $(".pgtotp1").first().prop("checked", true).focus();
      $("#metodoPagamento").val($(".pgtotp1:checked").first().val());
    }
  });

  payfInit();

  $(".btnPayf").click(function(){
    payfLoad();
    var data = {
      "metodoPagamento": $("#metodoPagamento").val(),
      "valorPagamento": $("#floating-input").val(),
      "chave": "'.$chave->chave.'",
      "valor": "'.$chave->chave_valor.'",
      "referencia": "'.$chave->chave_identificador.'",
      "url": "'.$_urlCompleta.'"
    };
    $.ajax({
      url: "'.$base_url.'/api/payf",
      type: "POST",
      data: data,
      success: function(data){
        payfEscolha();
        $("#fluxo2").html(data);
      }
    });
  });

  $("#botaoPagar").click(function(){
    payfInit();
  });

});

</script>';