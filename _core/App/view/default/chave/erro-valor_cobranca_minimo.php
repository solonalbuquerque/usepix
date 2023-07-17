<?php

$tema = "default";
$titulo = "Erro: Valor mínimo para cobrança";

$c = boxErro('Valor mínimo para cobrança', 'A chave PIX que está tentando utilizar só pode gerar uma cobrança com um <strong>mínimo de R$ '.formataMoedaBRL($response->valor_cobranca_minimo).'</strong>. Gere uma nova cobrança com um valor maior.');