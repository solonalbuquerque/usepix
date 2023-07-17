<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Home;

class AdminController
{

    public function vazio()
    {
      restritoAdmin();
      Helper::view('admin/home/index');
    }

    public function inicio()
    {
      restritoAdmin();      
      Helper::view('admin/home/index');
    }

    public function login()
    {
      
      global $banco, $erro, $sessao;

      // inserir admin no banco
      $banco->insert('admins', ['usuario' => 'admin','senha' => password_encode('123456')]);

      $erro = "";

      if(isset($_POST['usuario']) && isset($_POST['senha'])) {

        // faz a verificação do usuário e senha
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $checar = $banco->where('usuario', $usuario)->getOne('admins');

        if($checar) {
          if(password_verifica($senha, $checar['senha'])) {
            $sessao->register(120, 2); // em minutos
            $sessao->set('adminid', $checar['id']);
            $sessao->set('admin', puxaDadosUsuarioPosLoginAdmin($checar['id'], $checar['vkey']));
            header("Location: ../");exit;
          } else {
            $erro = "Senha incorreta";
          }
        } else {
          $erro = "Usuário não encontrado";
        }

      }

      Helper::view('admin/login/index');

    }

    function sair()
    {
      global $sessao;
      $sessao->end();
      header("Location: ./");exit;
    }


    

    public function pix() {
      restritoAdmin();
      
      $vars = getAllParams();
      if(isset($vars['urldata'][2]) && is_numeric($vars['urldata'][2])) {
        Helper::view('admin/home/pixdetalhes');
      } else {
        Helper::view('admin/home/pixlista');
      }

    }


    

    public function chaves() {
      restritoAdmin();
      
      $vars = getAllParams();
      if(isset($vars['urldata'][2]) && is_numeric($vars['urldata'][2])) {
        Helper::view('admin/home/chavesdetalhes');
      } else {
        Helper::view('admin/home/chaveslista');
      }

    }


    

    public function lancamentos() {
      restritoAdmin();
      
      $vars = getAllParams();
      if(isset($vars['urldata'][2]) && is_numeric($vars['urldata'][2])) {
        Helper::view('admin/home/lancamentosdetalhes');
      } else {
        Helper::view('admin/home/lancamentoslista');
      }

    }


    

    public function contas() {
      restritoAdmin();
      
      $vars = getAllParams();
      if(isset($vars['urldata'][2]) && is_numeric($vars['urldata'][2])) {
        Helper::view('admin/home/contasdetalhes');
      } else {
        Helper::view('admin/home/contaslista');
      }

    }

    

    public function saques() {
      restritoAdmin();
      
      $vars = getAllParams();
      if(isset($vars['urldata'][2]) && is_numeric($vars['urldata'][2])) {
        Helper::view('admin/home/saquesdetalhes');
      } else {
        Helper::view('admin/home/saqueslista');
      }

    }



    public function ajaxDb() {
      global $banco, $vars;
      $tabela = $vars['tabela'];
      $id = $vars['id'];
      $campo = $vars['campo'];
      $valor = $vars['valor'];
      $banco->where('id', $id)->update($tabela, [$campo => $valor]);
      echo json_encode(['status' => 'ok']);
      exit;
    }

    public function ajaxDbAlteraInfo() {
      global $banco, $vars;
      $tabela = $vars['tabela'];
      $id = $vars['id'];
      $campo = $vars['campo'];
      $valor = $vars['novoValor'];
      $banco->where('id', $id)->update($tabela, [$campo => $valor]);
      echo json_encode(['status' => 'ok']);
      exit;
    }

    public function ajaxDbSolicitaSaque() {
      global $banco, $vars, $erro;
      $contaId = $vars['conta'];
      $valor = $vars['valor'];
      $processa = solicitaSaque($contaId, $valor, 'manual');
      if($processa == false) {
        echo json_encode(['status' => 'erro', 'msg' => ($erro ? $erro : 'Erro ao solicitar saque')]);
      } else {
        echo json_encode(['status' => 'ok', 'codigo' => $processa]);
      }
      exit;
    }

    public function ajaxDbProcessaSaque() {
      global $banco, $vars, $erro;
      $solicitacaoId = $vars['solicitacaoId'];
      $metodo = $vars['metodo'];
      $bancoPag = $vars['banco'];
      $chave = $vars['chave'];
      $justificativa = $vars['justificativa'];
      $processa = processaSaque($solicitacaoId, $metodo, $bancoPag, $chave, $justificativa);
      if($processa == false) {
        echo json_encode(['status' => 'erro', 'msg' => ($erro ? $erro : 'Erro ao solicitar saque')]);
      } else {
        echo json_encode(['status' => 'ok', 'codigo' => $processa]);
      }
      exit;
    }


}
