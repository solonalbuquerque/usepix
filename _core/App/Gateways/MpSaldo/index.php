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

  return true;

}

function gatewayPaginaCobranca($idLancamento) {
  global $banco;

  // atualiza os dados do lancamento puxando eles
  $dadosLancamento = ChaveModel::getLancamento($idLancamento);

  //die("dadosLancamento: <pre>".print_r($dadosLancamento, true)."</pre>");

  $codUnico = vkey(8);
  
  $html = '
  <div class="alert">
    Valor: R$ '.number_format($dadosLancamento->valor, 2, ',', '.').'<br>
    Taxas: R$ '.number_format($dadosLancamento->valor_taxas, 2, ',', '.').'<br>
    <strong class="border-top mt-1">Valor a pagar: R$ '.number_format($dadosLancamento->valor_total, 2, ',', '.').'</strong>
  </div>

  <div id="paymentBrick_container'.$codUnico.'Load">Aguarde, carregando...</div>

  <div id="paymentBrick_container'.$codUnico.'"></div>

  <style>
  #paymentBrick_container'.$codUnico.' h1{display:none !important;}
  </style>

  <script>
    $(document).ready(function(){
      
      $("#fluxoLoadding").show();

      const mp'.$codUnico.' = new MercadoPago("'.PUBLIC_KEY_MP.'", {
          locale: "pt-BR"
      })
      const bricksBuilder'.$codUnico.' = mp'.$codUnico.'.bricks();
      const renderPaymentBrick'.$codUnico.' = async (bricksBuilder'.$codUnico.') => {
        const settings'.$codUnico.' = {
          initialization: {
            amount: '.$dadosLancamento->valor_total.',
          },
          customization: {
            paymentMethods: {
              mercadoPago: "all",
              creditCard: "all",
              debitCard: "all",
            },
          },
          callbacks: {
            onReady: () => {
              /*
                Callback chamado quando o Brick estiver pronto.
                Aqui você pode ocultar loadings do seu site, por exemplo.
              */
              console.log("Callback chamado quando o Brick estiver pronto.");
              $("#paymentBrick_container'.$codUnico.'Load").hide();
              payfEscolha();
            },
            onSubmit: ({ selectedPaymentMethod, formData }) => {
              console.log("chama o endpoint para verificar");

              (async () => {
                const rawResponse = await fetch(urlBase+"api/MpConfirmaPay/'.$dadosLancamento->id.'", {
                  method: "POST",
                  headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                  },
                  body: JSON.stringify(formData)
                });
                
                // inicia a consulta de pagamento
                payfConsultaPgto("'.$dadosLancamento->cod.'");
                
                const response = await rawResponse.json();
              
                console.log("Resposta do pagamento: ", response);
              })();

            },
            onError: (error) => {
              // callback chamado para todos os casos de erro do Brick
              console.error("ERRO", error);
            },
          },
        };
        window.paymentBrickController'.$codUnico.' = await bricksBuilder'.$codUnico.'.create(
          "payment",
          "paymentBrick_container'.$codUnico.'",
          settings'.$codUnico.'
        );
      };
      renderPaymentBrick'.$codUnico.'(bricksBuilder'.$codUnico.');

    });
  </script>
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







function gatewayFazCobrancaCartao($dados) {
  global $banco;

  $token = $dados['token'];
  $lancamento = $dados['lancamento'];
  $lancamentoId = $dados['lancamentoId'];
  $chave = $dados['chave'];

  // salvar os dados do token
  $dadosFatura = [
    'token'=>$token,
    /*'id'=>$payment->id,
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
    'qrcode'=>$payment->point_of_interaction->transaction_data->qr_code_base64,
    'copia_cola'=>$payment->point_of_interaction->transaction_data->qr_code,
    'ticket_url'=>$payment->point_of_interaction->transaction_data->ticket_url,
    'data_limite'=>$prazo,
    */
    'meio_pagamento'=>'mp_'.$token->payment_method_id, 
  ];
  logSalva("resposta_criacao", $dadosFatura);
  $banco->where('id', $dados['idLancamento'])->update("lancamentos", ["resposta_criacao" => json_encode($dadosFatura)]);


  // vai fazer a cobranca no cartão
  
  logSalva("gatewayCriaCobranca", json_encode($dados));
  
  \MercadoPago\SDK::setAccessToken(TOKEN_MP);

  $payment = new \MercadoPago\Payment();
  $payment->token = $token->token;
  $payment->issuer_id = $token->issuer_id;
  $payment->payment_method_id = $token->payment_method_id;
  $payment->transaction_amount = $token->transaction_amount;
  $payment->installments = $token->installments;
  $payment->payer = $token->payer;

  $payment->external_reference = $dados['idLancamento'];
  $payment->description = "usePIX - Chave".$dados['chave']->chave." | R$ ".$dados['chave']->chave_valor." | #".$dados['chave']->chave_identificador;
  //$payment->payer = array(
  //    "email" => "usepix_cob".$dados['chave']->id."@inordeste.com.br"
  //);
  $payment->metadata = array(
      "chave_id" => $dados['chave_id'],
      "idLancamento" => $dados['idLancamento'],
  );
  //$payment->date_of_expiration = $prazo;
  $payment->notification_url = WEBHOOK_URL.$dados['meioPagamento']['gateway']."/";

  $payment->save();

  logSalva("payment", json_encode(["id"=>$payment->id, "status"=>$payment->status, "payment"=>json_encode($payment)]));
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
    
    'meio_pagamento'=>$token->payment_method_id, 
    'ticket_url'=>$payment->point_of_interaction->transaction_data->ticket_url,
    //'data_limite'=>$prazo,
  ];
  logSalva("resposta_criacao", $dadosFatura);
  $banco->where('id', $dados['idLancamento'])->update("lancamentos", ["meio_pagamento_id"=> $dadosFatura['id'], "resposta_criacao" => json_encode($dadosFatura)]);




  die("Fazer a cobranca no cartão: <pre>dados: ".print_r($dados, true)."\n\n<hr>\npayment: ".print_r($payment, true)."</pre>");

  // dando certo passa

  // dando erro retorna o erro
  
}