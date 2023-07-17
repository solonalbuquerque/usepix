<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class LancamentoModel extends Model
{

  static function getByChaveId($chaveId, $limpa=false) {
    global $banco;
    if($limpa == true) {
      $campos = "tipo, valor, valor_taxas, valor_total, valor_recebido, modulo_pagamento, meio_pagamento, status_pagamento, createdAt, updateAt, status, status_motivo";
    } else {
      $campos = "*";
    }
    $banco->orderBy("id", "DESC")->where('chave_id', $chaveId);
    return $banco->get('lancamentos', null, $campos);
  }

}
