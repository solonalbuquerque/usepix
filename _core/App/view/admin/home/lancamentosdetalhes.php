<?php

$tema = "admin";
$titulo = "Lançamentos";

$showBusca = false;

$linkVoltar = "./lancamentos/";

$codigoTransacao = $vars['urldata'][2];

$item = (object) $banco->where('id', $codigoTransacao)->getOne('lancamentos');

if(!$item) {
  header("Location: ./lancamentos/");exit;
}

$titulo = "Lançamento #{$codigoTransacao}";

$infoBasic = [];
$infoBasic['Lançamento'] = $item->id;
$infoBasic['Chave'] = '<a href="chaves/'.$item->chave_id.'">'.getChave($item->chave_id, "chave").'</a>';
$infoBasic['ChavePIX'] = '<a href="chavespix/'.$item->chavepix_id.'">'.getChavepix($item->chavepix_id, "chave").'</a>';
$infoBasic['Criado em'] = $item->createdAt;
$infoBasic['Atualizado em'] = $item->updateAt;
$infoBasic['Status'] = $item->status;
$infoBasic['Status Motivo'] = $item->status_motivo;


$infoFinan = [];
$infoFinan['Tipo'] = ($item->tipo=="c") ? "Crédito" : "Débito";
$infoFinan['Valor'] = $item->valor;
$infoFinan['Taxas'] = $item->valor_taxas;
$infoFinan['Total'] = $item->valor_total;
$infoFinan['------'] = "-------";
$infoFinan['Recebido'] = $item->valor_recebido;


$infoPag = [];
$infoPag['Módulo'] = $item->modulo_pagamento;
$infoPag['Meio'] = $item->meio_pagamento;
$infoPag['Código'] = $item->meio_pagamento_id;
$infoPag['Status'] = $item->status_pagamento;
$infoPag['Status Chave'] = $item->status_pagamento_chave;

$c = '
<div class="row g-3">
  <div class="col">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Resposta na Criação</div>
            <div class="mb-2">
              <pre>'.print_r(json_decode($item->resposta_criacao), true).'</pre>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Resposta do Pagamento</div>
            <div class="mb-2">
              <pre>'.print_r(json_decode($item->resposta_pagamento), true).'</pre>
            </div>
          </div>
        </div>
      </div>

      
    </div>
  </div>
  <div class="col-lg-3">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Resumo Financeiro</div>
            ';
            foreach($infoFinan as $k=>$v) {
              $c.= '
              <div class="mb-2">
                '.$k.': <strong>'.$v.'</strong>
              </div>';
            }
            $c.='
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Informações de Pagamento</div>
            ';
            foreach($infoPag as $k=>$v) {
              $c.= '
              <div class="mb-2">
                '.$k.': <strong>'.$v.'</strong>
              </div>';
            }
            $c.='
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="col-lg-4">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
          <div class="card-title">Status Atual</div>
            <select class="form-select atualizastatus"
              data-id="'.$item->id.'"
              data-tabela="lancamentos"
              data-campo="status"
            >
            ';
            global $_statusLancamentos;
            foreach($_statusLancamentos as $k=>$v) {
              $c.= '<option value="'.$k.'"'.
              ($item->status == $k ? ' selected' : '')
              .'>'.$v.'</option>';
            }
            $c.='
            </select>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
          <div class="card-title">Informações Básicas</div>
            ';
            foreach($infoBasic as $k=>$v) {
              $c.= '
              <div class="mb-2">
                '.$k.': <strong>'.$v.'</strong>
              </div>';
            }
            $c.='
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

';