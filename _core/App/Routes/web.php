<?php


/**
 * INÍCIO DAS ROTAS
 */
 $Route->get('','HomeController@vazio');
 
 
 // páginas
 $Route->get('suporte','HomeController@suporte');
 $Route->get('ajuda','HomeController@suporte');
 $Route->get('termos','HomeController@termos');
 $Route->get('privacidade','HomeController@privacidade');
 $Route->get('desenvolvedores','HomeController@desenvolvedores');
 $Route->get('central-de-ajuda','HomeController@suporte');
 $Route->get('tarifas-e-prazos','HomeController@tarifas');
 
 $Route->get('gerar-qrcode','HomeController@gerarQrcode');


 $Route->view('erro','default/home/erro');
 
 //$Route->get('webhook', 'WebhookController@index');
 
 // LIBERAÇÕES DO MERCADO PAGO
 //$Route->post('mp', 'WebhookController@mp');
 
 // TODO: ############
 $Route->group2('ajax', function () {
     \SmartSolucoes\Libs\Helper::ajax($_POST['controller'], $_POST['action'], $_POST['param']);
     exit();
 });


 // ACESSO AO PAINEL DO CLIENTE
 $Route->group(PAINEL_PREFIX, function ($Route) {
  $Route->get('', 'PainelController@inicio');
  $Route->getPost('login', 'PainelController@login');
  $Route->getPost('sair', 'PainelController@sair');

});


 // ACESSO DO STAFF
 $Route->group(ADMIN_PREFIX, function ($Route) {
  $Route->get('', 'AdminController@inicio');
  $Route->getPost('login', 'AdminController@login');
  $Route->getPost('sair', 'AdminController@sair');

  $Route->getPost('pix', 'AdminController@pix');
  $Route->getPost('chaves', 'AdminController@chaves');
  $Route->getPost('lancamentos', 'AdminController@lancamentos');
  $Route->getPost('contas', 'AdminController@contas');
  $Route->getPost('saques', 'AdminController@saques');
  
  $Route->getPost('ajaxDb', 'AdminController@ajaxDb');
  $Route->getPost('ajaxDbInfo', 'AdminController@ajaxDbAlteraInfo');
  $Route->getPost('ajaxDbSolicitaSaque', 'AdminController@ajaxDbSolicitaSaque');
  $Route->getPost('ajaxDbProcessaSaque', 'AdminController@ajaxDbProcessaSaque');

});

 
 if(count($url) > 0) {
   \SmartSolucoes\Controller\ChaveController::checaUrl();
 }
 die("Chegou ao final do routes web: ".print_r($url, 1));
 