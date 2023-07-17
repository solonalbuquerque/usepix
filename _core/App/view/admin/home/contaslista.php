<?php

$tema = "admin";
$titulo = "Contas";

$showBusca = true;
$linkAtual = "contas";

$qtdPorPagina = 50;

$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

$banco->pageLimit = $qtdPorPagina;

$q = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
if($q=="") $q = (isset($_POST['q']) && $_POST['q'] != '') ? $_POST['q'] : '';
if($q!="") {
    $banco->where ("(conta  LIKE ? OR responsavel_nome LIKE ? OR responsavel_doc LIKE ? OR responsavel_email LIKE ? OR responsavel_telefone LIKE ?)", Array("%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%"));
}

$banco->orderBy("id", "DESC");

$listaItens = $banco->paginate("financeiro_contas", $page);
                  
$paginacao = new Paginator($banco->pageLimit,"q=$q&page");
$paginacao->set_total($banco->totalCount);
$paginacao->set_page($page);



$c = '
<div class="card">

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
      <thead>
        <tr>
          <th class="w-1">CONTA</th>
          <th>Identificador</th>
          <th>Nome</th>
          <th>Documento</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Saldo</th>
          <th>Recebidos</th>
          <th>Saídas</th>
          <th>Temporário</th>
          <th>SaqueAuto</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach($listaItens as $item) {
        $item = (object) $item;
        $c.= '<tr>
          <td><a href="contas/'.$item->id.'">'.$item->id.'</a></td>
          <td>'.$item->conta .'</td>
          <td>'.$item->responsavel_nome .'</td>
          <td class="text-truncate">'.$item->responsavel_doc .'</td>
          <td class="text-truncate">'.$item->responsavel_email .'</td>
          <td>'.$item->responsavel_telefone .'</td>
          <td>'.$item->saldo .'</td>
          <td>'.$item->recebidos .'</td>
          <td>'.$item->saidas .'</td>
          <td>'.$item->temporario .'</td>
          <td>'.
          ($item->saque_automatico == 's' ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>')
          .'</td>
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
        .$paginacao->page_links("contas/?")
        .'
      </ul>
    </div>
    
</div>
';