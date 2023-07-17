<?php

function disparaNotificacaoUrl($faturaId='') {
  $dados = ChaveModel::completo($faturaId, true);
  // curl post url
  if(isset($dados->notification_url) && !empty($dados->notification_url)) {
    $url = $dados->notification_url;
  } else {
    return false;
  }
  // curl post
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 1);
  $response = curl_exec($ch);
  curl_close($ch);

  return true;

}