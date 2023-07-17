<?php

/**
 * Envia um email
 * dados:


$_msgEmail = [
    'para-email' => "lo@lo.com",
    'para-nome' => "Fulano",
    'assunto' => "Assunto",
    'titulo' => "Olá, Fulano",
    'mensagem' => "Oi"
];

$retornoEmail = email($_msgEmail, "default");

 */
function email($dados, $template='default', $anexos = array() ) {
    global $banco, $_userid;
    
    $dados['sistema'] = SISTEMA;
    $dados['sistema_nome'] = SISTEMA_NOME;
    $dados['sistema_site'] = SISTEMA_SITE;
    $dados['sistema_logo'] = SISTEMA_LOGO_EMAIL;
    $dados['envio_data'] = date("d/m/Y");
    $dados['envio_hora'] = date("H:i");
    
    if(!isset($dados['titulo']))
        $dados['titulo'] = $dados['assunto'];
    
    $mensagem = "";
    
    $tema = new Text_Template(APP."emails/header.tpl", "{{", "}}");
    $tema->setVar($dados);
    
    // topo
    $mensagem.= $tema->render();
    
    if(is_file(APP."emails/$template.tpl")) {
        $tema->setFile(APP."emails/$template.tpl");
    } else {
        $tema->setFile(APP."emails/default.tpl");
    }
    $mensagemRaiz = nl2br($tema->render());
    $mensagem.= $mensagemRaiz;
    
    
    $tema->setFile(APP."emails/footer.tpl");
    $mensagem.= $tema->render();
    
    
    
    $m = new SimpleEmailServiceMessage();

    $m->addTo($dados['para-email']);
    $m->setFrom(EMAIL_FROM);
    $m->setSubject($dados['assunto']);
    $m->setMessageFromString(strip_tags($mensagem), $mensagem);
    
    if(is_array($anexos) AND count($anexos)>0 AND is_array($anexos)) {
        //print_r($anexos);
        foreach($anexos as $anexoK=>$anexoV) {
            //print_r($k);
            //echo "<br /><br />\$m->addAttachmentFromUrl($k[nome], $k[arquivo]);<br />";
            //$m->addAttachmentFromUrl($k['nome'], $k['arquivo']);
            $m->addAttachmentFromData($anexoV['nome'], file_get_contents($anexoV['arquivo']) );
        }
    }
    
    
    $ses = new SimpleEmailService(AWS_KEY, AWS_SECRET);
    $ses->enableVerifyPeer(false);
    $envio = $ses->sendEmail($m);
    
    //die(print_r($envio));
    
    
    
    $v = array();
    $v['id'] = NULL;
    if($_userid!="") $v['userid'] = $_userid;
    $v['type'] = "email";
    //$v['project'] = "";
    $v['createdAt'] = $banco->now();
    //$v['name'] = $nomeDestinatario;
    $v['address'] = $dados['para-email'];
    $v['message'] = $mensagem;
    $v['success'] = 0;
    $v['info'] = json_encode($envio);
    $banco->insert('emailesms', $v);
    
    return $envio;
    
}



function sms($numero, $mensagem='', $nomeDestinatario='') {
    global $banco, $_userid;
    
    $v = array();
    $v['id'] = NULL;
    if($_userid!="") $v['userid'] = $_userid;
    $v['type'] = "sms";
    //$v['project'] = "";
    $v['createdAt'] = $banco->now();
    $v['name'] = $nomeDestinatario;
    $v['address'] = $numero;
    $v['message'] = $mensagem;
    
    
    $chamada = "http://www.pw-api.com/sms/v_3_00/smspush/enviasms.aspx?Credencial=2793B4502BD0C79EDF21E9E1CA5250DDF75D41A7&Token=42cCb4&Principal_User=FF&Aux_User=F1&Mobile={$numero}&Send_Project=N&Message=".URLEncode($mensagem);
    
    $response = fopen($chamada,"r");
    $resposta = fgets($response,4);
        
    $v['success'] = 0;
    $v['info'] = $resposta." - $chamada";
    $banco->insert('emailesms', $v);
    
    if($resposta!="000") {
        
        return false;
        
    } else {
        
        return false;

    }
    
}



function notificaAdmin($assunto, $mensagem) {
    
    $emails = EMAIL_ADMIN;
    $emails = explode(",", $emails);
    foreach($emails as $email) {
        $email = trim($email);
        $_msgEmail = [
            'para-email' => $email,
            'para-nome' => "Administrador",
            'assunto' => $assunto,
            'titulo' => "NOTIFICAÇÃO AUTOMÁTICA ADMIN",
            'mensagem' => $mensagem
        ];
        email($_msgEmail, "default");
    }

}