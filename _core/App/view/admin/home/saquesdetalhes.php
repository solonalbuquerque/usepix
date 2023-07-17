<?php

$tema = "admin";
$titulo = "Saques";

$showBusca = false;

$linkVoltar = "./saques/";

$codigoTransacao = $vars['urldata'][2];

$item = (object) $banco->where('id', $codigoTransacao)->getOne('solicitacoes_saque');

if(!$item) {
  header("Location: ./saques/");exit;
}

$titulo = "Saque #{$codigoTransacao}";

$infoBasic = [];
$infoBasic['Solicitação'] = $item->id;
$infoBasic['Conta'] = '<a href="contas/'.$item->conta_id.'">'.getConta($item->conta_id, 'conta').'</a>';
$infoBasic['Chave Destino'] = getConta($item->para_chavepix_id, 'conta');
$infoBasic['Criado em'] = $item->createdAt;
$infoBasic['Status'] = $item->status;
$infoBasic['Status Motivo'] = $item->status_motivo;


$infoFinan = [];
$infoFinan['Valor'] = $item->valor;
$infoFinan['Taxas'] = $item->valor_taxas;
$infoFinan['------'] = "-------";
$infoFinan['Valor Final'] = $item->valor_final;


$infoTransf = [];
$infoTransf['Valor'] = $item->valor_final;
$infoTransf['Método'] = "PIX";
$infoTransf['Chave'] = getConta($item->para_chavepix_id, 'conta');
if($item->status == "na fila" || $item->status == "pendente") {
  $infoTransf[''] = '<button type="button" data-bs-toggle="modal" data-bs-target="#modal-marasaqueconcluido" class="btn btn-primary">Processar Saque</button>';
}



$pixDescricao = [
  "titulo" => "Detalhes",
  "tabela" => "detalhes",
  "id" => $item->id,
  "valor" => $item->detalhes,
  "campo" => "detalhes",
  "permiteEditar" => true
];

$pixInfoPag = [
  "titulo" => "Informações de Pagamento",
  "tabela" => "informacoesPagamento",
  "id" => $item->id,
  "valor" => $item->detalhes,
  "campo" => "informacoesPagamento",
  "permiteEditar" => true
];

$c = '
<div class="row g-3">
  <div class="col">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">Detalhes</h2>
            <div>
              <div class="podeAlterar" '.dataItemArray($pixDescricao). '>
              <span>Descrição:</span> '
              .($item->detalhes ? $item->detalhes : 'Nenhum detalhe informado.')
            .'</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">Informações de Pagamento</h2>
            <div>
              <div>'
              .($item->informacoesPagamento ? '<pre style="white-space: pre-wrap;">'.$item->informacoesPagamento.'</pre>' : 'Nenhuma informação.')
            .'</div>
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
            <div class="card-title">Informações para Transferência</div>
            ';
            foreach($infoTransf as $k=>$v) {
              $c.= '
              <div class="mb-2">
                '.
                ($k!="" ? $k.":" : '')
                .' <strong>'.$v.'</strong>
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
              data-tabela="solicitacoes_saque"
              data-campo="status"
            >
            ';
            global $_statusSolicitacoesSaque;
            foreach($_statusSolicitacoesSaque as $k=>$v) {
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






<div class="modal modal-blur fade" id="modal-marasaqueconcluido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Marcar como Saque Concluído</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3 align-items-end">
          <div class="col">
            <label class="form-label" id="">Valor a transferir:</label>
            <input type="number" class="form-control" name="novovalor" id="solicitasaqueProcessaValor" value="'.$item->valor_final.'" min="0" max="'.$item->valor_final.'" step="0.01" disabled />
          </div>
          <div class="col">
            <label class="form-label" id="">Método:</label>
            <input type="text" class="form-control" name="novovalor" id="solicitasaqueProcessaMetodo" value="PIX" />
          </div>
        </div>
        <div class="row mb-3 align-items-end">
          <div class="col">
            <label class="form-label" id="">Chave Destino:</label>
            <input type="text" class="form-control" name="novovalor" id="solicitasaqueProcessaDestino" value="'.getConta($item->para_chavepix_id, 'conta').'" />
          </div>
          <div class="col">
            <label class="form-label" id="">Banco Origem:</label>
            <input type="text" class="form-control" name="novovalor" id="solicitasaqueProcessaBancoOrigem" value="Inter" />
          </div>
        </div>
        <div>
          <label class="form-label">Informações do comprovante:</label>
          <textarea class="form-control" rows="5" id="solicitasaqueProcessaComprovante">'."\n\n---\nValor solicitado: R$ ".formataMoedaBRL($item->valor)."\nTaxas: R$ ".formataMoedaBRL($item->valor_taxas)."\nValor final a depositar: R$ ".formataMoedaBRL($item->valor_final).'</textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="solicitasaqueProcessar">Concluir</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){

  $("#solicitasaqueProcessar").click(function(){
    $.ajax({
      type: "POST",
      url: "ajaxDbProcessaSaque",
      data: "solicitacaoId='.$item->id.'&metodo="+$("#solicitasaqueProcessaMetodo").val()+"&banco="+$("#solicitasaqueProcessaBancoOrigem").val()+"&chave="+$("#solicitasaqueProcessaDestino").val()+"&justificativa="+$("#solicitasaqueProcessaComprovante").val(),
      success: function(data) {
        data = JSON.parse(data);
        if(data.status == "ok"){
          Swal.fire({
            title: "Sucesso!",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Ok"
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


';