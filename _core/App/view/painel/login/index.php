<?php

$tema = "painel.login";
$titulo = "Login";

if(is_admin()) {
  header("Location: ../../".PAINEL_PREFIX);exit;
}

global $erro;

$c = '
  <h2 class="h2 text-center mb-4">Seja Bem Vindo ao UsePix!</h2>
  <p>Experimente um novo fluxo de acesso com sua rede social preferida.</p>

  <div class="d-block w-100 text-center">
  
    <a class="btn btn-block btn-outline-secondary btn-square my-2 w-100">
      <span class="fa fa-google"></span>
      Continuar com o Google
    </a>
    <a class="btn btn-block mx-auto my-2 w-100">
      <span class="fa fa-microsoft"></span>
      Continuar com a conta Microsoft
    </a>
  </div>
  
  <div class="text-center text-muted mt-4">
    <a href="../" tabindex="-1">Voltar para o site</a>
  </div>
';

/*
  <h2 class="h2 text-center mb-4">Seja Bem Vindo ao UsePix!</h2>
  <p>Experimente um novo fluxo de acesso. Digite o seu telefone e receba um código para acessar. Se ainda não tem cadastro, faremos ele automaticamente.</p>
  <form action="./login/" method="post" novalidate>
    <div class="mb-3">
      <label class="form-label">Telefone (apenas do Brasil)</label>
      <input type="tel" class="form-control phone" name="usuario" id="usuario"
        value="'.( isset($_POST['usuario']) ? $_POST['usuario'] : "" ).'">
    </div>
    <div class="form-footer">
      <button type="submit" class="btn btn-primary w-100">CONTINUAR</button>
    </div>
  </form>
  */

if($erro!="") {
  $c.= '
  <script>
    Swal.fire({
      title: "Erro",
      text: "'.$erro.'",
      icon: "error",
      confirmButtonText: "Ok"
    });
    $(document).ready(function(){
      // verificar se o username foi digitado e focar na senha
      if($("#usuario").val()!="") {
        $("#senha").focus();
      } else {
        $("#usuario").focus();
      }
    });
  </script>
  ';
}