<?php

$tema = "default";
$titulo = "Página inicial";

$autorizaPagamento = false;

$c = '

<div class="row g-5X py-3">
  <div class="col-md-6 col-lg-5 order-md-last bg-whiteX">
    <div class="sticky-top mb-4">

      <div class="card">
        <div class="card-body">

        
              
          <div class="row mb-3">
            <div class="col">
              <h2 class="card-titleX strong m-0">RESUMO DO PIX</h2>
            </div>
            <div class="col-auto">
              <a href="#qrcode" data-bs-toggle="offcanvas" role="button" aria-controls="qrcode" class="link-muted" title="QrCode">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-qrcode" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <rect x="4" y="4" width="6" height="6" rx="1" />
                  <line x1="7" y1="17" x2="7" y2="17.01" />
                  <rect x="14" y="4" width="6" height="6" rx="1" />
                  <line x1="7" y1="7" x2="7" y2="7.01" />
                  <rect x="4" y="14" width="6" height="6" rx="1" />
                  <line x1="17" y1="7" x2="17" y2="7.01" />
                  <line x1="14" y1="14" x2="17" y2="14" />
                  <line x1="20" y1="14" x2="20" y2="14.01" />
                  <line x1="14" y1="14" x2="14" y2="17" />
                  <line x1="14" y1="20" x2="17" y2="20" />
                  <line x1="17" y1="17" x2="20" y2="17" />
                  <line x1="20" y1="17" x2="20" y2="20" />
                </svg>
              </a>
            </div>
            <div class="col-auto" title="Compartilhar">
            <a href="#compartilhar" data-bs-toggle="offcanvas" role="button" aria-controls="compartilhar" class="link-muted" title="Compartilhar">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path><path d="M8.7 10.7l6.6 -3.4"></path><path d="M8.7 13.3l6.6 3.4"></path></svg>
              </a>
            </div>
          </div>
      
          <div class="divide-y">
            <div>
              <div class="row">
                <div class="col">
                  <div class="text-truncate">
                    '.$chave->chave.'
                  </div>
                  <div class="text-muted small lh-base">Chave PIX: <span class="text-capitalize">'.$chave->chave_tipo.'</span></div>
                </div>
                <div class="col-auto align-self-center">
                  <div class="badge bg-primary"></div>
                </div>
              </div>
            </div>
            <div>
              <div class="row">
                <div class="col">
                  <div class="text-truncateX">
                    <strong>Referência:</strong> ';
                      if($chave->chave_identificador=="") {
                        $c.= "-";
                      } else {
                        $c.= $chave->chave_identificador;
                      }
                      $c.= '
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="row">
                <div class="col">
                  <div class="text-truncate">
                    <strong>Valor Total:</strong> R$ '.formataMoedaBRL($chave->chave_valor).'
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="row">
                <div class="col">
                  <div class="text-truncate text-success">
                    <strong>Valor Pago:</strong> R$ '.formataMoedaBRL($chave->valor_recebido).'
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="row">
                <div class="col">
                  <div class="text-truncate text-warning">
                    <strong>Saldo Restante:</strong> R$ '.formataMoedaBRL($chave->valor_diferenca).'
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Card footer -->
        <div class="card-footer">
          <div class="d-flex">
          ';
          if($chave->status=="captando") {
            $autorizaPagamento = true;
            $c.= '<a href="#pagarDiv" data-bs-toggle="offcanvas" role="button" aria-controls="pagarDiv" class="btn btn-primary me-2" id="botaoPagar">
              Pagar
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-1 me-0" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="5" y1="12" x2="19" y2="12" />
                <line x1="13" y1="18" x2="19" y2="12" />
                <line x1="13" y1="6" x2="19" y2="12" />
              </svg>
            </a>';
          }
          $c.= '
            <a href="#denunciarDiv" data-bs-toggle="offcanvas" role="button" aria-controls="denunciarDiv" class="btn btn-link">Denunciar</a>
          </div>
        </div>
      </div>

      <div class="block mt-4 ps-2">
        <h4>Saiba mais:</h4>
        <ul>
          <li><a href="#meiosDePagamento" data-bs-toggle="offcanvas" role="button" aria-controls="meiosDePagamento">Meios de pagamento aceitos</a></li>
          <li><a href="#garantias" data-bs-toggle="offcanvas" role="button" aria-controls="garantias">Garantia do pagamento</a></li>
          <li><a href="'.$_urlCompleta.'#perguntasFrequentes">Outras dúvidas</a></li>
        </ul>
      </div>

    </div>
  </div>
  <div class="col-md-6 col-lg-7">

    <div class="card">
      <div class="card-body">
        
        <div class="divide-y pb-2">

          <div>
            <h2 class="fw-light py-2">Descrição</h2>
            <p>';
            if($chave->descricao) {
              $c.= $chave->descricao;
            } else {
              $c.= 'Não há descrição para essa chave.';
            }
            $c.= '</p>
          </div>

          <div>
            <h2 class="fw-light py-2">Lançamentos Financeiros</h2>
            ';

            $qtdPgtos = count($chave->lancamentos);
            if($qtdPgtos==1) {
              $c.= '
              <p>Exibindo o único lançamento financeiro para esse PIX.</p>';
            } else {
              $c.= '
              <p>Exibindo todos os '.$qtdPgtos.' lançamentos financeiros para esse PIX.</p>';
            }

            if(count($chave->lancamentos)>0) {
              $c.= '<div class="divide-y mb-4">';
                
                // loop dos lancamentos
                foreach($chave->lancamentos as $lancamento) {
                  $lancamento = (object) $lancamento;
                  $status = $lancamento->status;

                  if($lancamento->tipo=="c") {
                    $tipo = "green";
                    $sinal = "+";
                  } else if($lancamento->tipo=="d") {
                    $tipo = "red";
                    $sinal = "-";
                  }

                  if($status=="concluido") {
                    $info = 'Transação paga';
                  } else if($status=="pendente") {
                    $info = 'Transação pendente';
                  } else if($status=="cancelado") {
                    $info = 'Transação cancelada';
                    $tipo = "gray";
                    $sinal = "x";
                  }

                  $metodo = $_meiosDePagamento[$lancamento->meio_pagamento];

                  $c.= '
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar bg-'.$tipo.' text-'.$tipo.'-fg"><h2 class="mb-1">'.$sinal.'</h2></span>
                      </div>
                      <div class="col">
                        ';
                        if($status=="concluido") {
                          $c.= '
                          <strong>'.$info.'</strong> - '.$metodo['nome'].'<br />
                          Valor: R$ '.formataMoedaBRL($lancamento->valor).'.<br />
                          '.($lancamento->status_motivo).'.<br />
                          <span class="small">Em '.($lancamento->updateAt).'</span>
                          ';
                        } else if($status=="cancelado") {
                          $c.= '<div class="alert alert-gray p-1">
                          <strong>'.$info.'</strong> - '.$metodo['nome'].'<br />
                          Motivo: '.($lancamento->status_motivo).'.<br />
                          <span class="small">Em '.($lancamento->updateAt).'</span>
                          </div>';
                        } else {
                          $c.= '<div class="alert alert-warning p-1">
                          <strong>'.$info.'</strong> - '.$metodo['nome'].'<br />
                          Aviso: essa transação ainda não foi paga e o seu valor não foi computado no saldo. Aguarde o processamento antes de liberar o cliente/produto.<br />
                          <span class="small">Desde '.($lancamento->createdAt).'</span>
                          </div>';
                        }
                        $c.= '
                      </div>
                    </div>
                  </div>
                  ';
                }

              $c.= '</div>';
            } else {
              $c.= '
                <div class="alert">
                  <p>Não há nenhum pagamento feito.</p>
                </div>
              ';
            }
            $c.= '


          </div>

          <div id="perguntasFrequentes">
            <h2 class="fw-light py-2">Perguntas Frequentes</h2>
            <div class="accordion" id="accordion-example">
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
                <div id="collapse-qa'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
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

        </div>
        
      </div>
    </div>


  </div>
