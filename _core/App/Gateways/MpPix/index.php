<?php

use SmartSolucoes\Model\ChaveModel;


/**
 * GATEWAY DE PAGAMENTO
 * 
 * Funções para o gateway de pagamento
 * gatewayInit() - função que inicia o gateway
 * gatewayCriaCobranca() - função que cria a cobranca no gateway
 * gatewayPaginaCobranca() - função que retorna o html da pagina de cobranca
 * gatewayChecaCobranca() - função que checa a cobranca no gateway
 */


 /**
  * Inicia o gateway
  */
function gatewayInit() {
  
}

/**
 * Cria a cobrança no gateway
 */
function gatewayCriaCobranca($dados) {
  global $banco;

  $prazo = date('Y-m-d\TH:i:s.000-03:00', strtotime('+10 minutes'));

  //die(print_r($dados));
  
  logSalva("gatewayCriaCobranca", json_encode($dados));
  
  \MercadoPago\SDK::setAccessToken(TOKEN_MP);

  $payment = new \MercadoPago\Payment();
  $payment->transaction_amount = ($dados['valor_total']);
  $payment->external_reference = $dados['idLancamento'];
  $payment->description = "usePIX - Chave".$dados['chave']->chave." | R$ ".$dados['chave']->chave_valor." | #".$dados['chave']->chave_identificador;
  $payment->payment_method_id = "pix";
  $payment->payer = array(
      "email" => "usepix_cob".$dados['chave']->id."@inordeste.com.br"
  );
  $payment->metadata = array(
      "chave_id" => $dados['chave_id'],
      "idLancamento" => $dados['idLancamento'],
  );
  $payment->date_of_expiration = $prazo;
  $payment->notification_url = WEBHOOK_URL.$dados['meioPagamento']['gateway']."/";

  $payment->save();

  logSalva("payment", json_encode(["id"=>$payment->id, "status"=>$payment->status, "payment"=>$payment]));

  if(@$payment->point_of_interaction->transaction_data->qr_code_base64) {
  
    $dadosFatura = [
      'id'=>$payment->id,
      'status'=>$payment->status,
      'status_detail'=>$payment->status_detail,
      'issuer_id'=>$payment->issuer_id,
      'payment_method_id'=>$payment->payment_method_id,
      'payment_type_id'=>$payment->payment_type_id,
      'currency_id'=>$payment->currency_id,
      'taxes_amount'=>$payment->taxes_amount,
      'shipping_amount'=>$payment->shipping_amount,
      'transaction_amount'=>$payment->transaction_amount,
      'transaction_amount_refunded'=>$payment->transaction_amount_refunded,
      'statement_descriptor'=>$payment->statement_descriptor,
      'installments'=>$payment->installments,
      'processing_mode'=>$payment->processing_mode,
      'taxes_amount'=>$payment->taxes_amount,
      
      'meio_pagamento'=>'PIX', 'qrcode'=>$payment->point_of_interaction->transaction_data->qr_code_base64,
      'copia_cola'=>$payment->point_of_interaction->transaction_data->qr_code,
      'ticket_url'=>$payment->point_of_interaction->transaction_data->ticket_url,
      'data_limite'=>$prazo,
    ];
    logSalva("resposta_criacao", $dadosFatura);
    $banco->where('id', $dados['idLancamento'])->update("lancamentos", ["meio_pagamento_id"=> $dadosFatura['id'], "resposta_criacao" => json_encode($dadosFatura)]);

    return true;

  } else {

    return false;

  }

}

