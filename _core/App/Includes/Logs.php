<?php

function logSalva($tipo, $detalhes) {
  global $banco;
  if(!is_string($detalhes)) {
    $detalhes = json_encode($detalhes);
  }
  $banco->insert("logs", [
    "tipo"=>$tipo,
    "detalhes"=>$detalhes,
    "criado_em"=>$banco->now()
  ]);
}