</div>










<div class="offcanvas offcanvas-end" tabindex="-1" id="meiosDePagamento" aria-labelledby="meiosDePagamentoLabel">
<div class="offcanvas-header">
  <h2 class="offcanvas-title" id="meiosDePagamentoLabel">Meios de Pagamento Aceitos</h2>
  <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
  <div>
    <p>Esses são, atualmente, os meios de pagamento aceitos para esse PIX:</p>
    <div class="divide-y">
        ';
          foreach($_meiosDePagamento as $item) {
            $c.= '
            <div>
              <div class="row">
                <div class="col-2">
                  <img src="'.$item['logo'].'" class="img-fluid" alt="'.$item['nome'].'">
                </div>
                <div class="col-10">
                  <div class="text-truncate">
                    <strong>'.$item['nome'].'</strong>
                  </div>
                  <div class="text-muted small">
                    '.$item['descricao'].'
                    ';
                    if($item['pagamento']['ativo']==false){
                      $c.= '<br /><span class="text-red">Temporariamente indisponível.</span>';
                    }
                    $c.= '
                  </div>
                </div>
              </div>
            </div>';
          }
        $c.= '
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
      Fechar
    </button>
  </div>
</div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="garantias" aria-labelledby="garantiasLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="garantiasLabel">Garantia do Pagamento</h2>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      <!-- falar sobre a garantia do pagamento -->
      <p>Todas as nossas transações são garantidas e o pagamento, quando devidamente realizado, é transferido para a conta do vendedor (dono da chave PIX).</p>
      <p>Os pagamentos são processados em até 24 horas úteis (geralmente são instantâneos).</p>
      <p>Se o pagamento não for confirmado, o dinheiro será devolvido para o comprador.</p>
      <p>Se o pagamento for confirmado, o dinheiro será transferido para a conta do vendedor.</p>
      <p>Se o pagamento for cancelado, o dinheiro será devolvido para o comprador.</p>
      <p>Se o pagamento for disputado, o dinheiro será devolvido para o ganhador.</p>
      <p>Se o pagamento for estornado, o dinheiro será devolvido para o comprador.</p>
      <p>Se o pagamento for reembolsado, o dinheiro será devolvido para o comprador.</p>
      <p>Todas as transações são passadas por sistemas de anti-fraude e são registradas nos órgãos competentes para o combate à evasão de divisas e lavagem de dinheiro.</p>

    </div>
    <div class="mt-3">
      <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
        Fechar
      </button>
    </div>
  </div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="denunciarDiv" aria-labelledby="denunciarDivLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="denunciarDivLabel">Denunciar</h2>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      Para fazer a denúncia, envie um e-mail para <a href="mailto:'.$_dadosContato['email'].'" class="text-decoration-none">'.$_dadosContato['email'].'</a> com o assunto <strong>Denúncia PIX</strong> e informe a URL que deseja denunciar.
    </div>
    <div class="mt-3">
      <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
        Fechar
      </button>
    </div>
  </div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="qrcode" aria-labelledby="qrcodeLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="qrcodeLabel">QRCODE</h2>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
    
      <div class="alert alert-info mb-4" role="alert">
        <h4 class="alert-title">Nota:</h4>
        <div class="text-muted">Esse é o QrCode para <ins>compartilhamento</ins> desse UsePix. Para gerar o QrCode de pagamento abra o link e clique no botão <strong>Pagar</strong>.</div>
      </div>

      <div class="text-center">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$_urlCompleta.'" class="img-fluid" alt="QrCode">
        <p class="pt-2 text-muted small">'.$_urlCompleta.'</p>
      </div>

    </div>
    <div class="mt-3">
      <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
        Fechar
      </button>
    </div>
  </div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="compartilhar" aria-labelledby="compartilharLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="compartilharLabel">Compartilhar</h2>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>

      <div class="d-flex flex-column">
        
        <div>
          <a href="https://www.facebook.com/sharer/sharer.php?u='.$_urlCompleta.'" class="btn btn-facebook my-2">
            <!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path></svg>
            Facebook
          </a>
        </div>
        
        <div>
          <a href="https://api.whatsapp.com/send?text='.urlencode("Acesse sua fatura PIX e pague-a com várias formas diferentes (PIX, cartão, etc): ").$_urlCompleta.'" class="btn btn-green my-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
              <path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />
            </svg>
            WhatsApp
          </a>
        </div>
        
        <div>
          <button class="btn btn-outline-primary my-2 copy-ref" data-clipboard-target="#fooclipboard">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <rect x="8" y="8" width="12" height="12" rx="2" />
              <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
            </svg>
            Copiar link
          </button>
          <input type="text" id="fooclipboard" value="'.$_urlCompleta.'" class="d-none">
        </div>

      </div>

    </div>
    <div class="mt-3">
      <button class="btn btn-outline-secondary float-end" type="button" data-bs-dismiss="offcanvas">
        Fechar
      </button>
    </div>
  </div>
