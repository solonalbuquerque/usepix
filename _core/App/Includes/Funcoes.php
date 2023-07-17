<?php
use SmartSolucoes\Libs\Helper;


function removerPontosValor($valor) {
  return str_replace('.', '', $valor);
}

function trataMoeda($moeda='') {
  $moeda = trim(preg_replace("/[^0-9.,]/", "", $moeda));
  if($moeda=="") $moeda = 0;
  //$moeda = str_replace('.', '.', $moeda);
  $moeda = str_replace(',', '.', $moeda);
  return $moeda;
}

// puxa dados de uma string entre dois caracteres
function getBetween($content,$start,$end){
  $r = explode($start, $content);
  if (isset($r[1])){
      $r = explode($end, $r[1]);
      return $r[0];
  }
  return '';
}

function removeHtmlElement($html, $elemento, $classeOuId) {
  $dom = new DOMDocument('1.0', 'UTF-8');
  $dom->loadHTML($html);
  $elementos = $dom->getElementsByTagName($elemento);
  if(substr($classeOuId, 0, 1) == '.') {
    // is class
    $classeOuId = substr($classeOuId, 1);
    foreach($elementos as $elemento) {
      if($elemento->getAttribute('class') == $classeOuId) {
        $elemento->parentNode->removeChild($elemento);
      }
    }
  } else {
    $classeOuId = substr($classeOuId, 1);
    foreach($elementos as $elemento) {
      if($elemento->getAttribute('id') == $classeOuId) {
        $elemento->parentNode->removeChild($elemento);
      }
    }
  }
  return $dom->saveHTML();
}

// Formartar números
function numeros($num) {
  return number_format($num, 0, '.', '.');
}

// Only numbers
function somenteNumeros($string) {
  return preg_replace("/[^0-9]/", "", $string);
}

// Faz o hash da senha
function senhaEncode($senha='') {
  $options = [
    'cost' => 12,
  ];
  return password_hash($senha, PASSWORD_BCRYPT, $options);
}

// Gera senha
function vkey($length = 8) {
  $chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
  $count = mb_strlen($chars);
  for ($i = 0, $result = ''; $i < $length; $i++) {
    $index = rand(0, $count - 1);
    $result .= mb_substr($chars, $index, 1);
  }
  return $result;
}

// Forçar a ter um parametro no link
function parametroLink($nomeDoParametro='id') {
  global $param;
  if(isset($param[$nomeDoParametro])) {
    return true;
  } else {
    $response['mensagem'] = 'Acesso negado: parametro -'.$nomeDoParametro.'- vazio ou não encontrado.';
    Helper::view('admin/home/erro', $response);
  }
}

// Função de porcentagem: Quanto é X% de N?
function porcentagem_xn ( $porcentagem, $total, $decimais = 2 ) {
	return round( ( $porcentagem / 100 ) * $total, $decimais );
}

// Função de porcentagem: N é X% de N
function porcentagem_nx ( $parcial, $total, $decimais = 2 ) {
  if($total == 0) return round( 0, $decimais );
  return round( ( $parcial * 100 ) / $total, $decimais );
}

// 2022-11-23 09:55:54
function converteDataView($data='') {
  if($data == '') {
    return "-";
  } else {
    $data = explode(' ', $data);
    $dias = explode('-', $data[0]);
    return implode("/", array_reverse($dias))."<br />".substr($data[1], 0, -3);
  }
}


//https://gist.github.com/brunocmoraes/9bf9cc094ecd51d7dfae8c1be6c2ea8f
function formatarTelefone($n) {
    $tam = strlen(preg_replace("/[^0-9]/", "", $n));
    
    if ($tam == 14) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
        return "+".substr($n, 0, $tam-11)." (".substr($n, $tam-11, 2).") ".substr($n, $tam-9, 5)."-".substr($n, $tam-5);
    }
    
    if ($tam == 13) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
        return "+".substr($n, 0, $tam-11)." (".substr($n, $tam-11, 2).") ".substr($n, $tam-9, 5)."-".substr($n, -4);
    }
    if ($tam == 12) {
        // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
        return "+".substr($n, 0, $tam-10)." (".substr($n, $tam-10, 2).") ".substr($n, $tam-8, 4)."-".substr($n, -4);
    }
    if ($tam == 11) {
        // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
        return " (".substr($n, 0, 2).") ".substr($n, 2, 5)."-".substr($n, 7, 11);
    }
    if ($tam == 10) {
        // COM CÓDIGO DE ÁREA NACIONAL
        return " (".substr($n, 0, 2).") ".substr($n, 2, 4)."-".substr($n, 6, 10);
    }
    if ($tam <= 9) {
        // SEM CÓDIGO DE ÁREA
        return substr($n, 0, $tam-4)."-".substr($n, -4);
    }
}

function telefone($num='') {
  $num = preg_replace("/[^0-9]/", "", $num);
  if(strlen($num) == 13 || strlen($num) == 12) {
    // 5579999690072
    return $num;
  } else if(strlen($num) == 11 || strlen($num) == 10) {
    // 79999690072
    return "55".$num;
  } else {
    return "5511".$num;
  }
}

// Retorna a URL atual
function url(){
  if(isset($_SERVER['HTTPS'])){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  }
  else{
      $protocol = 'http';
  }
  return $protocol . "://" . $_SERVER['HTTP_HOST'];
}


// gerar uma UUID
// https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function uuid() {
  $uuid = array(
   'time_low'  => 0,
   'time_mid'  => 0,
   'time_hi'  => 0,
   'clock_seq_hi' => 0,
   'clock_seq_low' => 0,
   'node'   => array()
  );
  
  $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
  $uuid['time_mid'] = mt_rand(0, 0xffff);
  $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
  $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
  $uuid['clock_seq_low'] = mt_rand(0, 255);
  
  for ($i = 0; $i < 6; $i++) {
   $uuid['node'][$i] = mt_rand(0, 255);
  }
  
  $uuid = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
   $uuid['time_low'],
   $uuid['time_mid'],
   $uuid['time_hi'],
   $uuid['clock_seq_hi'],
   $uuid['clock_seq_low'],
   $uuid['node'][0],
   $uuid['node'][1],
   $uuid['node'][2],
   $uuid['node'][3],
   $uuid['node'][4],
   $uuid['node'][5]
  );
  
  return $uuid;
 }


 function formataMoedaBRL($valor) {
  return number_format($valor, 2, ',', '.');
}


function dataItemArray($itens) {
  $r = "";
  foreach($itens as $k=>$v) {
    $r.= ' data-'.$k.'="'.$v.'"';
  }
  return $r;
}