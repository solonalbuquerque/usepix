<?php

$Route->group('api', function ($Route) {
  $Route->get('', 'ApiController@inicio');
  
  $Route->post('init', 'ApiController@inicia');

  $Route->post('payf', 'ApiController@payf');
  $Route->getPost('payfpgto', 'ApiController@payfChecaPagamento');
  
  $Route->getPost('webhook', 'ApiWebhookController@processaWebhook');
  $Route->getPost('MpConfirmaPay', 'ApiWebhookController@MpConfirmaPay');
  
  $Route->getPost('consultar', 'ApiController@consultar');
  $Route->post('criar', 'ApiController@criar');

});