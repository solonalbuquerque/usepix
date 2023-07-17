<?php

$tema = "default";
$titulo = "Digite o valor";

global $url;

$c = '
<input type="hidden" name="chavePix" value="'.$url[0].'" id="chavePixDigiteValor">
<form id="formGerarNovoValor">
  <div class="page page-center">
    <div class="container-tight py-4">
      <div class="empty">
        <p class="empty-title h1 mb-3">'.$titulo.'</p>
        <p class="empty-subtitle text-muted">
          Antes de continuar,<br />digite abaixo o valor do PIX que deseja gerar.
        </p>
        <div class="form-floating mt-2" id="digitevalor">
          <input type="tel" class="form-control moneyMask" id="digitevalorValor" placeholder="Digite o valor" name="chavePix">
          <label for="digitevalorValor">Digite aqui o valor...</label>
        </div>
          <div class="empty-action">
            <button type="button" id="gerarCobrancaValorDigitado" class="btn btn-primary">
              Continuar
              <!-- svg arrow right -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="5" y1="12" x2="19" y2="12" />
                <line x1="13" y1="18" x2="19" y2="12" />
                <line x1="13" y1="6" x2="19" y2="12" />
              </svg>
            </button>
          </div>
      </div>
    </div>
  </div>
</form>

<script>
$(document).ready(function(){

  // formGerarNovoValor on submit
  $("#formGerarNovoValor").submit(function(e){
    geraNovoUrlChave(e);
  });

  $("#gerarCobrancaValorDigitado").click(function(e){
    geraNovoUrlChave(e);
  });

});

function geraNovoUrlChave(e) {
  e.preventDefault();
  var chave = $("#chavePixDigiteValor").val();
  var valor = $("#digitevalorValor").val();
  if(valor == ""){
    alert("Digite o valor");
    $("#digitevalorValor").focus();
    return false;
  }
  var url = urlBase + chave+"/"+valor;
  window.location.href = url;
}
</script>';