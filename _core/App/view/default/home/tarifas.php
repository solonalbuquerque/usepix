<?php

$tema = "default";
$titulo = "Tarifas e Prazos";

$c = '
<div class="page-header my-4">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h1 class="page-title h1">
          Tarifas e Prazos
        </h1>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">

    <p>Última atualização: 10/04/2023</p>

    <p>A utilização do usePIX é gratuito, mas as instituições financeiras podem cobrar tarifas para utilização do PIX e das outras formas de pagamento. Essas tarifas são repassadas para as partes envolvidas.</p>

    <p>A tabela de tarifas abaixo mostra as tarifas cobradas pelo usePIX para cada tipo de transação.</p>

    <table class="table table-sm">
      <thead>
        <tr>
          <th class="">PARA O RECEBEDOR / LOJISTA</th>
          <th class="text-center">Taxa Fixa</th>
          <th class="text-center">Taxa Percentual</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td>Cadastro</td>
          <td class="fw-bold text-center">Grátis</td>
          <td class="fw-bold text-center">Grátis</td>
        </tr>

        <tr>
          <td>Criação de usePix</td>
          <td class="fw-bold text-center">Grátis</td>
          <td class="fw-bold text-center">Grátis</td>
        </tr>

        <tr>
          <td>Compartilhamento</td>
          <td class="fw-bold text-center">Grátis</td>
          <td class="fw-bold text-center">Grátis</td>
        </tr>

        <tr>
          <td>Recebimento via Cartão, PIX, PayPal e todas outras formas</td>
          <td class="fw-bold text-center">Grátis</td>
          <td class="fw-bold text-center">Grátis</td>
        </tr>

        <tr>
          <td>Tranferência automática do saldo para chave PIX</td>
          <td class="fw-bold text-center">R$ 1,00</td>
          <td class="fw-bold text-center">1%</td>
        </tr>
        
      </tbody>
    </table>

    <p><strong>Prazo para recebimento:</strong> O prazo para recebimento do pagamento é imediato após a confirmação da transação.</p>

    <p><strong>Valor mínimo para transferência do saldo:</strong> O valor mínimo é de R$ 2,00.</p>

    <p><strong>Forma de transferência do saldo:</strong> O valor do saldo é transferido de forma automática para a chave PIX recebedora dos valores.</p>

    <p>Para o cliente que faz o pagamento, a tarifa é cobrada pela instituição financeira de acordo com o meio que ele utiliza, acrescidas das seguintes taxas:</p>

    <table class="table table-sm">
      <thead>
        <tr>
          <th class="">PARA O PAGADOR / CLIENTE</th>
          <th class="text-center">Taxa Fixa</th>
          <th class="text-center">Taxa Percentual</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td>Iniciar pagamento</td>
          <td class="fw-bold text-center">Grátis</td>
          <td class="fw-bold text-center">Grátis</td>
        </tr>
  ';
  global $_meiosDePagamento;
  foreach ($_meiosDePagamento as $meio) {
    $meio = (array) $meio;
    $c.= '
        <tr>
          <td>Pagamento via '.$meio['nome'].'</td>
          <td class="fw-bold text-center">R$ '.formataMoedaBRL($meio['pagamento']['taxaFixa']).'</td>
          <td class="fw-bold text-center">'.$meio['pagamento']['taxa'].'%</td>
        </tr>
    ';
  }
  $c.= '
        
      </tbody>
    </table>

    <p>Ao utilizar o usePIX, você concorda com nossas <a href="./tarifas-e-prazos">Tarifas & Prazos</a>, nossos <a href="./termos">Termos</a> e com a nossa <a href="./privacidade">Política de Privacidade</a>. Se tiver alguma dúvida, entre em contato com nossa equipe de <a href="./suporte">Suporte</a>.</p>

  </div>
</div>
';