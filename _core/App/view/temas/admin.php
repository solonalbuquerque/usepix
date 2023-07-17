
<!doctype html>
<html lang="en">
  <head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WSBQHJT');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="<?php echo BASE_URL; ?>/<?php echo ADMIN_PREFIX; ?>/">
    <title>UsePix<?php if($titulo!="") echo " - ".$titulo; ?></title>

  <!-- include jquery cdn -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script>
    const urlBase = "<?php echo BASE_URL; ?>/";
  </script>


    <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#712cf9">

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
      .podeAlterar span{
        cursor: pointer;
      }
      .podeAlterar:hover span{
        background-color: yellow;
      }
    </style>

  </head>
  <body class="theme-light">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSBQHJT"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="page">


      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              UsePIX <span class="text-red">| administração</span>
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($admin->email);?>)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $admin->primeiroNome;?></div>
                  <div class="mt-1 small text-muted"><?php echo $admin->titulo;?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="./perfil" class="dropdown-item">Perfil</a>
                <a href="./sair" class="dropdown-item">Sair</a>
              </div>
            </div>
          </div>
        </div>
      </header>



      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="./pix">
                    <span class="nav-link-title">
                      Pix
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./chaves">
                    <span class="nav-link-title">
                      Chaves
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./lancamentos">
                    <span class="nav-link-title">
                      Lançamentos
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./contas">
                    <span class="nav-link-title">
                      Contas
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./saques">
                    <span class="nav-link-title">
                      Saques
                    </span>
                  </a>
                </li>
                <!--
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg>
                    </span>
                    <span class="nav-link-title">
                      Extra
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                      <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="./activity.html">
                          Activity
                        </a>
                        <a class="dropdown-item" href="./gallery.html">
                          Gallery
                        </a>
                        <a class="dropdown-item" href="./invoice.html">
                          Invoice
                        </a>
                        <a class="dropdown-item" href="./search-results.html">
                          Search results
                        </a>
                        <a class="dropdown-item" href="./pricing.html">
                          Pricing cards
                        </a>
                        <a class="dropdown-item" href="./pricing-table.html">
                          Pricing table
                        </a>
                        <a class="dropdown-item" href="./faq.html">
                          FAQ
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./users.html">
                          Users
                        </a>
                        <a class="dropdown-item" href="./license.html">
                          License
                        </a>
                        <a class="dropdown-item" href="./logs.html">
                          Logs
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                      </div>
                      <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="./music.html">
                          Music
                        </a>
                        <a class="dropdown-item" href="./photogrid.html">
                          Photogrid
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./tasks.html">
                          Tasks
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./uptime.html">
                          Uptime monitor
                        </a>
                        <a class="dropdown-item" href="./widgets.html">
                          Widgets
                        </a>
                        <a class="dropdown-item" href="./wizard.html">
                          Wizard
                        </a>
                        <a class="dropdown-item" href="./settings.html">
                          Settings
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./trial-ended.html">
                          Trial ended
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./job-listing.html">
                          Job listing
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                        <a class="dropdown-item" href="./page-loader.html">
                          Page loader
                          <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
                -->
              </ul>
            </div>
          </div>
        </div>
      </header>

      <div class="page-wrapper">


        <div class="page-header d-print-noneX">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  <?php
                  if($linkVoltar!="") {
                    echo '<a href="'.$linkVoltar.'" class="avatar bg-azure-lt me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M5 12l14 0"></path>
                      <path d="M5 12l4 4"></path>
                      <path d="M5 12l4 -4"></path>
                  </svg>
                    </a>';
                  }
                  ?>
                  <?php echo $titulo; ?>
                  <?php
                  if($showBusca==true) {?>
                  <form class="ps-2">
                    <div class="input-group input-group-flat">
                      <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                      <span class="input-group-text">
                        <?php
                          if($q!="") {
                            echo '
                            <a href="./'.$linkAtual.'" class="link-secondary" data-bs-toggle="tooltip" aria-label="Limpar busca" data-bs-original-title="Limpar busca">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>
                            </a>';
                          }
                        ?>
                        <a href="#" class="link-secondary ms-2 disabled" data-bs-toggle="tooltip" aria-label="Buscar" data-bs-original-title="Buscar">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                        </a>
                      </span>
                    </div>
                  </form>
                  <?php } ?>
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                  <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                  Imprimir
                </button>
              </div>
            </div>
          </div>
        </div>


        <div class="page-body">
          <div class="container-xl">


            <?php echo $c; ?>


          </div>
        </div>

      </div>


  </div>





  
<div class="modal modal-blur fade" id="modal-changeinfo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alterar Informação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idchangeinfoData" value="" />
        <div class="row mb-3 align-items-end">
          <div class="col">
            <label class="form-label" id="campoDescricaochangeinfo">Novo valor:</label>
            <input type="text" class="form-control" name="novovalor" id="novovalorchangeinfo" />
          </div>
        </div>
        <div>
          <label class="form-label">Justificativa:</label>
          <textarea class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="enviarChangeinfo">Salvar</button>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function(){
  

  // capture change select .atualizastatus
  $('.atualizastatus').change(function(){
    var id = $(this).attr('data-id');
    var novoStatus = $(this).val();
    var tabela = $(this).attr('data-tabela');
    var campo = $(this).attr('data-campo');
    var dados = 'id='+id+'&tabela='+tabela+'&campo='+campo+'&valor='+novoStatus;
    $.ajax({
      type: 'POST',
      url: 'ajaxDb',
      data: dados,
      success: function(data) {
        data = JSON.parse(data);
        if(data.status == 'ok'){
          Swal.fire({
            title: 'Sucesso!',
            text: data.msg,
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
          setTimeout(function(){
            location.reload();
          }, 3000);
        } else {
          Swal.fire({
            title: "Erro!",
            text: data.msg,
            icon: "error",
            confirmButtonText: "Ok"
          });
        }
      }
    });
  });

  // capture click on .podeAlterar
  $('.podeAlterar').click(function(){
    var id = $(this).attr('data-id');
    var tabela = $(this).attr('data-tabela');
    var campo = $(this).attr('data-campo');
    var valor = $(this).attr('data-valor');
    var titulo = $(this).attr('data-titulo');
    var dados = 'tabela='+tabela+'&id='+id+'&campo='+campo+'&valor='+valor+'&novoValor=';
    $("#campoDescricaochangeinfo").html(titulo+":");
    $("#novovalorchangeinfo").val(valor);
    $("#idchangeinfoData").val(dados);
    $('#modal-changeinfo').modal('show');
  });

  // captura click no botão salvar do modal #enviarChangeinfo
  $("#enviarChangeinfo").click(function(){
    var dados = $("#idchangeinfoData").val();
    var novoValor = $("#novovalorchangeinfo").val();
    dados = dados+novoValor;
    $.ajax({
      type: 'POST',
      url: 'ajaxDbInfo',
      data: dados,
      success: function(data) {
        data = JSON.parse(data);
        if(data.status == 'ok'){
          Swal.fire({
            title: 'Sucesso!',
            text: data.msg,
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
          setTimeout(function(){
            location.reload();
          }, 3000);
        } else {
          Swal.fire({
            title: "Erro!",
            text: data.msg,
            icon: "error",
            confirmButtonText: "Ok"
          });
        }
      }
    });
  });


});
</script>


  </body>
</html>