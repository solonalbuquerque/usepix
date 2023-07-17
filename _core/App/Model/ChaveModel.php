<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Model\ChavesPixModel;
use SmartSolucoes\Model\FinanceiroModel;
use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Controller\ApiController;

class ChaveModel extends Model
{

  static function get($chaveId) {
    global $banco;
    $item = (object) $banco->where("id", $chaveId)->getOne('chaves');
    $item->valor_diferenca = $item->chave_valor - $item->valor_recebido;
    $item->cod = idEncode($chaveId);
    return $item;
  }

  /*
    $dadosUp = [];
    $dadosUp['chave'] = $url[0];
    $dadosUp['valor'] = (isset($url[1])) ? $url[1] : '';
    $dadosUp['referencia'] = (isset($url[2])) ? $url[2] : '';
    */
  static function getOrAdd($dados, $API=false) {
    global $banco, $_meiosDePagamento;
    
    $dados = $dadosOrigem = (object) $dados;

    $dados->chave_tipo = tipoDaChave($dados->chave);

    if($dados->chave_tipo == false) {
      if($API==false) {
        Helper::view('default/chave/erro-chave-invalida');
        exit;
      } else {
        ApiController::retorno(200, "Tipo de chave inválida. Somente aceitamos CPF, CNPJ, Telefone e e-mail.", []);
        exit;
      }
    }

    $tipoChave = $dados->chave_tipo;
    $chave = $dados->chave;
    $valor = $dados->valor;
    $identificador = ((isset($dados->referencia)) ? $dados->referencia : "");
    $descricao = ((isset($dados->descricao)) ? $dados->descricao : "");
    
    // verifica se a chave já existe
    $ChavesPix = ChavesPixModel::getOrAdd($tipoChave, $chave);

    // verifica se ela esta bloqueada
    if($ChavesPix->blockedAt != '') {
      if($API==false) {
        Helper::view('default/chave/erro-chave-bloqueada');
        exit;
      } else {
        ApiController::retorno(200, "Chave bloqueada.", []);
        exit;
      }
    }

    // verifica agora se tem o pixParceiro na url e verifica se já existe
    $pixParceiroID = null;
    if(isset($_GET['pixParceiro']) && $_GET['pixParceiro']!="") {
      $pixParceiroDadosChave = $_GET['pixParceiro'];
      $pixParceiroDadosTipo = tipoDaChave($dados->chave);
      $pixParceiroDados = ChavesPixModel::getOrAdd($pixParceiroDadosTipo, $pixParceiroDadosChave, "Parceiro");
      $pixParceiroID = $pixParceiroDados->id;
    }

    $valor = trataMoeda($valor);

    // verifica se a cobrança é com o valor zerado (pede para o cliente digitar o valor antes de continuar)
    if($valor == 0 || $valor=="" || $valor=="0" || $valor=="0.00") {
      if($API==false) {
        Helper::view('default/chave/erro-digite_o_valor', $ChavesPix);
        exit;
      } else {
        ApiController::retorno(200, "Digite o valor.", []);
        exit;
      }
    }

    // verifica se a cobrança é um valor abaixo do limite
    if($valor < $ChavesPix->valor_cobranca_minimo) {
      if($API==false) {
        Helper::view('default/chave/erro-valor_cobranca_minimo', $ChavesPix);
        exit;
      } else {
        ApiController::retorno(200, "Valor abaixo do mínimo permitido.", []);
        exit;
      }
    }

    // verifica se a cobrança é um valor acima do limite
    if($valor > $ChavesPix->valor_cobranca_maximo) {
      if($API==false) {
        Helper::view('default/chave/erro-valor_cobranca_maximo', $ChavesPix);
        exit;
      } else {
        ApiController::retorno(200, "Valor acima do máximo permitido.", []);
        exit;
      }
    }

    $banco->where('chavepix_id', $ChavesPix->id);
    $banco->where('chave_tipo', $tipoChave);
    $banco->where('chave', $chave);
    
    $banco->where('chave_valor', $valor);

    if($identificador=="") $identificador = NULL;
    $banco->where('chave_identificador', $identificador);
    $item = (object) $banco->getOne('chaves');

    // ultimo sql
    //echo $banco->getLastQuery();

    if(isset($item->id)) {
      self::updateView($item->id);
      $item->valor_diferenca = $item->chave_valor - $item->valor_recebido;
      return $item;
    }

    $dados = [
      'chavepix_id' => $ChavesPix->id,
      'chave' => $chave,
      'chave_tipo' => $tipoChave,
      'chave_valor' => $valor,
      'chave_identificador' => $identificador,
      'descricao' => $descricao,
      'createdAt' => $banco->now(),
      'updateAt' => $banco->now(),
    ];
    if(isset($dadosOrigem->notification_url)) {
      $dados['notification_url'] = $dadosOrigem->notification_url;
    }
    if(isset($dadosOrigem->descricao)) {
      $dados['descricao'] = strip_tags($dadosOrigem->descricao);
    }

    if($pixParceiroID) {
      $dados['pixParceiro_id'] = strip_tags($pixParceiroID);
    }
    
    if(isset($_GET['celularCliente']) && $_GET['celularCliente']!="") {
      $dados['celularCliente'] = substr($_GET['celularCliente'], 0, 50);
    }
    
    if(isset($_GET['emailCliente']) && $_GET['emailCliente']!="") {
      $dados['emailCliente'] = substr($_GET['emailCliente'], 0, 150);
    }

    $id = $banco->insert('chaves', $dados);
    $item = (object) $banco->where("id", $id)->getOne('chaves');
    
    // atualiza o total gerado da chavepix
    $banco->where('id', $ChavesPix->id);
    $banco->update('chavespix', [
      'qtd_gerados' => $banco->inc(1),
      'total_gerado' => $banco->inc($valor),
      'updateAt' => $banco->now()
      ]
    );

    $chaveId = $item->id;
      
    if($item->chave_identificador == '' || $item->chave_identificador==NULL) {
      $chave_iden = idEncode($chaveId);
      $banco->where('id', $chaveId);
      $banco->update('chaves', ['chave_identificador' => $chave_iden]);
      $item->chave_identificador = $chave_iden;
    }

    self::updateView($item->id);
    
    $item->valor_diferenca = $item->chave_valor - $item->valor_recebido;
    return $item;
  }

