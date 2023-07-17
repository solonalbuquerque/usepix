<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\ChaveModel;

class ChaveController
{

  static public function checaUrl() {
    global $url, $chave;

    if($url[0] == ADMIN_PREFIX) {
      header("Location: /".ADMIN_PREFIX."/");
      exit;
    } else if($url[0] == PAINEL_PREFIX) {
      header("Location: /".PAINEL_PREFIX."/");
      exit;
    } elseif($url[0] == "login") {
      header("Location: /".PAINEL_PREFIX."/login/");
      exit;
    }

    // validar o tipo da chave
    $tipoChave = tipoDaChave($url[0]);

    if($tipoChave == false) {
      Helper::view('default/chave/erro-chave-invalida');
      exit;
    }

    $dadosUp = [];
    $dadosUp['chave'] = $url[0];
    $dadosUp['valor'] = (isset($url[1])) ? $url[1] : '';
    $dadosUp['referencia'] = (isset($url[2])) ? urldecode($url[2]) : '';
    
    $dados = ChaveModel::getOrAdd($dadosUp, false);

    /*if($dadosUp['referencia']=="") {
      header("Location: /".$url[0]."/".$dados->chave_valor."/".urlencode($dados->chave_identificador));
      exit;
    }*/

    // checa se deseja retorno via JSON
    if(isset($_GET['pay'])) {
    
      $chave = ChaveModel::completo($dados->id);
      if($chave->status=="captando") {
        Helper::view('default/chave/framePagamento');
      } else {
        Helper::view('default/chave/frameProcessando');
      }
      exit;
    }

    // checa se deseja retorno via JSON
    if(isset($_GET['json'])) {
      header('Content-Type: application/json');
      echo json_encode($dados);
      exit;
    }
    
    $chave = ChaveModel::completo($dados->id);
    
    Helper::view('default/chave/index');
    exit;
    
  }

  static public function criarOuDetalhes($dados) {

    $dados = (object) $dados;

    $dados = ChaveModel::getOrAdd( (object) $dados);

  }

}
