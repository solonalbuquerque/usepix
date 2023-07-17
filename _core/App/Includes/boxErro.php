<?php

function boxErro($titulo, $mensagem="", $botoes=true) {
  $c = '
  <div class="page page-center">
    <div class="container-tight py-4">
      <div class="empty">
        <p class="empty-title h1 mb-3">'.$titulo.'</p>
        <p class="empty-subtitle text-muted">
        '.$mensagem.'
        </p>
        ';
        if($botoes=="fechar") {
          $c.= '
          <div class="empty-action">
            <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
              Fechar
            </button>
          </div>';
        } else if($botoes==true) {
          $c.= '
          <div class="empty-action">
            <a href="#novopixDiv" data-bs-toggle="offcanvas" role="button" aria-controls="novopixDiv" class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Gerar Novo PIX
            </a>
          </div>
          <div class="empty-action">
            <a href="./" class="btn btn-link">
              <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
              Voltar para a página inicial
            </a>
          </div>';
        }
        $c.= '
      </div>
    </div>
  </div>
  ';

  return $c;

}