  static function updateView($chaveId) {
    global $banco;
    $banco->where('id', $chaveId);
    $banco->update('chaves', ['views' => $banco->inc(1)]);
  }

  static function completo($chaveId, $limpa=false) {
    global $banco, $_meiosDePagamento;
    $banco->where('id', $chaveId);
    $item = (object) $banco->getOne('chaves');
    $item->cod = idEncode($item->id);
    $item->valor_diferenca = $item->chave_valor - $item->valor_recebido;
    $item->chave_dono = ChavesPixModel::getByChavePixId($item->chavepix_id);
    $item->lancamentos = LancamentoModel::getByChaveId($chaveId, $limpa);
    if($limpa==true) {
      unset(
        $item->id,
        $item->chavepix_id,
        $item->chave_dono->id,
        $item->chave_dono->dono_email,
        $item->chave_dono->dono_telefone,
        $item->chave_dono->dono_nome,
        $item->chave_dono->dono_documento,
        $item->chave_dono->total_gerado,
        $item->chave_dono->total_arrecadado,
        $item->chave_dono->total_repassado,
        $item->chave_dono->total_pendente,
      );
    }
    $link = BASE_URL."/".$item->chave."/".$item->chave_valor."/".urlencode($item->chave_identificador)."/";
    $item->link = $link;
    return $item;
  }

  static function addLancamento($dados) {
    global $banco;
    $dados['createdAt'] = $banco->now();
    $dados['updateAt'] = $banco->now();
    $id = $banco->insert('lancamentos', $dados);
    return $id;
  }

  static function getLancamento($id) {
    global $banco, $_meiosDePagamento;
    $banco->where('id', $id);
    $item = (object) $banco->getOne('lancamentos');
    if(isset($item->id)) {
      $item->cod = idEncode($item->id);
      $item->resposta_criacao = json_decode($item->resposta_criacao);
      $item->resposta_pagamento = json_decode($item->resposta_pagamento);
      $item->chave = self::completo($item->chave_id);
      $item->gateway = $_meiosDePagamento[$item->meio_pagamento];
    }
    return $item;
  }

  static function getLancamentoFromMeioPagamentoId($meio_pagamento_id) {
    global $banco;
    $banco->where('meio_pagamento_id', $meio_pagamento_id);
    $item = (object) $banco->getOne('lancamentos');
    if(isset($item->id)) {
      return self::getLancamento($item->id);
    }
    return null;
  }



