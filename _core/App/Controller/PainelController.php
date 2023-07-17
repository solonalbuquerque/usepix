<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Home;

class PainelController
{

    public function vazio()
    {
      restrito();
        Helper::view('painel/home/index');
    }

    public function inicio()
    {
      restrito();
      Helper::view('painel/home/index');
    }

    public function login()
    {
      
      global $banco, $erro, $sessao;

      $erro = "";

      if(isset($_POST['usuario']) && isset($_POST['senha'])) {

        // faz a verificação do usuário e senha
        $usuario = somenteNumeros($_POST['usuario']);
        $senha = $_POST['senha'];

        $checar = $banco->where('telefone', $usuario)->getOne('users');

        if($checar) {
          if(password_verifica($senha, $checar['senha'])) {
            $sessao->register(120, 2); // em minutos
            $sessao->set('userid', $checar['id']);
            $sessao->set('user', puxaDadosUsuarioPosLogin($checar['id'], $checar['vkey']));
            header("Location: ../");exit;
          } else {
            $erro = "Senha incorreta";
          }
        } else {
          $erro = "Usuário não encontrado";
        }

      }

      Helper::view('painel/login/index');

    }

    function sair()
    {
      global $sessao;
      $sessao->end();
      header("Location: ./");exit;
    }

}
