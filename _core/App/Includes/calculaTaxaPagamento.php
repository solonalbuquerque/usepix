<?php

function calculaTaxaPagamento($valor, $metodo, $detalhada=false) {
  global $_meiosDePagamento, $_taxaFixaSistema;

  $meioPagamento = $_meiosDePagamento[$metodo];
  $meioTaxas = $meioPagamento["pagamento"];

  $r = [
    'valor' => $valor,
    'valor_taxas' => 0,
    'total' => 0,
    'taxas' => []
  ];

  // taxa do meio de pagamento
  if($meioTaxas['taxa'] > 0) {
    $valorTaxa = calculoDaTaxaPagamento($valor, $meioTaxas['taxa'], $meioTaxas['taxaTipo'], $meioTaxas['taxaMinima'], $meioTaxas['taxaMaxima']);
    $r['taxas'][] = [
      'tipo' => 'taxa',
      'descricao' => 'Taxa do meio de pagamento',
      'valor' => $valorTaxa
    ];
    $r['valor_taxas'] += $valorTaxa;
    $r['total'] += $valorTaxa;
  }

  // taxa do meio de pagamento
  if($meioTaxas['taxaFixa'] > 0) {
    $valorTaxa = calculoDaTaxaPagamento($valor, $meioTaxas['taxaFixa'], $meioTaxas['taxaFixaTipo'], $meioTaxas['taxaFixaMinima'], $meioTaxas['taxaFixaMaxima']);
    $r['taxas'][] = [
      'tipo' => 'taxa',
      'descricao' => 'Taxa fixa do meio de pagamento',
      'valor' => $valorTaxa
    ];
    $r['valor_taxas'] += $valorTaxa;
    $r['total'] += $valorTaxa;
  }

  // taxa do sistema
  if($_taxaFixaSistema['taxa'] > 0) {
    $valorTaxa = calculoDaTaxaPagamento($valor, $_taxaFixaSistema['taxa'], $_taxaFixaSistema['taxaTipo'], $_taxaFixaSistema['taxaMinima'], $_taxaFixaSistema['taxaMaxima']);
    $r['taxas'][] = [
      'tipo' => 'taxa',
      'descricao' => 'Taxa do sistema',
      'valor' => $valorTaxa
    ];
    $r['valor_taxas'] += $valorTaxa;
    $r['total'] += $valorTaxa;
  }

  // taxa fixa do sistema
  if($_taxaFixaSistema['taxaFixa'] > 0) {
    $valorTaxa = calculoDaTaxaPagamento($valor, $_taxaFixaSistema['taxaFixa'], $_taxaFixaSistema['taxaFixaTipo'], $_taxaFixaSistema['taxaFixaMinima'], $_taxaFixaSistema['taxaFixaMaxima']);
    $r['taxas'][] = [
      'tipo' => 'taxa',
      'descricao' => 'Taxa fixa do sistema',
      'valor' => $valorTaxa
    ];
    $r['valor_taxas'] += $valorTaxa;
    $r['total'] += $valorTaxa;
  }

  $r['total'] = number_format($r['total'], 2, '.', '');

  if($detalhada) {
    return $r;
  } else {
    return $r['total'];
  }

}



//$taxas = calculaTaxaPagamento("250", "cartao", true);
//die(print_r($taxas, true));


function calculoDaTaxaPagamento($valor, $taxa, $taxaTipo, $taxaMinima, $taxaMaxima) {

  if($taxaTipo == 'porcentagem') {
    $valorTaxa = $valor * ($taxa/100);
  } else {
    $valorTaxa = $taxa;
  }

  if($taxaMinima > 0 && $valorTaxa < $taxaMinima) {
    $valorTaxa = $taxaMinima;
  }

  if($taxaMaxima > 0 && $valorTaxa > $taxaMaxima) {
    $valorTaxa = $taxaMaxima;
  }

  return number_format($valorTaxa, 2, '.', '');
}