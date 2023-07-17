<?php

function password_encode($senha) {
  return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
}

function password_verifica($senha, $hash) {
  return password_verify($senha, $hash);
}

$usuario = "";

function is_admin() {
  global $sessao, $admin;
  $check = $sessao->get('admin') ? true : false;
  if($check) {
    $admin = (object) $sessao->get('admin');
    if(isset($admin->id) && isset($admin->vkey)) return true;
  }
  return false;
}

function is_user() {
  global $sessao, $usuario;
  $check = $sessao->get('user') ? true : false;
  if($check) {
    $usuario = (object) $sessao->get('user');
    if(isset($usuario->id) && isset($usuario->vkey)) return true;
  }
  return false;
}

function restrito() {
  global $sessao;
  sessaoValidar();
  if(!is_user()) {
    $sessao->end();
    header("Location: ../".PAINEL_PREFIX."/login/");exit;
  }
  return true;
}

function restritoAdmin() {
  global $sessao;
  sessaoValidar();
  if(!is_admin()) {
    $sessao->end();
    header("Location: ../".ADMIN_PREFIX."/login/");exit;
  }
  return true;
}

function sessaoValidar() {
  global $sessao;
  if ($sessao->isRegistered()) {
    // Check to see if the session has expired.
    // If it has, end the session and redirect to login.
    if ($sessao->isExpired()) {
      $sessao->end();
      header("Location: ./login/");exit;
    } else {
      // Keep renewing the session as long as they keep taking action.
      $sessao->renew();
      if($sessao->isExpiredUp()) {
        $sessao->update();
        $checkAdmin = $sessao->get('admin') ? true : false;
        if($checkAdmin) {
          $dados = (object) $sessao->get('admin');
          $sessao->set('admin', puxaDadosUsuarioPosLoginAdmin($dados->id, $dados->vkey));
        }
        $checkUser = $sessao->get('user') ? true : false;
        if($checkUser) {
          $dados = (object) $sessao->get('user');
          $sessao->set('user', puxaDadosUsuarioPosLogin($dados->id, $dados->vkey));
        }
      }
    }
  } else {
    header("Location: ./login/");exit;
  }
}

function puxaDadosUsuarioPosLoginAdmin($id, $vkey) {
  global $banco;
  $usuario = (object) $banco
              ->where('id', $id)
              ->where('vkey', $vkey)
              ->getOne('admins');
  if($usuario) {
    unset($usuario->senha);
    return (object) $usuario;
  } else {
    header("Location: ./login/");
    exit;
  }
}

function puxaDadosUsuarioPosLogin($id, $vkey) {
  global $banco;
  $usuario = (object) $banco
              ->where('id', $id)
              ->where('vkey', $vkey)
              ->getOne('users');
  if($usuario) {
    unset($usuario->senha);
    return (object) $usuario;
  } else {
    header("Location: ./login/");
    exit;
  }
}