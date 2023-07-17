<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Controller\ApiController;
use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\ChaveModel;

class ApiWebhookController
{

  static public function processaWebhook() {

    $vars = getAllParams();

    $url = explode("/", $vars['url']);

    logSalva("processaWebhook", ['vars' => $vars, 'url' => $url]);

    if($url[2]!=WEBHOOK_SECRET) {
      ApiController::retorno(400, "Secret inválido do webhook");
    }

    if($url[3]=="") {
      ApiController::retorno(400, "Módulo inválido do webhook");
    }

    if(!is_file(APP."Gateways/".$url[3]."/index.php")) {
      ApiController::retorno(400, "Módulo inválido do webhook");
    }

    require(APP."Gateways/".$url[3]."/index.php");

    gatewayChecaCobranca($vars);

    die("processaWebhook ".print_r($url, 1));

    

  }


  static public function MpConfirmaPay() {

    $dados = getAllParams();
    
    // get body content (JSON)
    $body = @json_decode(@file_get_contents('php://input'));
    $dados['token'] = $body;

    if(!isset($dados['token']->token)) {
      ApiController::retorno(400, "Token inválido");
    }

    $dados['url'] = explode("/", $dados['url']);

    $dados['lancamentoId'] = $dados['url'][2];
    $dados['idLancamento'] = $dados['url'][2];

    $dados['lancamento'] = ChaveModel::getLancamento($dados['lancamentoId']);

    if(!$dados['lancamento']) {
      ApiController::retorno(400, "Lançamento não encontrado");
    }
    
    $dados['chave'] = $dados['lancamento']->chave;
    $dados['chave_id'] = $dados['lancamento']->chave->id;
    
    $dados['meioPagamento'] = $dados['lancamento']->gateway;

    $meioPagamento = $dados['lancamento']->gateway;

    // puxa os dados do redirecionamento
    require(APP."Gateways/".$meioPagamento['gateway']."/index.php");

    gatewayFazCobrancaCartao($dados);

    // chama disparaNotificacaoUrl
    disparaNotificacaoUrl($dados['lancamentoId']);

    ApiController::retorno(200, "OK", $dados);

  }

}
