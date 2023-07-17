<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class ChavesPixModel extends Model
{

  static function getOrAdd($tipoChave, $chave, $tipoDoCadastro='normal') {
    global $banco;
    $banco->where('chave_tipo', $tipoChave);
    $banco->where('chave', $chave);

    $item = (object) $banco->getOne('chavespix');
    
    if(isset($item->id)) {
      return $item;
    }

    // ultimo sql
    //echo $banco->getLastQuery();

    $dados = [
      'chave' => $chave,
      'chave_tipo' => $tipoChave,
      'createdAt' => $banco->now(),
      'updateAt' => $banco->now(),
    ];
    $id = $banco->insert('chavespix', $dados);
    $item = (object) $banco->where("id", $id)->getOne('chavespix');
    
    // notificação de nova chave
    notificaAdmin("Nova chave PIX", "Nova chave PIX cadastrada:\nChave: {$chave} ({$tipoChave})\nTipo do cadastro: $tipoDoCadastro");
    
    return $item;
  }

  static function getByChavePixId($chavePixId) {
    global $banco;
    $banco->where('id', $chavePixId);
    return (object) $banco->getOne('chavespix');
  }

}
