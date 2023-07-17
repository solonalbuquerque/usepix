<?php

/**
 * CONFIGURAÇÕES DO SISTEMA E INICIALIZAÇÃO
 * Sólon Albuquerque
 * solonalbuquerque@gmail.com
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('memory_limit', '-1');
set_time_limit(120);
ini_set('xdebug.max_nesting_level', 9999);

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

define('ROOT', getcwd() . DIRECTORY_SEPARATOR . '_core' . DIRECTORY_SEPARATOR);
define('APP', ROOT."App".DIRECTORY_SEPARATOR);

define('ADMIN_PREFIX', "adm");
define('PAINEL_PREFIX', "painel");

// get BASE_URL
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
define('BASE_URL', $base_url);

$_urlCompleta = $base_url . $_SERVER['REQUEST_URI'];

define('SISTEMA', "UsePIX");
define('SISTEMA_NOME', SISTEMA);
define('SISTEMA_SITE', BASE_URL);
define('SISTEMA_LOGO_EMAIL', BASE_URL."/assets/img/logo.png");

define('EMAIL_FROM', 'contato@usepix.com.br');

// pode separar por vírgula
define('EMAIL_ADMIN', 'contato@usepix.com.br');


//session_start();

include("vendor/autoload.php");

// includes
foreach (glob(APP."Includes/*.php") as $_FuncaoAdd){
  require_once($_FuncaoAdd);
}

// sessao
use rcastera\Browser\Session\Session;
$sessao = new Session();

// carregar variáveis ENV
$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

foreach($_ENV as $k=>$v) {
  if(!defined($k)) define($k, $v);
}
$config_environment = $_ENV["ENVIRONMENT"];

define('WEBHOOK_URL', $base_url."/api/webhook/".WEBHOOK_SECRET."/");

// conecta-se ao banco de dados
$banco = new MysqliDb (Array (
    'host' => DB_HOST,
    'username' => DB_USER, 
    'password' => DB_PASS,
    'db'=> DB_NAME,
    'port' => DB_PORT,
    'charset' => DB_CHARSET
));

// registra o log
$banco->setTrace (true);

// para exibir o log:
//print_r ($banco->trace);

$url = \SmartSolucoes\Libs\Helper::splitUrl();

//die("url: ".var_dump($url));

use SmartSolucoes\Core\Route;
$Route = New Route($url);

use voku\helper\AntiXSS;
$antiXss = new AntiXSS();

$q = requirevar("q", false);

$vars = getAllParams();

// includes rotas
foreach (glob(APP."Routes/*.php") as $_FuncaoAdd){
  require_once($_FuncaoAdd);
}

