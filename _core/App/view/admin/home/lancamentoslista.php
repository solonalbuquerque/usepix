<?php

$tema = "admin";
$titulo = "Lançamentos";

$showBusca = true;
$linkAtual = "lancamentos";

$qtdPorPagina = 50;

$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

$banco->pageLimit = $qtdPorPagina;

$q = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
if($q=="") $q = (isset($_POST['q']) && $_POST['q'] != '') ? $_POST['q'] : '';
if($q!="") {
    $banco->where ("(valor  LIKE ? OR valor_total LIKE ? OR valor_recebido LIKE ? OR modulo_pagamento LIKE ? OR status LIKE ?)", Array("%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%"));
}

$banco->orderBy("id", "DESC");

$listaItens = $banco->paginate("lancamentos", $page);
                  
$paginacao = new Paginator($banco->pageLimit,"q=$q&page");
$paginacao->set_total($banco->totalCount);
$paginacao->set_page($page);



$c = '
<div class="card">

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
      <thead>
        <tr>
          <th class="w-1">LANÇAMENTO</th>
          <th>Chave</th>
          <th>ChavePix</th>
          <th>Valor</th>
          <th>Taxas</th>
          <th>Total</th>
          <th>Recebido</th>
          <th>Meio</th>
          <th>Status_Pag</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach($listaItens as $item) {
        $item = (object) $item;
        $c.= '<tr>
          <td><a href="lancamentos/'.$item->id.'">'.$item->id.'</a></td>
          <td>'.getChave($item->chave_id, "chave") .'<br />'.getChave($item->chave_id, "chave_tipo") .'</td>
          <td>'.getChavepix($item->chavepix_id, "chave") .'<br />'.getChavepix($item->chavepix_id, "chave_tipo") .'</td>
          <td>'.$item->valor .'</td>
          <td>'.$item->valor_taxas .'</td>
          <td>'.$item->valor_total .'</td>
          <td>'.$item->valor_recebido .'</td>
          <td>'.$item->modulo_pagamento .'<br />'.$item->meio_pagamento .'</td>
          <td>'.$item->status_pagamento .'</td>
          <td>'.$item->status .'</td>
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