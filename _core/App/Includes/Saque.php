<?php

// tipo: manual, automatico
function solicitaSaque($contaId, $valor, $tipo='manual') {
  global $banco;
  $conta = $banco->where('id', $contaId)->getOne('financeiro_contas');
  if(!$conta) {
    return false;
  }
  $conta = (object) $conta;
  $valor = floatval($valor);
  if($valor <= 0) {
    return false;
  }
  if($valor > $conta->saldo) {
    return false;
  }

  // calcular o valor da taxa
  $taxa = 0;

  if($tipo == 'manual') {
    $taxaFixa = $conta->saque_taxa_fixa;
    $taxaPercentual = $conta->saque_taxa_percentual;
    $tipoNome = "manual";
  } else {
    $taxaFixa = $conta->saque_automatico_taxa_fixa;
    $taxaPercentual = $conta->saque_automatico_taxa_percentual;
    $tipoNome = "automático";
  }

  if($taxaFixa > 0) {
    $taxa += $taxaFixa;
  }

  if($taxaPercentual > 0) {
    $taxa += ($valor * $taxaPercentual) / 100;
  }

  $valor_final = $valor - $taxa;

  // tira o saldo da conta e coloca em temporário
  $banco->where('id', $contaId)->update('financeiro_contas', [
    'saldo' => $conta->saldo - $valor,
    'temporario' => $conta->temporario + $valor
  ]);

  // cria a solicitação de saque
  $id = $banco->insert('solicitacoes_saque', [
    'conta_id' => $contaId,
    'valor' => $valor,
    'valor_taxas' => $taxa,
    'valor_final' => $valor_final,
    'para_chavepix_id' => $contaId,
    'tipoSolicitacao' => $tipo,
    'createdAt' => $banco->now(),
    'status' => 'pendente'
  ]);

  // registra o lançamento
  $banco->insert('financeiro', [
    'conta_id' => $contaId,
    'tipo' => 'd',
    'valor' => $valor,
    'descricao' => "Solicitação de saque $tipoNome #$id",
    'informacoes' => json_encode([
      'solicitacao_id' => $id,
      'tipo' => 'saque',
      'valor' => $valor
    ]),
    'createdAt' => $banco->now()
  ]);
  
    
  // notificação administrativa
  notificaAdmin("Nova solicitação de saque", "Nova solicitação de saque $tipoNome #$id\n\nValor: $valor\nTaxas: $taxa\nValor final: $valor_final");
  
  return $id;
}



function processaSaque($solicitacaoId, $metodo, $bancoPag, $chave, $detalhes) {
  global $banco, $erro;
  
  $solicitacao = $banco
                  ->where('id', $solicitacaoId)
                  ->getOne('solicitacoes_saque');
  if(!$solicitacao) {
    $erro = "Solicitação não encontrada";
    return false;
  }
  $solicitacao = (object) $solicitacao;

  $conta = $banco->where('id', $solicitacao->conta_id)->getOne('financeiro_contas');
  if(!$conta) {
    $erro = "Conta não encontrada";
    return false;
  }
  $conta = (object) $conta;

  $valor = floatval($solicitacao->valor);
  $valor_taxas = floatval($solicitacao->valor_taxas);
  $valor_final = floatval($solicitacao->valor_final);

  if($valor <= 0) {
    $erro = "Valor inválido";
    return false;
  }
  if($valor > $conta->temporario) {
    $erro = "Valor maior que o saldo temporário";
    return false;
  }


  // retirar do saldo temporário e colocar na saídas
  $banco->where('id', $conta->id)->update('financeiro_contas', [
    'temporario' => $conta->temporario - $valor,
    'saidas' => $conta->saidas + $valor
  ]);

  // na solicitacoes_saque, atualizar o status para "concluido" e salvar informações sobre o pagamento
  $banco->where('id', $solicitacaoId)->update('solicitacoes_saque', [
    'status' => 'concluido',
    'status_motivo' => 'Foi concluído a transferência do valor para a chave PIX informada',
    'informacoesPagamentoBanco' => $bancoPag,
    'informacoesPagamentoMetodo' => $metodo,
    'informacoesPagamentoChave' => $chave,
    'informacoesPagamento' => $detalhes,
    'updatedAt' => $banco->now(),
    'resolvidoAt' => $banco->now()
  ]);
  
  FinanceiroModel::addLancamento("taxas", "c", $valor_taxas, "Taxas do saque # $solicitacao->id", []);
    
  // notificação administrativa
  notificaAdmin("Solicitação de saque concluída", "Solicitação de saque #$solicitacaoId concluída\n\nValor no extrato do cliente: $valor\nValor real: $solicitacao->valor_final\nBanco: $bancoPag\nMétodo: $metodo\nChave: $chave\nDetalhes: $detalhes");


  return true;

}