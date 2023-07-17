<?php

$_meiosDePagamento = [];

$_meiosDePagamento['cartao'] = [
  "modulo" => "cartao",
  "gateway" => "MpCartao", // pasta do gateway
  "nome" => "Cartão de Crédito",
  "descricao" => "O pagamento com cartão de crédito é um dos meios de pagamento mais utilizados no mundo e permite que você pague suas compras em lojas físicas ou online, sem precisar ter dinheiro em espécie em até 12 vezes.",
  "logo" => "./assets/images/cartao.svg",
  "pagamento" => [
    "ativo" => true, // ativa o meio de pagamento
    "destaque" => true, // destaque na página de pagamento
    "taxa" => 6,
    "taxaTipo" => "porcentagem", // porcentagem ou valor
    "taxaMinima" => 0,
    "taxaMaxima" => 0,
    "taxaFixa" => 1,
    "taxaFixaTipo" => "porcentagem", // porcentagem ou valor
    "taxaFixaMinima" => 1,
    "taxaFixaMaxima" => 0,
    "textoBotao" => "<strong>Cartão de Crédito</strong> em até 12x",
    "iconeBotao" => '',
    "textoSelect" => "Cartão de Crédito - em até 12x",
  ],
];

$_meiosDePagamento['pix'] = [
  "modulo" => "pix",
  "gateway" => "MpPix", // pasta do gateway
  "nome" => "PIX",
  "descricao" => "O PIX é um novo meio de pagamento instantâneo, seguro e gratuito, disponível 24 horas por dia, sete dias por semana, todos os dias do ano. O PIX permite que você transfira dinheiro para qualquer pessoa, em qualquer banco, pelo aplicativo do seu banco ou por um QR Code.",
  "logo" => "./assets/images/pix.svg",
  "pagamento" => [
    "ativo" => true, // ativa o meio de pagamento
    "destaque" => true, // destaque na página de pagamento
    "taxa" => 2,
    "taxaTipo" => "porcentagem", // porcentagem ou valor
    "taxaMinima" => 0,
    "taxaMaxima" => 0,
    "taxaFixa" => 1,
    "taxaFixaTipo" => "porcentagem", // porcentagem ou valor
    "taxaFixaMinima" => 1,
    "taxaFixaMaxima" => 0,
    "textoBotao" => "<strong>PIX</strong> QrCode ou Copia e Cola",
    "iconeBotao" => '',
    "textoSelect" => "PIX - QrCode ou Copia e Cola",
  ],
];

$_meiosDePagamento['mercadopago'] = [
  "modulo" => "mercadopago",
  "gateway" => "MpSaldo", // pasta do gateway
  "nome" => "Mercado Pago",
  "descricao" => "O Mercado Pago é um meio de pagamento online do grupo Mercado Livre e permite que você pague com cartão de crédito, cartão de débito e saldo em conta.",
  "logo" => "./assets/images/mercado-pago.svg",
  "pagamento" => [
    "ativo" => true, // ativa o meio de pagamento
    "destaque" => true, // destaque na página de pagamento
    "taxa" => 6,
    "taxaTipo" => "porcentagem", // porcentagem ou valor
    "taxaMinima" => 0,
    "taxaMaxima" => 0,
    "taxaFixa" => 1,
    "taxaFixaTipo" => "porcentagem", // porcentagem ou valor
    "taxaFixaMinima" => 1,
    "taxaFixaMaxima" => 0,
    "textoBotao" => "<strong>Mercado Pago</strong> saldo ou cartão",
    "iconeBotao" => '',
    "textoSelect" => "Mercado Pago - saldo ou cartão",
  ],
];

$_meiosDePagamento['paypal'] = [
  "modulo" => "paypal",
  "gateway" => "Paypal", // pasta do gateway
  "nome" => "PayPal",
  "descricao" => "O PayPal é um meio de pagamento online que permite que você pague com cartão de crédito, cartão de débito, saldo em conta e moedas extrangeiras, como o Dólar e o Euro, por exemplo.",
  "logo" => "./assets/images/paypal.svg",
  "pagamento" => [
    "ativo" => false, // ativa o meio de pagamento
    "destaque" => false, // destaque na página de pagamento
    "taxa" => 0,
    "taxaTipo" => "porcentagem", // porcentagem ou valor
    "taxaMinima" => 0,
    "taxaMaxima" => 0,
    "taxaFixa" => 0,
    "taxaFixaTipo" => "porcentagem", // porcentagem ou valor
    "taxaFixaMinima" => 0,
    "taxaFixaMaxima" => 0,
    "textoBotao" => "<strong>PayPal</strong>",
    "iconeBotao" => '',
    "textoSelect" => "PayPal",
  ],
];