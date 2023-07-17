<?php

$tema = "framePagamento";
$titulo = "Frame de Pagamento";

global $_GET;

$valorCheio = (isset($_GET['part'])) ? false : true;


if($chave->status=="cancelado") {
  $carinha = ":[";
  $titulo = "Transação Cancelada";
  $texto = "Essa transação foi cancelada.";
} else {
  $carinha = ":)";
  $titulo = "Aguarde seu PIX!";
  $texto = "Estamos processando o seu pagamento.<br />
  Assim que recebermos a confirmação definitiva da operadora, você receberá sua transferência na chave PIX informada.";
}


$c = '
<div class="empty">
  <div class="empty-header">'.$carinha.'</div>
  <p class="empty-title">'.$titulo.'</p>
  <p class="empty-subtitle text-muted">
    '.$texto.'<br />
    No link abaixo você pode acompanhar o status do seu pagamento e outras informações.
  </p>
  <div class="empty-action">
    <a href="'.$chave->link.'" target="_blank" class="btn btn-primary pe-0">
      Detalhes
      <span class="ps-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M17 7l-10 10"></path>
          <path d="M8 7l9 0l0 9"></path>
        </svg>
      </span>
    </a>
  </div>
</div>
';

//$c.= '<pre>'.print_r($chave, 1).'</pre>';