function gatewayPaginaCobranca($idLancamento) {
  global $banco;

  // atualiza os dados do lancamento puxando eles
  $dadosLancamento = ChaveModel::getLancamento($idLancamento);

  //die("dadosLancamento: <pre>".print_r($dadosLancamento, true)."</pre>");

  $html = '
  <div class="alert">
    Valor: R$ '.number_format($dadosLancamento->valor, 2, ',', '.').'<br>
    Taxas: R$ '.number_format($dadosLancamento->valor_taxas, 2, ',', '.').'<br>
    <strong class="border-top mt-1">Valor a pagar: R$ '.number_format($dadosLancamento->valor_total, 2, ',', '.').'</strong>
  </div>
  <h3>Para pagar, escolha uma destas opções:</h3>

  <h3>Código QR</h3>
  <div class="text-center p-2">
    <img src="data:image/png;base64,'.$dadosLancamento->resposta_criacao->qrcode.'" alt="QR Code" style="width: 100%; max-width: 200px;">
  </div>

  <h3>Código de pagamento</h3>
  <div class="text-center p-2">
    <div class="input-group input-group-flat">
      <input type="text" class="form-control" autocomplete="off" value="'.$dadosLancamento->resposta_criacao->copia_cola.'">
      <span class="input-group-text">
        <button type="button" class="btn btn-link m-1 p-0 copyCopiaCola" data-clipboard-text="'.$dadosLancamento->resposta_criacao->copia_cola.'">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy me-0" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <rect x="8" y="8" width="12" height="12" rx="2" />
            <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
          </svg>
        </button>
      </span>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      var clipboard2 = new ClipboardJS(".copyCopiaCola");
      clipboard2.on("success", function(e) {
        console.log("e: ", e);
        if(e.action == "copy") {
          Swal.fire(
            "Código copiado com sucesso!",
            "Entre no app ou site do seu banco e escolha a opção de pagamento via Pix e cole o código de pagamento",
            "success"
          );
        }
        e.clearSelection();
      });
      clipboard2.on(\'error\', function(e) {
        alert("Erro ao copiar código!");
      });
      // inicia o cronometro
      cronometroStart(5, 15, function() {
        $("#cronometroFalta").html("Tempo expirado!");
        window.location.reload();
      });

      // inicia a consulta de pagamento
      payfConsultaPgto("'.$dadosLancamento->cod.'");
    });
  </script>

  <h3>Como pagar?</h3>
  <p>1. Entre no app ou site do seu banco e escolha a opção de pagamento via Pix.</p>
  <p>2. Escaneie o código QR ou copie e cole o código de pagamento.</p>
  <p>3. Pronto! O pagamento será creditado na hora e você receberá um aviso de confirmação.</p>

  ';

  return $html;
}




function gatewayChecaCobranca($vars) {
  global $banco;

  //die("vars: <pre>".print_r($vars, true)."</pre>");

  $data_id = $vars['data_id'];
  $type = $vars['type'];

  \MercadoPago\SDK::setAccessToken(TOKEN_MP);

  switch($type) {
    case "payment":

      $payment = \MercadoPago\Payment::find_by_id($data_id);
      logSalva("payment", $payment);

      $status = [
        'approved'=>'aprovado',
        'pending'=>'pendente',
        'in_process'=>'pendente',
        'rejected'=>'rejeitado',
        'refunded'=>'devolvido',
        'cancelled'=>'cancelado',
        'in_mediation'=>'reclamacao',
        'charged_back'=>'contestado'
      ]; 

      // atualiza os dados do lancamento puxando eles
      $dadosLancamento = ChaveModel::getLancamentoFromMeioPagamentoId($data_id);
      
      // registra o pagamento
      $dadosPagamento = [
        "lancamento_id"=>$dadosLancamento->id,
        "dadosLancamento"=>$dadosLancamento,
        "dadosPagamento"=>$payment,
        "status_anterior"=>$dadosLancamento->status_pagamento,
        "status_novo"=>$status[$payment->status],
        "valor"=>$payment->transaction_amount,
        "meio_pagamento_id"=>$data_id,
        "meio_pagamento_tipo"=>$payment->payment_method_id,
        "meio_pagamento_status"=>$payment->status,
        "gateway"=>"MercadoPago",
        "gatewayConta"=>"MercadoPago Inordeste"
      ];
      ChaveModel::registraPagamento( $dadosPagamento);

      // chama disparaNotificacaoUrl
      disparaNotificacaoUrl($dadosLancamento->id);

      die("REGISTRADO PAGAMENTO");

    break;
      
  }

  // atualiza os dados do lancamento puxando eles
  //$dadosLancamento = ChaveModel::getLancamento($idLancamento);

  die("SEM AÇÃO");

}