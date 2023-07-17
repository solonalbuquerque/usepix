<?php

$tema = "default";
$titulo = "Gerar QrCode";

$c = '
<div class="page-header my-4">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h1 class="page-title h1">
        Gerar QrCode
        </h1>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">

    <div class="divide-y">
    
      <div class="mb-3">
        <h2 class="fw-light py-2">1 - Digite sua chave PIX</h2>
        <div>
          <div class="form-floating mb-0">
            <input type="text" class="form-control" id="qrdcode_chave1" placeholder="Digite aqui seu CPF, CNPJ, telefone ou e-mail" name="chavePix">
            <label for="novopix_chave">Digite aqui seu CPF, CNPJ, telefone ou e-mail</label>
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <h2 class="fw-light py-2">2 - Digite o valor ou escolha um dinâmico (o cliente digita o valor quando escanear)</h2>
        <div>
          <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
            <label class="form-selectgroup-item flex-fill">
              <input type="radio" name="tipovalor" value="dinamico" class="form-selectgroup-input tipovalor" checked="true">
              <div class="form-selectgroup-label d-flex align-items-center p-3">
                <div class="me-3">
                  <span class="form-selectgroup-check"></span>
                </div>
                <div>
                  <strong>Dinâmico</strong> (o cliente digita o valor quando escanear)<br />
                  <small>Esse é o tipo mais comum e o que recomendamos para a maioria dos casos.</small>
                </div>
              </div>
            </label>
            <label class="form-selectgroup-item flex-fill">
              <input type="radio" name="tipovalor" value="fixo" class="form-selectgroup-input tipovalor">
              <div class="form-selectgroup-label d-flex align-items-center p-3">
                <div class="me-3">
                  <span class="form-selectgroup-check"></span>
                </div>
                <div>
                  <strong>Valor fixo</strong><br />
                  <small>Esse tipo é usado para cobranças de valores fixos, como por exemplo, uma assinatura mensal ou um determinado produto.</small>
                </div>
              </div>
            </label>
          </div>
          <div class="form-floating mt-2 ms-5 d-none" id="digitevalor">
            <input type="text" class="form-control moneyMask" id="digitevalorValor" placeholder="Digite o valor" name="chavePix" value="0.00">
            <label for="novopix_chave">Digite o valor</label>
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <h2 class="fw-light py-2">3 - Gerar</h2>
        <div>
          <button type="button" class="btn btn-primary" id="gerarQrCode">
            Gerar QrCode
            <!-- svg arrow-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-2 me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <line x1="5" y1="12" x2="19" y2="12" />
              <line x1="13" y1="18" x2="19" y2="12" />
              <line x1="13" y1="6" x2="19" y2="12" />
            </svg>
        </div>
      </div>
      
      <div class="mb-3 d-none" id="boxResultadoQr">
        <h2 class="fw-light py-2">4 - Compartilhar e/ou imprimir</h2>
        <div id="qrcode"></div>
      </div>
      

    </div>

  </div>
</div>

<script>
// identificar se o tipovalor é fixo ou dinamico
$(document).ready(function(){
  $(".tipovalor").change(function(){
    $("#boxResultadoQr").addClass("d-none");
    if($(this).val() == "dinamico"){
      $("#digitevalor").addClass("d-none");
    }else{
      $("#digitevalor").removeClass("d-none");
      $("#digitevalorValor").val("").focus();
    }
  });
  $("#qrdcode_chave1, #digitevalorValor").keyup(function(){
    $("#boxResultadoQr").addClass("d-none");
  });
});


// gerar o qrcode
$("#gerarQrCode").click(function(){
  $("#qrcode").html("");
  var chave = $("#qrdcode_chave1").val();
  var tipovalor = $("input[name=tipovalor]:checked").val();
  var valor = $("#digitevalorValor").val();
  if(chave == ""){
    alert("Digite a chave PIX");
    $("#qrdcode_chave1").focus();
    return false;
  }
  if(tipovalor == "dinamico"){
    valor = "";
  } else if(tipovalor == "fixo" && valor == ""){
    alert("Digite o valor");
    $("#digitevalorValor").focus();
    return false;
  }
  $("#boxResultadoQr").removeClass("d-none");
  var url = urlBase + chave+"/"+valor;
  $("#qrcode").html("");
  $("#qrcode").append(\'<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=\'+url+\'" /><br />\');
  $("#qrcode").append(\'<a href="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=\'+url+\'" target="_blank">Abrir em nova aba</a><br />\');
  $("#qrcode").append(\'<a href="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=\'+url+\'" download="qrcode.png">Baixar</a><br /><br />\');
  $("#qrcode").append(\'<a href="\'+url+\'" target="_blank">\'+url+\'</a><br />\');
});
</script>
';