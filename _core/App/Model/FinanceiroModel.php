<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Model\ChavesPixModel;
use SmartSolucoes\Libs\Helper;

class FinanceiroModel extends Model
{


  static function getConta($conta) {
    global $banco;

    // puxa o ID da conta
    $item = (object) $banco->where("conta", $conta)->getOne("financeiro_contas", "id");
    if(isset($item->id)) {
      return $item;
    }
    
    $dados = [
      'conta' => $conta,
      'createdAt' => $banco->now(),
      'updateAt' => $banco->now(),
    ];
    $id = $banco->insert('financeiro_contas', $dados);
    $item = (object) $banco->where("id", $id)->getOne('financeiro_contas');
    
    return $item;

  }

  static function addLancamento($conta, $tipo, $valor, $descricao, $informacoes=[]) {
    global $banco;

    $contaData = FinanceiroModel::getConta($conta);
    $contaId = $contaData->id;

    $dados = [
      'conta_id' => $contaId,
      'tipo' => $tipo,
      'valor' => $valor,
      'descricao' => $descricao,
      'informacoes' => json_encode($informacoes),
      'createdAt' => $banco->now(),
    ];
    $banco->insert('financeiro', $dados);

    if($tipo=="c") {
      $saldo = $valor;
    } else {
      $saldo = $valor * -1;
    }
    $dados = [
      'saldo' => $banco->inc($saldo),
      'recebidos' => $banco->inc($saldo),
      'updateAt' => $banco->now(),
    ];
    $banco->where("id", $contaId)->update('financeiro_contas', $dados);

    FinanceiroModel::processaSaqueAutomatico($contaId);

    return true;

  }


  public function processaSaqueAutomatico($contaId) {
    global $banco;

    logSalva("processaSaqueAutomatico", "contaId: $contaId");

    $contaData = (object) $banco->where("id", $contaId)->getOne('financeiro_contas');
    logSalva("processaSaqueAutomatico", $contaData);
    
    // verifica se o valor do saldo já permite saque automático
    if($contaData->saque_automatico == "s") {

      $saldo = floatval($contaData->saldo);
      if($saldo >= $contaData->saque_automatico_minimo) {
        solicitaSaque($contaId, $saldo, 'automatico');
      }

    }

    return true;

  }

}
