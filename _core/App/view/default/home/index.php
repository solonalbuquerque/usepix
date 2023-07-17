<?php

$tema = "default";
$titulo = "Página inicial";

$_itens = [];
$_itens['Grátis'] = 'Independente do valor da cobrança, você não paga nada para gerar e receber o pagamento.';
$_itens['100% do valor do PIX'] = 'O valor do PIX é 100% para você, sem taxas nem descontos.';
$_itens['Fácil'] = 'Sem registros, sem cadastros, sem burocracia. Você gera a cobrança e recebe o pagamento. Simples assim!';
$_itens['Instantâneo'] = 'O pagamento é instantâneo, você recebe o valor em sua conta em poucos segundos de forma automática após o pagamento integral.';
$_itens['Multi pagamentos em um único PIX'] = 'Você pode receber vários pagamentos em um único PIX: um pedaço via cartão, outro em outro cartão, outro via PIX, outro via Paypal, outro via MercadoPago, etc. O seu cliente escolhe como pagar, quais os métodos de pagamento e você recebe 100% do valor.';



$_passos = [];
$_passos['1'] = 'Gere uma cobrança para a sua chave PIX no valor desejado';
$_passos['2'] = 'Envie o link para o seu cliente e deixe ele escolher como pagar';
$_passos['3'] = 'Receba o pagamento em sua conta bancária em poucos segundos';



$_passosIcones = [];
$_passosIcones['1'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brackets-contain" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
<path d="M7 4h-4v16h4"></path>
<path d="M17 4h4v16h-4"></path>
<path d="M8 16h.01"></path>
<path d="M12 16h.01"></path>
<path d="M16 16h.01"></path>
</svg>';
$_passosIcones['2'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
<path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
<path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
<path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
<path d="M8.7 10.7l6.6 -3.4"></path>
<path d="M8.7 13.3l6.6 3.4"></path>
</svg>';
$_passosIcones['3'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-real" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
<path d="M21 6h-4a3 3 0 0 0 0 6h1a3 3 0 0 1 0 6h-4"></path>
<path d="M4 18v-12h3a3 3 0 1 1 0 6h-3c5.5 0 5 4 6 6"></path>
<path d="M18 6v-2"></path>
<path d="M17 20v-2"></path>
</svg>';



$c = '
<div class="row row-deck row-cards py-3">
  <div class="col-md-6 col-lg-7 my-2">
    <div class="card">
      <div class="card-body">
        <h2 class="mb-3">UsePIX e deixe seu cliente escolher como pagar!</h2>
        <p class="text-muted mb-4">
          Gere facilmente uma cobrança para a <strong>SUA chave PIX</strong>, deixe seu cliente escolher como pagar e receba 100% do valor, sem taxas nem descontos e direto em sua conta, de forma automática.
        </p>
        <ul class="list-unstyled space-y">
        ';
        foreach($_itens as $k=>$v) {
          $c.= '
            <li class="row g-2">
              <span class="col-auto"><!-- Download SVG icon from http://tabler-icons.io/i/check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
              </span>
              <span class="col">
                <strong class="d-block">'.$k.'</strong>
                <span class="d-block text-muted">'.$v.'</span>
              </span>
            </li>';
        }
        $c.= '
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-5 my-2">
    <div class="card bg-primary-lt">
      <div class="ribbon bg-red">LIBERADO PARA TESTES</div>
      <form id="novopixForm2" autocomplete="true">
        <div class="card-body">
        
          <h2 class="mb-4">Gerar Novo UsePIX</h2>

          <div class="mb-4">
            <div class="form-floating mb-0">
              <input type="text" class="form-control" id="novopix_chave2" placeholder="Digite sua chave PIX" name="chavePix">
              <label for="novopix_chave">Digite sua Chave PIX*</label>
            </div>
            <span class="text-muted small">Aceita e-mail, telefone, CPF e CNPJ.</span>
          </div>
          
          <div class="mb-4">
            <div class="form-floating mb-0">
              <input type="tel" class="form-control moneyMask" id="novopix_valor2" value="1.00" autocomplete="off" placeholder="0.00" maxlength="9">
              <label for="novopix_valor">Valor a Receber*</label>
            </div>
            <span class="text-muted small">Você receberá 100% do valor.</span>
          </div>

          <div class="mb-4">
            <div class="form-floating mb-0">
              <input type="text" class="form-control" id="novopix_referencia2" placeholder="Qual a referência do recebimento?">
              <label for="novopix_referencia">Qual a referência do recebimento?</label>
            </div>
            <span class="text-muted small">Exemplo: doação de janeiro; sapato preto 35 do Roberto; OS-0005; NF-0005; etc. Vai individualizar o novo PIX. Deixando em branco criaremos um código único para ela.</span>
          </div>

          <button class="btn btn-primary btn-block w-100" type="submit">
            Criar
          </button>

        </div>
      </form>
    </div>
  </div>
  
  <div class="col-12">
    <div class="card card-md">
      <div class="card-body">
        
        <h3 class="h1 mb-4">Como Funciona?</h3>

        <div class="row row-deck row-cards">
          ';

          foreach($_passos as $k=>$v) {
            $c.= '
            <div class="col-4">
              <div class="d-flex flex-column justify-content-center align-items-start">
                <div class="d-block w-100 text-center">
                  <span class="bg-primary text-white avatar avatar-md mb-3 position-relative mx-auto">
                    '.$_passosIcones[$k].'
                    <span class="badge bg-primary badge-notification badge-pill" style="height:30px;">'.$k.'</span>
                  </span>
                </div>
                <div class="text-center px-3 font-weight-medium">
                  '.$v.'
                </div>
              </div>
            </div>
            ';
          }

          $c.= '

        </div>

      </div>
    </div>
  </div>
  
  <div class="col-12">
    <div class="card card-md">
      <div class="card-body">
        
        <h3 class="h1 mb-3">Como pagar no UsePIX?</h3>

        <p class="mb-2">Atualmente suportamos múltiplos pagamentos para os seguintes meios:</p>

        <div class="row row-deck row-cards justify-content-center align-items-stretch">
          ';

          foreach($_meiosDePagamento as $item) {
            $c.= '
            <div class="col-3 col-xs-6 pt-3">
              <div class="d-flex flex-column justify-content-center align-items-stretch w-100">
                <div class="d-block w-100 text-center">
                  <span class="avatar avatar-md mx-auto">
                    <img src="'.$item['logo'].'" class="img-fluid m-2" alt="'.$item['nome'].'">
                  </span>
                </div>
                <div class="text-center px-3 font-weight-medium w-100">
                  <strong>'.$item['nome'].'</strong>
                </div>
              </div>
            </div>
            ';
          }

          $c.= '

        </div>

      </div>
    </div>
  </div>
  
  <div class="col-12">
    <div class="card card-md">
      <div class="card-stamp card-stamp-lg">
        <div class="card-stamp-icon bg-primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M9 12l2 2l4 -4"></path>
            <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"></path>
          </svg>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-10">
            <h3 class="h1 mb-3">Período de Testes</h3>
            <div class="markdown text-muted">
              O UsePIX é um serviço gratuito e está em fase de testes. Você pode gerar quantos PIX quiser, mas o limite de recebimento por cobrança é de R$ '.formataMoedaBRL($_limites['default']['valor_cobranca_maximo']).' por dia e o recebedor final deve ter chave PIX válida no Brasil.
              Todos os serviços e automatizações estão funcionando porém, como ainda estamos em fase de testes, pode haver alguma instabilidades. Se encontrar algum problema, por favor, nos avise através do nossa <a href="./suporte">central de ajuda</a>.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>';