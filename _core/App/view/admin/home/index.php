<?php

$tema = "admin";
$titulo = "Dashboard";

$showBusca = false;

$c = '

<div class="row g-3">


  <div class="col-lg-4">
    <div class="row row-cards">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Últimos PIX</div>
            <div class="divide-y">
            ';
            $lista = $banco->orderBy('id', 'DESC')->get('chaves', 10);
            foreach($lista as $listaItem) {
              $listaItem = (object) $listaItem;
              $c.= '
              <div>
                <a href="./pix/'.$listaItem->id.'">Pix #'.$listaItem->id.'</a><br />
                '.$listaItem->chave_tipo.': '.getChavepix($listaItem->chavepix_id, 'chave').'<br />
                Valor: R$ '.number_format($listaItem->chave_valor, 2, ',', '.').'<br />
                Identificador: '.$listaItem->chave_identificador.'<br />
                Recebido: R$ '.number_format($listaItem->valor_recebido, 2, ',', '.').'<br />
                Views: '.$listaItem->views.'<br />
                Status: '.$listaItem->status.'<br />
              </div>';
            }
            $c.='
            </div>
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
            <div class="card-title">Últimas Chaves</div>
            <div class="divide-y">
            ';
            $lista = $banco->orderBy('id', 'DESC')->get('chavespix', 20);
            foreach($lista as $listaItem) {
              $listaItem = (object) $listaItem;
              $c.= '
              <div>
                <a href="./chavepix/'.$listaItem->id.'">ChavePix '.getChavepix($listaItem->id, "chave").'</a><br />
                Gerado: R$ '.number_format($listaItem->total_gerado, 2, ',', '.').'<br />
                Saldo: R$ '.number_format($listaItem->saldo, 2, ',', '.').'
              </div>';
            }
            $c.='
            </div>
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
            <div class="card-title">Últimos Pagamentos</div>
            <div class="divide-y">
            ';
            $lista = $banco->where("valor_recebido", "0", ">")->orderBy('id', 'DESC')->get('lancamentos', 10);
            foreach($lista as $listaItem) {
              $listaItem = (object) $listaItem;
              $c.= '
              <div>
                Cód: #'.$listaItem->id.' em '.$listaItem->updateAt.'<br />
                <a href="./pix/'.$listaItem->chave_id.'">Pix #'.$listaItem->chave_id.'</a><br />
                Valor: R$ '.number_format($listaItem->valor, 2, ',', '.').'<br />
                Taxas: R$ '.number_format($listaItem->valor_taxas, 2, ',', '.').'<br />
                Total: R$ '.number_format($listaItem->valor_total, 2, ',', '.').'<br />
                Recebido: R$ '.number_format($listaItem->valor_recebido, 2, ',', '.').'<br />
                Status: '.$listaItem->status.'
              </div>';
            }
            $c.='
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>



</div>
';
