<?php


function _requireVar($request='', $response='', $var='', $obrigatorio=true, $protegeXss=true) {
    global $antiXss, $argumentos;
        
    $_post = $_POST[$var];
    
    if(!isset( $_post ) OR $_post=="")
        $_post = $_GET[$var];
        
    if(isset( $_post ) AND $_post!="") {
        if($protegeXss==true)
            $_post = $antiXss->xss_clean($_post);
        return trim($_post);
    }
    
    if($request) {
        
        $_post = $request->getParam("$var");
        if(!isset( $_post ) OR $_post=="")
            $_post = $argumentos["$var"];
        
        if(!isset($_post) OR $_post=="") {
            $route = $request->getAttribute('route');
            $_post = $route->getArgument($var);
        }
        
        if(isset( $_post ) AND $_post!="") {
            if($protegeXss==true)
                $_post = $antiXss->xss_clean($_post);
            return trim($_post);
        }
        
        // se não conseguir encontrar, vai mais além no padrão
        
        $_post = $_POST[$var];
        
        if(!isset( $_post ) OR $_post=="")
            $_post = $_GET[$var];
            
        if(!isset( $_post ) OR $_post=="")
            $_post = $_REQUEST[$var];
        
        if(isset( $_post ) AND $_post!="") {
            if($protegeXss==true)
                $_post = $antiXss->xss_clean($_post);
            return trim($_post);
        }
        
            
        if($obrigatorio==true)
            die( jsonError($response, "Está faltando o seguinte dado na requisição: $var") );
        
    } else {
        
        $_post = $_POST[$var];
        
        if(!isset( $_post ) OR $_post=="")
            $_post = $_GET[$var];
            
        if(!isset( $_post ) OR $_post=="")
            $_post = $_REQUEST[$var];
        
        if(isset( $_post ) AND $_post!="") {
            if($protegeXss==true)
                $_post = $antiXss->xss_clean($_post);
            return trim($_post);
        }
            
        if($obrigatorio==true)
            jsonErrorSimple("Está faltando o seguinte dado: $var");
            
    }
    
    return false;
    
}



function requirevar($var='', $exige=false) {
    global $_POST, $_GET, $_REQUEST;
    if(isset($_POST[$var])) return trim(strip_tags(strtolower($_POST[$var])));
    if(isset($_GET[$var])) return trim(strip_tags(strtolower($_GET[$var])));
    if(isset($_REQUEST[$var])) return trim(strip_tags(strtolower($_REQUEST[$var])));
    if($exige==true) die("$var é necessário");
    return null;
}