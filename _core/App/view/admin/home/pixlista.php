<?php

$tema = "admin";
$titulo = "Pix";

$showBusca = true;
$linkAtual = "pix";

$qtdPorPagina = 50;

$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

$banco->pageLimit = $qtdPorPagina;

$q = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
if($q=="") $q = (isset($_POST['q']) && $_POST['q'] != '') ? $_POST['q'] : '';
if($q!="") {
    $banco->where ("(chave  LIKE ? OR chave_tipo LIKE ? OR chave_identificador LIKE ? OR descricao LIKE ? OR status LIKE ?)", Array("%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%"));
}

$banco->orderBy("id", "DESC");

$listaItens = $banco->paginate("chaves", $page);
                  
$paginacao = new Paginator($banco->pageLimit,"q=$q&page");
$paginacao->set_total($banco->totalCount);
$paginacao->set_page($page);



$c = '
<div class="card">

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
      <thead>
        <tr>
          <th class="w-1">PIX</th>
          <th>Chave</th>
          <th>Valor</th>
          <th>Identificador</th>
          <th>Pagamentos</th>
          <th>A Repassar</th>
          <th>Status</th>
          <th class="w-1">View</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach($listaItens as $item) {
        $item = (object) $item;
        $c.= '<tr>
          <td><a href="pix/'.$item->id.'">'.$item->id.'</a></td>
          <td>'.$item->chave .'<br />'.$item->chave_tipo .'</td>
          <td>'.$item->chave_valor .'</td>
          <td class="text-truncate">'.$item->chave_identificador .'</td>
          <td>('.$item->qtd_pagamentos .') '.$item->valor_recebido .'</td>
          <td>'.$item->valor_arepassar .'</td>
          <td>'.$item->status .'</td>
          <td>'.$item->views .'</td>
        </tr>';
      }
      $c.= '
      </tbody>
    </table>
  </div>


    <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-muted">Exibindo <span>'.count($listaItens).'</span> de <span>'.$banco->totalCount.'</span> entries</p>
      <ul class="pagination m-0 ms-auto">
        '
        .$paginacao->page_links("pix/?")
        .'
      </ul>
    </div>
    
</div>
';