  static function registraPagamento($dados=[]) {
    global $banco;

      $lancamentoId = $dados['lancamento_id'];
      $novoStatus = $dados['status_novo'];
      // trocar virgula para ponto
      $valor = str_replace(",", ".", $dados['valor']);
      $dadosLancamento = $dados['dadosLancamento'];
      $dadosPagamento = $dados['dadosPagamento'];
      $gateway = $dados['gateway'];
      $gatewayConta = $dados['gatewayConta'];

      logSalva("registraPagamento", ["lancamentoId"=>$lancamentoId, "novoStatus"=>$novoStatus, "valor"=>$valor, "dadosLancamento"=>$dadosLancamento, "dadosPagamento"=>$dadosPagamento, "gateway"=>$gateway, "gatewayConta"=>$gatewayConta]);
      
      // salva histórico da consulta
      $salvaHistorico = [
        "lancamento_id"=>$dadosLancamento->id,
        "createdAt"=> $banco->now(),
        "status_anterior"=>$dadosLancamento->status_pagamento,
        "status_novo"=>$novoStatus,
        "meio_pagamento_id"=>$dados['meio_pagamento_id'],
        "meio_pagamento_tipo"=>$dados['meio_pagamento_tipo'],
        "meio_pagamento_status"=>$dados['meio_pagamento_status'],
        "meio_pagamento_resposta"=>json_encode($dadosPagamento)
      ];
      $banco->insert("lancamentos_historico", $salvaHistorico);

      // checar se o status do pagamento é diferente do atual
      if($novoStatus != $dadosLancamento->status_pagamento) {

        logSalva("registraPagamento", ["atualiza o status do pagamento"=>"$novoStatus != $dadosLancamento->status_pagamento"]);

        echo "atualiza o status do pagamento<br>$novoStatus != $dadosLancamento->status_pagamento<br>";
        // atualiza o status do pagamento
        /*
      $status = [
        'approved'=>'aprovado',
        'pending'=>'pendente',
        'in_process'=>'pendente',
        'rejected'=>'rejeitado',
        'refunded'=>'devolvido',
        'cancelled'=>'cancelado',
        'in_mediation'=>'reclamacao',
        'charged_back'=>'contestado'
      ]; */

        // se o pagamento foi aprovado, registra o pagamento
        $dadosParaAtualizar = [
          "status_pagamento"=>$novoStatus,
          "updateAt"=>$banco->now()
        ];

        if($novoStatus == 'aprovado') {
          $dadosParaAtualizar['valor_recebido'] = $valor;
          $dadosParaAtualizar['status'] = "concluido";
          $dadosParaAtualizar['status_motivo'] = "Pagamento recebido com sucesso";

          $banco->where("id", $dadosLancamento->id)->update("lancamentos", $dadosParaAtualizar);

          // pegar o valor real (pago - taxas)
          $valorReal = str_replace(",", ".", $valor - $dadosLancamento->valor_taxas );
          logSalva("valorReal", ["valorReal"=>"$valorReal", "valor"=>"$valor", "valor_taxas"=>"$dadosLancamento->valor_taxas"]);

          $dadosUpLancamento = [
            "valor_recebido"=>$valorReal,
            "status_pagamento"=>$novoStatus,
            "resposta_pagamento"=>json_encode($dadosPagamento),
            "updateAt"=>$banco->now()
          ];
          $banco->where("id", $dadosLancamento->id)->update("lancamentos", $dadosUpLancamento);

          // adiciona o valor na chave pix
          $dadosAtualizar = [
            'qtd_pagamentos' => $banco->inc(1),
            'valor_recebido' => $banco->inc($valorReal),
            'updateAt' => $banco->now()
          ];
          $banco->where('id', $dadosLancamento->chave_id);
          $banco->update('chaves', $dadosAtualizar);

          $chave = ChaveModel::get($dadosLancamento->chave_id);
          
          //checa se o valor da chave é maior que o valor recebido
          if($chave->valor_recebido == $chave->chave_valor) {
            $dadosParaAtualizarStatus = "captado";
          } else if($chave->valor_recebido > $chave->chave_valor) {
            $dadosParaAtualizarStatus = "ultrapassado";
          } else {
            $dadosParaAtualizarStatus = "captando";
          }
          atualizarCampo("chaves", "status", $dadosParaAtualizarStatus, "id", $dadosLancamento->chave_id);

          // atualiza o geral da chavepix
          $atualizarChavepix = [
            'qtd_pagamentos' => $banco->inc(1),
            'total_arrecadado' => $banco->inc($valorReal),
            'saldo' => $banco->inc($valorReal),
            'updateAt' => $banco->now()
          ];
          $banco->where('id', $dadosLancamento->chavepix_id);
          $banco->update('chavespix', $atualizarChavepix);


          // inserir lancamento financeiro
          
          // conta de meio de pagamento
          FinanceiroModel::addLancamento($gatewayConta, "c", $valor, "Recebimento via $dadosLancamento->meio_pagamento", []);
          FinanceiroModel::addLancamento($chave->chave, "c", $valorReal, "Recebimento lançamento # $dadosLancamento->id", []);
          FinanceiroModel::addLancamento("taxas", "c", $dadosLancamento->valor_taxas, "Taxas do lançamento # $dadosLancamento->id", []);

          // verifica se tem o pixParceiro e repassa o valor
          if(isset($chave->pixParceiro_id) && $chave->pixParceiro_id!="") {
            global $_comissoes;
            if(isset($_comissoes[$chave->pixParceiro_id])) {
              $comissao = $_comissoes[$chave->pixParceiro_id];
            } else {
              $comissao = $_comissoes['default'];
            }
            if($comissao>0) {
              FinanceiroModel::addLancamento("taxas", "d", $comissao, "Comissão do lançamento # $dadosLancamento->id", []);
              FinanceiroModel::addLancamento($chave->pixParceiro_id, "c", $comissao, "Comissão do lançamento # $dadosLancamento->id", []);
            }
          }
    
          // notificação administrativa
          notificaAdmin("Pagamento registrado", "O pagamento do lançamento # $dadosLancamento->id foi registrado com sucesso");

        } elseif($novoStatus == 'pendente') {
          $dadosParaAtualizar['status'] = "pendente";
          $dadosParaAtualizar['status_motivo'] = "Pendente de confirmação do pagamento";
    
          // notificação administrativa
          notificaAdmin("Pendente de confirmação pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nPendente de confirmação pelo gateway de pagamento");

        } elseif($novoStatus == 'rejeitado') {
          $dadosParaAtualizar['status'] = "cancelado";
          $dadosParaAtualizar['status_motivo'] = "Rejeitado pelo gateway de pagamento";
    
          // notificação administrativa
          notificaAdmin("Rejeitado pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nRejeitado pelo gateway de pagamento");

        } elseif($novoStatus == 'devolvido') {
          $dadosParaAtualizar['status'] = "cancelado";
          $dadosParaAtualizar['status_motivo'] = "Devolvido pelo gateway de pagamento";
    
          // notificação administrativa
          notificaAdmin("Devolvido pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nDevolvido pelo gateway de pagamento");

        } elseif($novoStatus == 'cancelado') {
          $dadosParaAtualizar['status'] = "cancelado";
          $dadosParaAtualizar['status_motivo'] = "Cancelado pelo gateway de pagamento";
    
          // notificação administrativa
          notificaAdmin("Cancelado pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nCancelado pelo gateway de pagamento");

        } elseif($novoStatus == 'reclamacao') {
          $dadosParaAtualizar['status'] = "processando";
          $dadosParaAtualizar['status_motivo'] = "Reclamação aberta pelo gateway de pagamento";
    
          // notificação administrativa
          notificaAdmin("Reclamação aberta pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nReclamação aberta pelo gateway de pagamento");


        } elseif($novoStatus == 'contestado') {
          $dadosParaAtualizar['status'] = "processando";
          $dadosParaAtualizar['status_motivo'] = "Contestação aberta pelo gateway de pagamento";
    
          // notificação administrativa
          notificaAdmin("Contestação aberta pelo gateway de pagamento", "Lançamento # $dadosLancamento->id\nContestação aberta pelo gateway de pagamento");

        } else {
          $dadosParaAtualizar['status'] = "pendente";
          $dadosParaAtualizar['status_motivo'] = "Aguardando pagamento";
        }
        
        $banco->where("id", $dadosLancamento->id)->update("lancamentos", $dadosParaAtualizar);

        echo "FINALIZOU\n";

      }

  }


}
