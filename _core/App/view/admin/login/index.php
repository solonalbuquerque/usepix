<?php

$tema = "admin.login";
$titulo = "Login";

if(is_admin()) {
  header("Location: ../../".ADMIN_PREFIX);exit;
}

global $erro;

$c = '
  <h2 class="h2 text-center mb-4">Acesso para Colaboradores</h2>
  <form action="./login/" method="post" novalidate>
    <div class="mb-3">
      <label class="form-label">Usuário</label>
      <input type="text" class="form-control" name="usuario" id="usuario"
        value="'.( isset($_POST['usuario']) ? $_POST['usuario'] : "" ).'">
    </div>
    <div class="mb-2">
      <label class="form-label">
        Senha
      </label>
      <div class="input-group input-group-flat">
        <input type="password" class="form-control" name="senha" id="senha" autocomplete="off">
        <span class="input-group-text">
          <a href="#" class="link-secondary" title="Exibir" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
          </a>
        </span>
      </div>
    </div>
    <div class="form-footer">
      <button type="submit" class="btn btn-primary w-100">Acessar</button>
    </div>
  </form>
';

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