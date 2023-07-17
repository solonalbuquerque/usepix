<?php

$tema = "admin";
$titulo = "Pix";

$showBusca = false;

$linkVoltar = "./pix/";

$codigoTransacao = $vars['urldata'][2];

$item = (object) $banco->where('id', $codigoTransacao)->getOne('chaves');

if(!$item) {
  header("Location: ./pix/");exit;
}

$titulo = "Pix #{$codigoTransacao}  - {$item->chave_tipo} {$item->chave}";

$infoBasic = [];
$infoBasic['Pix'] = $item->id;
$infoBasic['Chave'] = '<a href="chaves/'.$item->chavepix_id.'">'.$item->chave.'</a>';
$infoBasic['Chave Tipo'] = $item->chave_tipo;
$infoBasic['Valor'] = $item->chave_valor;
$infoBasic['Identificador'] = $item->chave_identificador;
$infoBasic['Link'] = "{$item->chave}/{$item->chave_valor}/{$item->chave_identificador}";
$infoBasic['Link'] = '<a href="../../../../'.$infoBasic['Link'].'" target="_blank">'.$infoBasic['Link'].'</a>';
$infoBasic['Criado em'] = $item->createdAt;
$infoBasic['Atualizado em'] = $item->updateAt;
$infoBasic['Status'] = $item->status;
$infoBasic['Views'] = $item->views;


$infoFinan = [];
$infoFinan['Valor Total'] = $item->chave_valor;
$infoFinan['Valor Pago'] = $item->valor_recebido;
$infoFinan['Valor Restante'] = ($infoFinan['Valor Total'] - $infoFinan['Valor Pago']);
$infoFinan['------'] = "-------";
$infoFinan['Recebido'] = $item->valor_recebido;
$infoFinan['Repassado'] = $item->valor_repassado;
$infoFinan['A Repassar'] = $item->valor_arepassar;



$pixDescricao = [
  "titulo" => "Descrição",
  "tabela" => "chaves",
  "id" => $item->id,
  "valor" => $item->descricao,
  "campo" => "descricao",
  "permiteEditar" => true
];

$c = '
<div class="row g-3">
  <div class="col">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Pagamentos e tentativas</div>
              <div class="divide-y">
              ';
              $lancamentos = $banco->where('chave_id', $item->id)->get('lancamentos');
              if(count($lancamentos)== 0) {
                $c.= '<div class="alert alert-warning">Nenhum pagamento ou tentativa de pagamento foi registrado.</div>';
              } else {
                foreach($lancamentos as $lancamento) {

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
                        Lançamento: <strong><a href="./lancamentos/'.$lancamento->id.'">#'.$lancamento->id.'</a></strong><br />
                        Valor: '.$lancamento->valor.'<br />
                        Taxas: '.$lancamento->valor_taxas.'<br />
                        Total: '.$lancamento->valor_total.'<br />
                        -------<br />
                        Recebido: '.$lancamento->valor_recebido.'<br />

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
                  </div>';
                }
              }
              $c.='
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
              data-tabela="chaves"
              data-campo="status"
            >
            ';
            global $_statusChaves;
            foreach($_statusChaves as $k=>$v) {
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

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">Descrição</h2>
            <div>
              <div class="podeAlterar" '.dataItemArray($pixDescricao). '>
              <span>Descrição:</span> '
              .($item->descricao ? $item->descricao : 'Nenhuma descrição informada.')
            .'</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

';