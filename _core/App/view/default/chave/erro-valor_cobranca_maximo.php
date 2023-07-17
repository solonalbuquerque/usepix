<?php

$tema = "default";
$titulo = "Erro: Valor ultrapassa limite para cobrança";

$c = boxErro('Valor ultrapassa limite para cobrança', 'A chave PIX que está tentando utilizar só pode gerar uma cobrança com um <strong>máximo de R$ '.formataMoedaBRL($response->valor_cobranca_maximo).'</strong>. Gere uma nova cobrança com um valor menor ou entre em contato conosco para aumentar o limite para essa chave.');