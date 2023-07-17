<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\ChaveModel;

class ApiController
{

  static public function retorno($status, $msg, $data = null)
  {
    $retorno = array(
      'status' => $status,
      'msg' => $msg,
      'data' => $data
    );
    // adicionar o header de json
    header('Content-Type: application/json');
    echo json_encode($retorno);
    exit();
  }

  static public function inicio() {
    self::retorno(200, "API OK");
  }

  static public function inicia() {
    
    $vars = getAllParams();

    $dadosUp = [];
    $dadosUp['chave'] = $vars['chave'];
    $dadosUp['valor'] = $vars['valor'];
    $dadosUp['referencia'] = $vars['referencia'];
    
    $dados = ChaveModel::getOrAdd($dadosUp, true);

    self::retorno(200, "Ok", $dados);

  }

  /**
   * Função para receber o start do pagamento via web
   * return json_html
   */
  static public function payf() {
    global $_meiosDePagamento;

    $vars = getAllParams();

    // validar a requisição e retornar os dados da chave
    $chave = self::validarChave($vars, "html");

    $metodoPagamento = $vars['metodoPagamento'];
    $valorPagamento = $vars['valorPagamento'];

    // trocar de virgula para ponto
    $valorPagamento = str_replace(",", ".", $valorPagamento);

    // validar o valor a pagar
    if(!isset($vars['valor'])) {
      echo boxErro("Valor não informado","","fechar");
      exit;
    }

    // verificar se está captando
    if($chave->status != "captando") {
      echo boxErro("Chave não está captando","","fechar");
      exit;
    }

    // verifica se o valor é maior que o valor que a chave pode receber
    if($valorPagamento > $chave->valor_diferenca) {
      echo boxErro("Valor maior que o que falta pagar","O valor máximo que essa fatura aceita no momento para pagamento é de R$ ".formataMoedaBRL($chave->valor_diferenca)." ","fechar");
      exit;
    }

    $meioPagamento = $_meiosDePagamento[$metodoPagamento];

    // salva no banco a ineção de pagamento
    $taxas = calculaTaxaPagamento($valorPagamento, $metodoPagamento, true);

    $dados = [
      'chavepix_id' => $chave->chavepix_id,
      'chave_id' => $chave->id,
      'modulo_pagamento' => $meioPagamento['gateway'],
      'meio_pagamento' => $metodoPagamento,
      'valor' => number_format($valorPagamento, 2, '.', ''),
      'valor_taxas' => number_format($taxas['valor_taxas'], 2, '.', ''),
      'valor_total' => number_format(($taxas['total'] + $valorPagamento), 2, '.', ''),
      'status_pagamento' => 'pendente',
      'status' => 'pendente'
    ];
    $idLancamento = ChaveModel::addLancamento($dados);

    $dadosCobranca = $dados;
    $dadosCobranca['idLancamento'] = $idLancamento;
    $dadosCobranca['chave'] = $chave;
    $dadosCobranca['meioPagamento'] = $meioPagamento;
    $dadosCobranca['taxas'] = $taxas;

    // puxa os dados do redirecionamento
    require(APP."Gateways/".$meioPagamento['gateway']."/index.php");

    // cria a cobrança
    $retornoCriacaoCobranca = gatewayCriaCobranca($dadosCobranca);

    // checa se tem sucesso ou não
    if($retornoCriacaoCobranca==false) {
      atualizarCampoLancamentoStatus("cancelado", "Problemas ao gerar cobrança em ".$meioPagamento['nome'], $idLancamento);
      echo boxErro("Erro ao criar cobrança","Tivemos problemas com o nosso sistema ao gerar seu pagamento. Por favor, tente novamente.","fechar");
      exit;
    }

    $htmlCobranca = gatewayPaginaCobranca($idLancamento);

    echo $htmlCobranca;
    exit;


  }


/**
 * vai checar aqui se o pagamento está ok ou não
 */
  static function payfChecaPagamento() {
    $vars = getAllParams();
    $vars['id'] = $idLancamento = idDecode($vars['cod']);
    
    // atualiza os dados do lancamento puxando eles
    $dadosLancamento = ChaveModel::getLancamento($idLancamento);

    $dados = [
      //"vars" => $vars,
      //"dadosLancamento" => $dadosLancamento,
      "status_pagamento" => $dadosLancamento->status_pagamento,
      "status" => $dadosLancamento->status
    ];

    if($dadosLancamento->status == "pendente") {
      self::retorno(200, "NO", $dados);
    }

    if($dadosLancamento->status == "concluido") {
      self::retorno(200, "OK", $dados);
    }
    
    self::retorno(200, "XX", $dados);
  }


  static public function validarChave($vars='', $retorno='json') {

    if(!isset($vars['chave'])) {
      if($retorno == 'json') {
        self::retorno(400, "Chave não informada");
      } else {
        echo boxErro("Chave não informada","","fechar");
        exit;
      }
    }

    $tipoChave = tipoDaChave($vars['chave']);

    if($tipoChave==false) {
      if($retorno == 'json') {
        self::retorno(400, "Tipo da chave não informada");
      } else {
        echo boxErro("Tipo da chave não informada","","fechar");
        exit;
      }
    }

    if(!isset($vars['valor'])) {
      if($retorno == 'json') {
        self::retorno(400, "Valor não informado");
      } else {
        echo boxErro("Valor não informado","","fechar");
        exit;
      }
    }

    if(!isset($vars['referencia'])) {
      if($retorno == 'json') {
        self::retorno(400, "Referência não informada");
      } else {
        echo boxErro("Referência não informada","","fechar");
        exit;
      }
    }

    $dadosValidar = [
      'chave' => $vars['chave'],
      'valor' => $vars['valor'],
      'referencia' => $vars['referencia']
    ];
    $dados = ChaveModel::getOrAdd($dadosValidar);

    if($dados == false) {
      if($retorno == 'json') {
        self::retorno(400, "Chave não encontrada");
      } else {
        echo boxErro("Chave não encontrada","","fechar");
        exit;
      }
    } else {
      return $dados;
    }

  }


  static function consultar() {
    $vars = getAllParams();
    
    $json_params = @file_get_contents("php://input");
    $dadosUp = (object) @json_decode($json_params, true);
    
    $dados = ChaveModel::getOrAdd($dadosUp, true);
    
    $chave = ChaveModel::completo($dados->id, true);

    self::retorno(200, "Ok", $chave);
  
  }
  

  static function criar() {
    return self::criar();
  }


}
