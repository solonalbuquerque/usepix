<?php

function atualizarCampo($tabela, $campo, $valor, $campoWhere, $valorWhere) {
  global $banco;
  $banco->where($campoWhere, $valorWhere);
  $banco->update($tabela, [$campo => $valor, "updateAt"=>$banco->now()]);
}

function atualizarCampoLancamento($campo, $valor, $campoWhere, $valorWhere) {
  atualizarCampo('lancamentos', $campo, $valor, $campoWhere, $valorWhere);
}
function atualizarCampoLancamentoStatus($status, $status_motivo, $IdLancamento) {
  atualizarCampo('lancamentos', "status", $status, "id", $IdLancamento);
  atualizarCampo('lancamentos', "status_motivo", $status_motivo, "id", $IdLancamento);
}



function atualizarCampoChave($campo, $valor, $campoWhere, $valorWhere) {
  atualizarCampo('chaves', $campo, $valor, $campoWhere, $valorWhere);
}