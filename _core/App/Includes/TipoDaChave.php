<?php

function tipoDaChave($chave='') {

  // é invalida
  if($chave=='') return false;

  // checa se é um email
  if(filter_var($chave, FILTER_VALIDATE_EMAIL)) return 'email';

  // checa se é um UUID
  // if(isValidUuid($chave)) return 'chave';
  // desativado a chave aleatória

  $chaveNumeros = preg_replace('/[^0-9]/', '', $chave);

  // checa se é CPF
  if(validaCPF($chaveNumeros)) return 'cpf';

  // valida se é um CNPJ
  if(validaCNPJ($chaveNumeros)) return 'cnpj';

  // valida se tem a quantidade de números de um telefone
  if(strlen($chaveNumeros) == 11 || strlen($chaveNumeros) == 10) return 'telefone';

  return false;

}


function validaCPF($cpf) {
 
  // Extrai somente os números
  $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
   
  // Verifica se foi informado todos os digitos corretamente
  if (strlen($cpf) != 11) {
      return false;
  }

  // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  if (preg_match('/(\d)\1{10}/', $cpf)) {
      return false;
  }

  // Faz o calculo para validar o CPF
  for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
          return false;
      }
  }
  return true;

}


function validaCNPJ($cnpj) {
   
  // Extrai somente os números
  $cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );
   
  // Verifica se foi informado todos os digitos corretamente
  if (strlen($cnpj) != 14) {
      return false;
  }

  // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  if (preg_match('/(\d)\1{13}/', $cnpj)) {
      return false;
  }

  // Faz o calculo para validar o CNPJ
  for ($t = 12; $t < 14; $t++) {
      for ($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++) {
          $d += $cnpj[$c] * $p;
          $p = ($p < 3) ? 9 : --$p;
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cnpj[$c] != $d) {
          return false;
      }
  }
  return true;
}




/**
 * Check if a given string is a valid UUID
 * 
 * @param   string  $uuid   The string to check
 * @return  boolean
 */
function isValidUuid( $uuid ) {
    
  if (!is_string($uuid) || (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1)) {
      return false;
  }

  return true;
}


function validaEmail($email) {
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  } else {
    return false;
  }
}