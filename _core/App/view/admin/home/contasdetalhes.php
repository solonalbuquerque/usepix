<?php

$tema = "admin";
$titulo = "Contas";

$showBusca = false;

$linkVoltar = "./contas/";

$codigoTransacao = $vars['urldata'][2];

$item = (object) $banco->where('id', $codigoTransacao)->getOne('financeiro_contas');

if(!$item) {
  header("Location: ./contas/");exit;
}

$titulo = "Conta #{$codigoTransacao} - {$item->conta}";

$infoBasic = [];
$infoBasic['Conta'] = $item->id;
$infoBasic['Identificador'] = $item->conta;
$infoBasic['Criado em'] = $item->createdAt;
$infoBasic['Atualizado em'] = $item->updateAt;


$infoFinan = [];
$infoFinan['Saldo'] = $item->saldo;
$infoFinan['------'] = "-------";
$infoFinan['Recebidos'] = $item->recebidos;
$infoFinan['Saídas'] = $item->saidas;
$infoFinan['Temporário'] = $item->temporario;



$infoFinanConta = [];

$infoFinanConta[] = [
  "titulo" => "Documento",
  "campo" => "responsavel_doc",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->responsavel_doc,
  "permiteEditar" => true
];
$infoFinanConta[] = [
  "titulo" => "Nome",
  "campo" => "responsavel_nome",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->responsavel_nome,
  "permiteEditar" => true
];
$infoFinanConta[] = [
  "titulo" => "E-mail",
  "campo" => "responsavel_email",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->responsavel_email,
  "permiteEditar" => true
];
$infoFinanConta[] = [
  "titulo" => "Telefone",
  "campo" => "responsavel_telefone",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->responsavel_telefone,
  "permiteEditar" => true
];



$infoSaque = [];
$infoSaque[] = [
  "titulo" => "Valor mínimo",
  "campo" => "saque_minimo",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_minimo,
  "permiteEditar" => true
];
$infoSaque[] = [
  "titulo" => "Taxa percentual",
  "campo" => "saque_taxa_percentual",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_taxa_percentual,
  "permiteEditar" => true
];
$infoSaque[] = [
  "titulo" => "Taxa fixa",
  "campo" => "saque_taxa_fixa",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_taxa_fixa,
  "permiteEditar" => true
];



$infoAutoSaque = [];
$infoAutoSaque[] = [
  "titulo" => "Saque automático (s/n)",
  "campo" => "saque_automatico",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_automatico,
  "permiteEditar" => true
];
$infoAutoSaque[] = [
  "titulo" => "Saldo mínimo",
  "campo" => "saque_automatico_minimo",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_automatico_minimo,
  "permiteEditar" => true
];
$infoAutoSaque[] = [
  "titulo" => "Taxa percentual",
  "campo" => "saque_automatico_taxa_percentual",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_automatico_taxa_percentual,
  "permiteEditar" => true
];
$infoAutoSaque[] = [
  "titulo" => "Taxa fixa",
  "campo" => "saque_automatico_taxa_fixa",
  "tabela" => "financeiro_contas",
  "id" => $item->id,
  "valor" => $item->saque_automatico_taxa_fixa,
  "permiteEditar" => true
];



$c = '
<div class="row g-3">
  <div class="col">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Lançamentos Financeiros</div>
            ';
            $lancamentos = $banco->where('conta_id', $item->id)->orderBy("id", "desc")->get('financeiro');
            if(count($lancamentos) == 0) {
              $c.= '<div class="alert alert-info">Nenhum lançamento encontrado.</div>';
            } else {
              $c.= '
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                  <thead>
                    <tr>
                      <th class="w-1">#</th>
                      <th>Data</th>
                      <th>Tipo</th>
                      <th>Valor</th>
                      <th>Descrição</th>
                    </tr>
                  </thead>
                  <tbody>';
                  foreach($lancamentos as $lancamento) {
                    $lancamento = (object) $lancamento;
                    $c.= '<tr>
                      <td>'.$lancamento->id .'</td>
                      <td>'.$lancamento->createdAt .'</td>
                      <td>'.$lancamento->tipo .'</td>
                      <td>'.$lancamento->valor .'</td>
                      <td>'.$lancamento->descricao .'</td>
                    </tr>';
                  }
                  $c.= '
                  </tbody>
                </table>
              </div>';
            }
            $c.='
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
            <div class="card-title">Saque Automático</div>
            ';
            foreach($infoAutoSaque as $v) {
              if($v['permiteEditar']==true) {
                $c.= '
                <div class="mb-2 podeAlterar" '.dataItemArray($v). '>
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              } else {
                $c.= '
                <div class="mb-2">
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              }
            }
            $c.='
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Saque Normal</div>
            ';
            foreach($infoSaque as $v) {
              if($v['permiteEditar']==true) {
                $c.= '
                <div class="mb-2 podeAlterar" '.dataItemArray($v). '>
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              } else {
                $c.= '
                <div class="mb-2">
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              }
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
            <div class="card-title">Conta Financeira</div>
            ';
            foreach($infoFinanConta as $v) {
              if($v['permiteEditar']==true) {
                $c.= '
                <div class="mb-2 podeAlterar" '.dataItemArray($v). '>
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              } else {
                $c.= '
                <div class="mb-2">
                  <span>'.$v['titulo'].'</span>: <strong>'.$v['valor'].'</strong>
                </div>';
              }
            }
            $c.='
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
            <div class="card-title">Ações</div>
              
              <button type="button" data-bs-toggle="modal" data-bs-target="#modal-solicitasaque" class="btn btn-primary">Solicitar Saque</button>

          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>





<div class="modal modal-blur fade" id="modal-solicitasaque" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Solicitar Saque</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3 align-items-end">
          <div class="col">
            <label class="form-label" id="">Valor a sacar: (máximo de '.$item->saldo.')</label>
            <input type="number" class="form-control" name="novovalor" id="solicitasaqueValor" value="'.$item->saldo.'" min="0" max="'.$item->saldo.'" step="0.01" />
          </div>
        </div>
        <div>
          <label class="form-label">Justificativa:</label>
          <textarea class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="solicitasaqueEnviar">Solicitar</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){

  $("#solicitasaqueEnviar").click(function(){
    var valor = $("#solicitasaqueValor").val();
    $.ajax({
      type: "POST",
      url: "ajaxDbSolicitaSaque",
      data: "conta='.$item->id.'&valor="+valor+"&justificativa="+$(".modal-body textarea").val(),
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