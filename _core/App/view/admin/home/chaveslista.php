<?php

$tema = "admin";
$titulo = "Chaves";

$showBusca = true;
$linkAtual = "chaves";

$qtdPorPagina = 50;

$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

$banco->pageLimit = $qtdPorPagina;

$q = (isset($_GET['q']) && $_GET['q'] != '') ? $_GET['q'] : '';
if($q=="") $q = (isset($_POST['q']) && $_POST['q'] != '') ? $_POST['q'] : '';
if($q!="") {
    $banco->where ("(chave  LIKE ? OR chave_tipo LIKE ? OR dono_email LIKE ? OR dono_telefone LIKE ? OR dono_nome LIKE ?)", Array("%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%", "%".$q."%"));
}

$banco->orderBy("id", "DESC");

$listaItens = $banco->paginate("chavespix", $page);
                  
$paginacao = new Paginator($banco->pageLimit,"q=$q&page");
$paginacao->set_total($banco->totalCount);
$paginacao->set_page($page);



$c = '
<div class="card">

  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
      <thead>
        <tr>
          <th class="w-1">CHAVE</th>
          <th>Chave</th>
          <th>Saldo</th>
          <th>Gerado</th>
          <th>Arrecadado</th>
          <th>Repassado</th>
          <th>Pendente</th>
          <th>Dono</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach($listaItens as $item) {
        $item = (object) $item;
        $c.= '<tr>
          <td><a href="chaves/'.$item->id.'">'.$item->id.'</a></td>
          <td>'.$item->chave .'<br />'.$item->chave_tipo .'</td>
          <td>'.$item->saldo .'</td>
          <td>'.$item->total_gerado .'</td>
          <td>'.$item->total_arrecadado .'</td>
          <td>'.$item->total_repassado .'</td>
          <td>'.$item->total_pendente .'</td>
          <td>
          '. (($item->dono_nome=="") ? "-" : $item->dono_nome) .'<br />
          '. (($item->dono_documento=="") ? "-" : "DOC: ".$item->dono_documento) .'
          </td>
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