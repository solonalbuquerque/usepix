<?php

$tema = "default";
$titulo = "Central de Ajuda";

$c = '
<div class="page-header my-4">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h1 class="page-title h1">
          Central de Ajuda
        </h1>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">

    <div class="divide-y">
      
      <div id="perguntasFrequentesPix" class="mb-3">
        <h2 class="fw-light py-2">Perguntas Frequentes no Pagamento do PIX</h2>
        <div class="accordion" id="accordion-fq2">
        ';
        $i = 1;
        foreach($_perguntaFrequentesPix as $pergunta=>$resposta) {
          $c.= '
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-1">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-qa'.$i.'" aria-expanded="false">
              '.$pergunta.'
              </button>
            </h2>
            <div id="collapse-qa'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion-fq2" style="">
              <div class="accordion-body pt-0">
              '.$resposta.'
              </div>
            </div>
          </div>';
          $i++;
        }
        $c.= '
        </div>
      </div>
    
      <div id="perguntasFrequentes" class="mb-3">
        <h2 class="fw-light py-2">Outras Perguntas Frequentes</h2>
        <div class="accordion" id="accordion-fq1">
        ';
        $i = 1;
        foreach($_perguntaFrequentes as $pergunta=>$resposta) {
          $c.= '
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading-'.$i.'">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-qax'.$i.'" aria-expanded="false">
              '.$pergunta.'
              </button>
            </h2>
            <div id="collapse-qax'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion-fq1" style="">
              <div class="accordion-body pt-0">
              '.$resposta.'
              </div>
            </div>
          </div>';
          $i++;
        }
        $c.= '
        </div>
      </div>
      
      <div>
        <h2 class="fw-light py-2">Tem mais alguma dúvida?</h2>
        <p>Entre em contato conosco utilizando um dos canais abaixo:</p>
        <p>
        ';
          if($_dadosContato['email']!="") {
            $c.= '
            <a href="mailto:'.$_dadosContato['email'].'" target="_blank" class="btn btn-sm btn-success me-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <rect x="3" y="5" width="18" height="14" rx="2" />
              <polyline points="3 7 12 13 21 7" />
            </svg>
            E-mail
            </a>';
          }
          if($_dadosContato['telefone']!="") {
            $c.= '
            <a href="tel:'.somenteNumeros($_dadosContato['telefone']).'" target="_blank" class="btn btn-sm btn-success me-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
            </svg>
            Telefone: '.$_dadosContato['telefone'].'
            </a>';
          }
          if($_dadosContato['whatsapp']!="") {
            $c.= '
            <a href="https://wa.me/55'.somenteNumeros($_dadosContato['whatsapp']).'" target="_blank" class="btn btn-sm btn-success me-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
              <path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />
            </svg>
            WhatsApp: '.$_dadosContato['whatsapp'].'
            </a>';
          }
        $c.= '

          
        </p>
      </div>

    </div>

  </div>
</div>
';