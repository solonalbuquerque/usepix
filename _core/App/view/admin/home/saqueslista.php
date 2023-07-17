<?php

$tema = "admin";
$titulo = "Saques";

$showBusca = true;
$linkAtual = "saques";

$qtdPorPagina = 50;

$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

$banco->pageLimit = $qtdPorPagina;

$q = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
if($q=="") $q = (isset($_POST['q']) && $_POST['q'] != '') ? $_POST['q'] : '';
if($q!="") {
    $banco->where ("(conta_id  LIKE ? OR valor LIKE ? OR para_chavepix_id LIKE ? OR status LIKE ?)", Array("%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%"));
}

$banco->orderBy("id", "DESC");

$listaItens = $banco->paginate("solicitacoes_saque", $page);
                  
$paginacao = new Paginator($banco->pageLimit,"q=$q&page");
$paginacao->set_total($banco->totalCount);
$paginacao->set_page($page);



$c = '
<div class="card">

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
      <thead>
        <tr>
          <th class="w-1">SOLICITAÇÃO</th>
          <th>Conta</th>
          <th>Valor</th>
          <th>Para Chaveix</th>
          <th>Criado</th>
          <th>Resolvido</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach($listaItens as $item) {
        $item = (object) $item;
        $c.= '<tr>
          <td><a href="saques/'.$item->id.'">'.$item->id.'</a></td>
          <td>'.getConta($item->conta_id, 'conta').'</td>
          <td>'.$item->valor .'</td>
          <td>'.getConta($item->para_chavepix_id, 'conta').'</td>
          <td>'.$item->createdAt .'</td>
          <td>'.
          ($item->resolvidoAt !== null ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>')
          .'</td>
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