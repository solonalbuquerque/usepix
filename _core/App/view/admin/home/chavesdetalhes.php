<?php

$tema = "admin";
$titulo = "Chaves";

$showBusca = false;

$linkVoltar = "./chaves/";

$codigoTransacao = $vars['urldata'][2];

$item = (object) $banco->where('id', $codigoTransacao)->getOne('chavespix');

if(!$item) {
  header("Location: ./chaves/");exit;
}

$titulo = "Chave #{$codigoTransacao}  - {$item->chave_tipo} {$item->chave}";

$infoBasic = [];
$infoBasic['Código'] = $item->id;
$infoBasic['Chave'] = $item->chave;
$infoBasic['Chave Tipo'] = $item->chave_tipo;
$infoBasic['Criado em'] = $item->createdAt;
$infoBasic['Atualizado em'] = $item->updateAt;
$infoBasic['Verificação'] = $item->verificado_at;
$infoBasic['Status'] = $item->status;


$infoDono = [];
$infoDono[] = [
  "titulo" => "Nome",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->dono_nome,
  "campo" => "dono_nome",
  "permiteEditar" => true
];
$infoDono[] = [
  "titulo" => "E-mail",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->dono_email,
  "campo" => "dono_email",
  "permiteEditar" => true
];
$infoDono[] = [
  "titulo" => "Telefone",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->dono_telefone,
  "campo" => "dono_telefone",
  "permiteEditar" => true
];
$infoDono[] = [
  "titulo" => "Documento",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->dono_documento,
  "campo" => "dono_documento",
  "permiteEditar" => true
];


$infoFinan = [];
$infoFinan['Saldo'] = $item->saldo;
$infoFinan['------'] = "-------";
$infoFinan['Gerado'] = $item->total_gerado;
$infoFinan['Arrecadado'] = $item->total_arrecadado;
$infoFinan['Repassado'] = $item->total_repassado;
$infoFinan['Pendente'] = $item->total_pendente;


$infoLimites = [];
$infoLimites[] = [
  "titulo" => "Valor de cobrança mínimo",
  "campo" => "valor_cobranca_minimo",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->valor_cobranca_minimo,
  "permiteEditar" => true
];
$infoLimites[] = [
  "titulo" => "Valor de cobrança máximo",
  "campo" => "valor_cobranca_maximo",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->valor_cobranca_maximo,
  "permiteEditar" => true
];
$infoLimites[] = [
  "titulo" => "Valor de transferência mínimo",
  "campo" => "valor_transferencia_minimo",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->valor_transferencia_minimo,
  "permiteEditar" => true
];
$infoLimites[] = [
  "titulo" => "Valor de transferência máximo",
  "campo" => "valor_transferencia_maximo",
  "tabela" => "chavespix",
  "id" => $item->id,
  "valor" => $item->valor_transferencia_maximo,
  "permiteEditar" => true
];


$infoFinanConta = [];
$dadosContaFinanceira = $banco->where("conta", $item->chave)->getOne("financeiro_contas");
if($dadosContaFinanceira) {
  
  $infoFinanConta[] = [
    "titulo" => "Conta Financeira",
    "campo" => "",
    "tabela" => "",
    "id" => $item->id,
    "valor" => "#".$dadosContaFinanceira['id'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "Conta",
    "valor" => "#".$dadosContaFinanceira['id'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "Saldo",
    "valor" => $dadosContaFinanceira['saldo'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "-------",
    "valor" => "-------",
    "permiteEditar" => false
  ];
  
  $infoFinanConta[] = [
    "titulo" => "Recebidos",
    "valor" => $dadosContaFinanceira['recebidos'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "Saídas",
    "valor" => $dadosContaFinanceira['saidas'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "Temporário",
    "valor" => $dadosContaFinanceira['temporario'],
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "-------",
    "valor" => "-------",
    "permiteEditar" => false
  ];

  $infoFinanConta[] = [
    "titulo" => "Documento",
    "campo" => "responsavel_doc",
    "tabela" => "financeiro_contas",
    "id" => $dadosContaFinanceira['id'],
    "valor" => $dadosContaFinanceira['responsavel_doc'],
    "permiteEditar" => true
  ];
  $infoFinanConta[] = [
    "titulo" => "Nome",
    "campo" => "responsavel_nome",
    "tabela" => "financeiro_contas",
    "id" => $dadosContaFinanceira['id'],
    "valor" => $dadosContaFinanceira['responsavel_nome'],
    "permiteEditar" => true
  ];
  $infoFinanConta[] = [
    "titulo" => "E-mail",
    "campo" => "responsavel_email",
    "tabela" => "financeiro_contas",
    "id" => $dadosContaFinanceira['id'],
    "valor" => $dadosContaFinanceira['responsavel_email'],
    "permiteEditar" => true
  ];
  $infoFinanConta[] = [
    "titulo" => "Telefone",
    "campo" => "responsavel_telefone",
    "tabela" => "financeiro_contas",
    "id" => $dadosContaFinanceira['id'],
    "valor" => $dadosContaFinanceira['responsavel_telefone'],
    "permiteEditar" => true
  ];
  
} else {
  
  $infoFinanConta[] = [
    "titulo" => "Conta Financeira",
    "campo" => "",
    "tabela" => "",
    "id" => "",
    "valor" => "Não encontrada",
    "permiteEditar" => false
  ];
  $infoFinanConta[] = [
    "titulo" => "Conta",
    "campo" => "",
    "tabela" => "",
    "id" => "",
    "valor" => $item->chave,
    "permiteEditar" => false
  ];
  
}

$c = '
<div class="row g-3">
  <div class="col">
    <div class="row row-cards">


      <div class="col-12">
        <div class="card">
          <div class="card-body">
          <div class="card-title">Informações do Dono</div>
          ';
          foreach($infoDono as $v) {
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
            <div class="card-title">Limites</div>
            ';
            foreach($infoLimites as $v) {
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
              data-tabela="chavespix"
              data-campo="status"
            >
            ';
            global $_statusChavesPix;
            foreach($_statusChavesPix as $k=>$v) {
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
            <div class="card-title">Cobranças geradas ('.$item->qtd_gerados.')</div>
              
              <a href="./pix/?q='.$item->chave.'" class="btn btn-primary">Ver cobranças</a>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

';