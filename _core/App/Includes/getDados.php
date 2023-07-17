<?php

$_getChave = [];
function getChave($id, $campo) {
  global $banco, $_getChave;
  if(isset($_getChave[$id])) {
    return $_getChave[$id]->$campo;
  }
  $item = (object) $banco->where("id", $id)->getOne("chaves");
  $_getChave[$id] = $item;
  return $item->$campo;
}


$_getChavepix = [];
function getChavepix($id, $campo) {
  global $banco, $_getChavepix;
  if(isset($_getChavepix[$id])) {
    return $_getChavepix[$id]->$campo;
  }
  $item = (object) $banco->where("id", $id)->getOne("chavespix");
  $_getChavepix[$id] = $item;
  return $item->$campo;
}


$_getConta = [];
function getConta($id, $campo) {
  global $banco, $_getConta;
  if(isset($_getConta[$id])) {
    return $_getConta[$id]->$campo;
  }
  $item = (object) $banco->where("id", $id)->getOne("financeiro_contas");
  $_getConta[$id] = $item;
  return $item->$campo;
}