</div>

';


if($autorizaPagamento==true) {

  $c.= '
  <div class="offcanvas offcanvas-end" tabindex="-1" id="pagarDiv" aria-labelledby="pagarDivLabel">
    <div class="offcanvas-header">
      <h2 class="offcanvas-title" id="pagarDivLabel">Pagar</h2>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    
      <div>

        

        <!-- inicio fluxo load -->
        <div id="fluxoLoadding" class="fluxoPay">
          <div class="progress mb-3">
            <div class="progress-bar progress-bar-indeterminate"></div>
          </div>
        </div>
        <!-- fim fluxo load -->
        
        <div id="cronometro" class="fluxoPay mb-2">
          <div class="border d-block p-2 bg-white">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="spinner-border"></div>
              </div>
              <div class="col">
                Conclua esse pagamento em até <span id="cronometroFalta"></span>
              </div>
            </div>
          </div>
        </div>


        <!-- inicio fluxo 1 -->
        <div id="fluxo1" class="fluxoPay">
          
          <div class="mb-3">
            <div class="form-floating mb-3">
              <input type="tel" class="form-control moneyMask" id="floating-input" value="'.$chave->valor_diferenca.'" max="'.$chave->valor_diferenca.'" min="1" autocomplete="off">
              <label for="floating-input">Valor a Pagar</label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Escolha o método</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
            ';
            
            $i = 1;
            $primeiroMetodo = "";
            foreach($_meiosDePagamento as $item) {
              if($item['pagamento']['ativo']==true && $item['pagamento']['destaque']==true){
                $c.= '
                <label class="form-selectgroup-item flex-fill" title="'.$item['pagamento']['textoSelect'].'">
                  <input type="radio" name="form-payment" value="'.$item['modulo'].'" class="form-selectgroup-input pgtotp1"';
                  if($i==1) {
                    $primeiroMetodo = $item['modulo'];
                    $c.= ' checked="true"';
                  }
                  $c.= '>
                  <div class="form-selectgroup-label d-flex align-items-center p-3">
                    <div class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </div>
                    <div>
                      <span class="payment payment-provider-mercadopago payment-xs me-2 text-center"><img src="'.$item['logo'].'" class="m-1" alt="'.$item['nome'].'" ></span>
                      '.$item['pagamento']['textoBotao'].'
                    </div>
                  </div>
                </label>';
                $i++;
              }
            }

            $itensOutrasOpcoes = "";
            foreach($_meiosDePagamento as $item) {
              if($item['pagamento']['ativo']==true && $item['pagamento']['destaque']==false){
                $itensOutrasOpcoes.= '<option value="'.$item['modulo'].'">'.$item['pagamento']['textoSelect'].'</option>';
              }
            }

            if($itensOutrasOpcoes!="") {
              $c.= '
              <div class="mb-3">
                <div class="form-floating">
                  <select class="form-select pgtotp2" id="floatingSelect" aria-label="Floating label select example">
                    <option value="x">Outro...</option>
                    '
                    .$itensOutrasOpcoes
                    .'
                  </select>
                  <label for="floatingSelect">Selecione outro método:</label>
                </div>
              </div>
              ';
            }

            $c.= '
            
            </div>
          </div>

          <input type="hidden" id="metodoPagamento" name="metodoPagamento" value="'.$primeiroMetodo.'">

          <div class="mt-1">
            <button class="btn btn-primary btnPayf" type="button">
              Continuar
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right ms-1 me-0" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="5" y1="12" x2="19" y2="12" />
                <line x1="13" y1="18" x2="19" y2="12" />
                <line x1="13" y1="6" x2="19" y2="12" />
              </svg>
            </button>
          </div>
        </div>
        <!-- fim fluxo 1 -->


        
        <!-- inicio fluxo 2 -->
        <div id="fluxo2" class="fluxoPay">
            fl2
        </div>
        <!-- fim fluxo 2 -->



      </div>



    </div>
  </div>

	<script type="text/template" id="countdown-tpl">
		<%= m %> minutos e <%= s %> segundos
	</script>

  <script>

  function cronometroStart(minutos, segundos, doneFunction) {
    var options = {
      autostart: true,
      m: minutos,
      s: segundos,
      done: doneFunction,
      tpl: function(el,opts) {
        // use underscore to generate the markup to be displayed from the countdown-tpl template
        var template = _.template(
          $("#countdown-tpl").html()
        );
        $(el).html(template(opts));
      }
    }
    // instantiate the countdown
    $("#cronometroFalta").countdown(options);
    
    $("#cronometro").show();

  }

  function payfLoad() {
    $(".fluxoPay").hide();
    $("#fluxoLoadding").show();
  }

  function payfInit() {
    $(".fluxoPay").hide();
    $(".pgtotp1").first().prop("checked", true).focus();
    $(".pgtotp2").val("x");
    $("#metodoPagamento").val($(".pgtotp1:checked").first().val());
    $("#floating-input").val("'.$chave->valor_diferenca.'");
    $("#fluxo1").show();
  }

  function payfEscolha() {
    $(".fluxoPay").hide();
    $("#fluxo2").show();
  }

  function payfConsultaPgto(cod) {
    console.log("payfConsultaPgto cod: ", cod);
    
    setInterval(function() {
      $.getJSON("'.$base_url.'/api/payfpgto?cod="+cod, function(resultado){
        console.log("resultado", resultado);
        if(resultado.msg == "NO") {
          
        } else {
          window.location.reload();
        }
      });
    }, 2000);

  }

  // jquery function load page
  $(document).ready(function(){
    // if . pgtotp1 is checked
    $(".pgtotp1").click(function(){
      // get the value of the checked option and set to #metodoPagamento
      $("#metodoPagamento").val($(".pgtotp1:checked").val());
      // if . pgtotp1 is checked
      if($(".pgtotp1").is(":checked")){
        // unselect options in .pgtotp2
        $(".pgtotp2").val("x");
      }
    });
    // if . pgtotp2 is changed
    $(".pgtotp2").change(function(){
      // if . pgtotp2 is not equal to x
      if($(".pgtotp2").val() != "x"){
        // unselect options in .pgtotp1
        $(".pgtotp1").prop("checked", false);
        // get the value of the checked option and set to #metodoPagamento
        $("#metodoPagamento").val($(".pgtotp2").val());
      } else {
        // set .pgtotp1 to checked in first element
        $(".pgtotp1").first().prop("checked", true).focus();
        $("#metodoPagamento").val($(".pgtotp1:checked").first().val());
      }
    });

    payfInit();

    $(".btnPayf").click(function(){
      payfLoad();
      var data = {
        "metodoPagamento": $("#metodoPagamento").val(),
        "valorPagamento": $("#floating-input").val(),
        "chave": "'.$chave->chave.'",
        "valor": "'.$chave->chave_valor.'",
        "referencia": "'.$chave->chave_identificador.'",
        "url": "'.$_urlCompleta.'"
      };
      $.ajax({
        url: "'.$base_url.'/api/payf",
        type: "POST",
        data: data,
        success: function(data){
          payfEscolha();
          $("#fluxo2").html(data);
        }
      });
    });

    $("#botaoPagar").click(function(){
      payfInit();
    });

  });
  </script>

  <script src="https://sdk.mercadopago.com/js/v2"></script>
  ';

}

$c.= '
</div>
';

//$c.= "<hr>exibir a tela de dados para a chave: <pre>".print_r($chave, 1)."</pre>";