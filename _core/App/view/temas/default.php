
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <base href="<?php echo BASE_URL; ?>">
    <title>UsePix<?php if($titulo!="") echo " - ".$titulo; ?></title>

  <!-- include jquery cdn -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css">
  <script src="./assets/js/mask.js"></script>
  <script src="./assets/js/underscore-min.js"></script>
  <script src="./assets/js/jquery.countdown.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>

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
      .navbar-brand:hover *{
        text-decoration: none !important;
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .container {
        max-width: 900px;
      }

      .bg-topo{
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#36b3a9+0,01787f+100 */
background: #36b3a9; /* Old browsers */
background: -moz-linear-gradient(left,  #36b3a9 0%, #01787f 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(left,  #36b3a9 0%,#01787f 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to right,  #36b3a9 0%,#01787f 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#36b3a9', endColorstr='#01787f',GradientType=1 ); /* IE6-9 */

      }

      .btn-gerarqr:hover{
        background-color: #01787f !important;
        border-color: #01787f !important;
        color: #fff !important;
        text-decoration: none !important;
      }

    </style>

    
    <!-- Custom styles for this template -->
  </head>
  <body class="bg-light">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSBQHJT"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="topo bg-topo mb-2">
      <div class="container">

        <header class="navbar navbar-expand-md navbar-dark d-print-none bg-transparent border-0">
          <div class="container-xl">
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
              <a href="./" title="UsePix">
                <strong class="text-white">Use</strong>
                <span><img src="assets/images/logo_pix_02.png" alt="Use Pix" /></span>
              </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
              <div class="nav-item d-md-flex me-3">
                <div class="btn-list">
                  <!--
                    <a href="" class="btn btn-link text-white">
                      Ajuda
                    </a>
                  -->
                  <a href="./gerar-qrcode" class="btn btn-link text-white px-1 btn-gerarqr">
                    Gerar QrCode
                  </a>
                  <a href="#novopixDiv" data-bs-toggle="offcanvas" role="button" aria-controls="novopixDiv" class="btn btn-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus d-none" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo PIX
                  </a>
                </div>
              </div>
            </div>
          </div>
        </header>
        
      </div>
    </div>
    
<div class="container">
  <main>

    <?php echo $c; ?>

  </main>

  <form id="novopixForm1" autocomplete="true">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="novopixDiv" aria-labelledby="novopixDivLabel">
      <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="novopixDivLabel">Novo UsePIX</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div>

            <div class="mb-4">
              <div class="form-floating mb-0">
                <input type="text" class="form-control" id="novopix_chave1" placeholder="Digite sua chave PIX" name="chavePix">
                <label for="novopix_chave">Digite sua Chave PIX*</label>
              </div>
              <span class="text-muted small">Aceita e-mail, telefone, CPF e CNPJ.</span>
            </div>
            
            <div class="mb-4">
              <div class="form-floating mb-0">
                <input type="tel" class="form-control moneyMask" id="novopix_valor1" value="1.00" autocomplete="off" placeholder="0.00" maxlength="9">
                <label for="novopix_valor">Valor a Receber*</label>
              </div>
              <span class="text-muted small">Você receberá 100% do valor.</span>
            </div>

            <div class="mb-4">
              <div class="form-floating mb-0">
                <input type="text" class="form-control" id="novopix_referencia1" placeholder="Qual a referência do recebimento?">
                <label for="novopix_referencia">Qual a referência do recebimento?</label>
              </div>
              <span class="text-muted small">Exemplo: doação de janeiro; sapato preto 35 do Roberto; OS-0005; NF-0005; etc. Vai individualizar o novo PIX. Deixando em branco criaremos um código único para ela.</span>
            </div>

        </div>
        <div class="mt-3">
          <button class="btn btn-primary" type="submit">
            Criar
          </button>
        </div>
      </div>
    </div>

  </form>
  

  <footer class="py-2 mt-3 text-muted text-center text-small">
    <p class="mb-1">&copy; <?php echo date("Y");?> UsePIX</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="./desenvolvedores">API - Desenvolvedores</a></li>
      <li class="list-inline-item"><a href="./privacidade">Privacidade</a></li>
      <li class="list-inline-item"><a href="./termos">Termos</a></li>
      <li class="list-inline-item"><a href="./tarifas-e-prazos">Tarifas & Prazos</a></li>
      <li class="list-inline-item"><a href="./suporte">Suporte</a></li>
    </ul>
  </footer>
</div>

<script>
$(document).ready(function(){
  $('.moneyMask').mask('#####0.00', {reverse: true});
  // form on submit
  $('#novopixForm1').submit(function(){
    event.preventDefault();
    criarNovoPix(1);
  });
  $('#novopixForm2').submit(function(){
    event.preventDefault();
    criarNovoPix(2);
  });
  var clipboard = new ClipboardJS('.copy-ref');

  clipboard.on('success', function(e) {
    if(e.action == "copy") {
      Swal.fire(
        'Dados copiados!',
        'Agora é só colar no seu app para compartilhar',
        'success'
      );
    }
    e.clearSelection();
  });

  clipboard.on('error', function(e) {
      console.error('Action:', e.action);
      console.error('Trigger:', e.trigger);
  });
});
function criarNovoPix(bloco) {
  const chave = document.getElementById('novopix_chave'+bloco).value;
  const valor = document.getElementById('novopix_valor'+bloco).value;
  const referencia = document.getElementById('novopix_referencia'+bloco).value;
  if(chave == "") {
    Swal.fire(
      'Qual sua chave PIX?',
      'Esse é um campo obrigatório e não pode ficar em branco.',
      'question'
    );
    return;
  }
  let url = "";
  if(valor>0 && referencia!="") {
    url = `${chave}/${valor}/${referencia}`;
  } else if(valor>0 && referencia=="") {
    url = `${chave}/${valor}`;
  } else if(valor=="" && referencia!="") {
    url = `${chave}//${referencia}`;
  } else {
    url = `${chave}`;
  }
  // redirect to url
  window.location.href = urlBase + url;
}
</script>


  </body>
</html>