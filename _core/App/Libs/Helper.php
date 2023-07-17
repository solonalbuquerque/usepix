<?php
namespace SmartSolucoes\Libs;

use SmartSolucoes\Libs\Upload;
use SmartSolucoes\Core\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Helper
{

  static function redirect($url) {
    header("Location: ".URL_BASE."/admin/".$url);
    exit;
  }

  static public function uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
      mt_rand( 0, 0xffff ),
      mt_rand( 0, 0x0fff ) | 0x4000,
      mt_rand( 0, 0x3fff ) | 0x8000,
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }

  static public function erro($mensagem='') {
    header("Location: ".URL_ADMIN."/erro/".base64_encode($mensagem));
    exit;
  }

  static public function sistemasLista() {
    $r = [];
    foreach (glob(ROOT."application/sistemas/*", GLOB_ONLYDIR) as $_FuncaoAdd){
      $e = explode("sistemas/", $_FuncaoAdd);
      $r[] = $e[1];
    }
    return $r;
  }

    static public function splitUrl()
    {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            //$url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    static public function view($view, $responseData = [])
    {
      global $db, $banco, $pdo, $response, $_usuario, $config_environment,
             $_admin, $chave, $tema, $c, $_meiosDePagamento, $_perguntaFrequentesPix,
             $_limites, $_perguntaFrequentes, $_dadosContato, $_urlCompleta,
             $base_url, $erro, $usuario, $admin, $q, $showBusca, $moduloView, $vars,
             $linkVoltar, $linkAtual;
      
        $response = $responseData;
        
        // seta variaveis mínimas
        $titulo = $c = "";

        $moduloView = explode("/", $view);
        $moduloView = end($moduloView);

        if(!$view) {
            $view = 'error/index';
            $moduloView = "error";
        }

        // abre a view
        require APP . 'view/' . $view . '.php';

        // verifica se tem tema e roda o tema
        if(file_exists(APP . 'view/temas/' . $tema . '.php')) {
            require APP . 'view/temas/' . $tema . '.php';
        } else {
            require APP . 'view/temas/default.php';
        }
    }

    static public function ajax($nomecontroller,$action,$param)
    {
        $getController = '\SmartSolucoes\Controller\\'.$nomecontroller.'Controller';
        $controller = New $getController();
        $controller->{$action}($param);
    }

    static public function upload($arquivo,$nome_arquivo,$caminho,$formato=false,$largura=false,$altura=false,$ratio=true)
    {
        $foo = new Upload($arquivo);
        if ($foo->uploaded) {
            $foo->file_overwrite = true;
            $foo->file_new_name_body = $nome_arquivo;
            if($largura) {
                $foo->image_convert = $formato;
            }
            if($largura) {
                $foo->image_resize = true;
                $foo->image_ratio = $ratio;
                $foo->image_x = $largura;
                $foo->image_y = $altura;
            }
            $foo->Process($caminho);
            if ($foo->processed) {
                $foo->Clean();
                return true;
            } else {
//                return $foo->error;
                return false;
            }
        } else {
//            return $foo->error;
            return false;
        }
    }

    static public function rearrange( $arr ){
        foreach( $arr as $key => $all ){
            foreach( $all as $i => $val ){
                $new[$i][$key] = $val;
            }
        }
        return $new;
    }

    static public function iconFile($file){
        $file = explode('.',$file);
        $ext = end($file);
        switch ($ext){
            case 'doc':
            case 'docx':
                $icon = 'fa fa-file-word-o';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $icon = 'fa fa-file-excel-o';
                break;
            case 'ppt':
            case 'pptx':
                $icon = 'fa fa-file-powerpoint-o';
                break;
            case 'pdf':
                $icon = 'fa fa-file-pdf-o';
                break;
            case 'psd':
            case 'cdr':
            case 'ai':
            case 'bmp':
            case 'gif':
            case 'jpeg':
            case 'jpg':
            case 'png':
                $icon = 'fa fa-file-image-o';
                break;
            case 'zip':
            case 'rar':
            case '7z':
                $icon = 'fa fa-file-archive-o';
                break;
            case 'mp3':
            case 'wma':
            case 'aac':
            case 'ogg':
            case 'ac3':
            case 'wav':
                $icon = 'fa fa-file-audio-o';
                break;
            case 'mpeg':
            case 'mov':
            case 'avi':
            case 'rmvb':
            case 'mkv':
            case 'mxf':
            case 'pr':
                $icon = 'fa fa-file-movie-o';
                break;
            case 'txt':
                $icon = 'fa fa-file-text-o';
                break;
            case 'php':
            case 'html':
            case 'css':
            case 'js':
                $icon = 'fa fa-file-code-o';
                break;
            default:
                $icon = 'fa fa-file-o';
                break;
        }
        return $icon;
    }

    static public function dataHora($data,$gravar=false) {
        if($gravar) {
            $data = str_replace('/', '-', $data);
            $data = date('Y-m-d H:i:s',strtotime($data));
        } else {
            $data = date('d/m/Y H:i',strtotime($data));
        }

        return $data;
    }

    static public function data($data,$gravar=false) {
        if($data) {
            if($gravar) {
                $data = str_replace('/', '-', $data);
                $data = date('Y-m-d',strtotime($data));
            } else {
                $data = date('d/m/Y',strtotime($data));
            }
        }
        return $data;
    }

    static public function hora($hora) {
        $hora = substr($hora,0,-3);
        return $hora;
    }

    static public function valor($valor,$gravar = false) {
        if($gravar) {
            $valor = str_replace(',','.',str_replace(['.','R$',' '],'',$valor));
        } else {
            $valor = number_format($valor,2,',','.');
        }
        return $valor;
    }

    static public function cleanToUrl($valor)
    {
        return mb_strtolower(str_replace(" ","+",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($valor)))));
    }

    static public function trataMail($param)
    {
        switch($param['tipo']) {
            case 'forgot':
                $mensagem  = '<a href="'. URL_PUBLIC .'/remember/'.$param['session'].'">Clique aqui para redefinr</a>';
                self::mail('Redefinir Senha',$mensagem,[$param['email']]);
                break;
        }
    }

    static public function mail($assunto, $msg, $email = [], $cc = false, $anexo = false)
    {
      return false;
    }


    static public function array_to_object($array) {
      $obj = (object) [];
   
      if(count((array) $array)>0) {
        foreach ($array as $k => $v) {
          if (strlen($k)) {
              if (is_array($v)) {
                $obj->{$k} = self::array_to_object($v); //RECURSION
              } else {
                $obj->{$k} = $v;
              }
          }
        }
      }
      
      return $obj;
   }

   

   static public function masc_tel($tel) {
      $tam = strlen(preg_replace("/[^0-9]/", "", $tel));
      if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
          return substr($tel,0,$tam-13).substr($tel,$tam-9,0).substr($tel,$tam-9,5)."-".substr($tel,-4);
      }
      if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
          return substr($tel,0,$tam-12).substr($tel,$tam-8,0).substr($tel,$tam-8,4)."-".substr($tel,-4);
      }
      if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
          return "(".substr($tel,0,2).") ".substr($tel,2,5)."-".substr($tel,7,11);
      }
      if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
          return "(".substr($tel,0,2).") ".substr($tel,2,4)."-".substr($tel,6,10);
      }
      if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
          return substr($tel,0,$tam-4)."-".substr($tel,-4);
      }
  }

  static public function limpa_tel($tel) {
    $tam = strlen(preg_replace("/[^0-9]/", "", $tel));
    if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
        return $tel;
    }
    if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
        return $tel;
    }
    if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
        return "55".$tel;
    }
    if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
        return "55".$tel;
    }
    if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
        return $tel;
    }
  }



  static public function sendWhatsMsg($endpoint='send', $conexaoID, $variaveis=[]) {
    global $config, $vars, $banco;

    if(strlen($variaveis['receiver'])<10) {
        $variaveis['receiverID'] = $variaveis['receiver'];
        $numero = $banco->where("id", $variaveis['receiver'])->getValue("numeros", "numero");
        $variaveis['receiver'] = $numero;
    } else {
        $variaveis['receiverID'] = null;
    }

    // verifica se o numero tem 11 digitos e acrescena o 55
    if(strlen($variaveis['receiver'])==11 || strlen($variaveis['receiver'])==10) {
        $variaveis['receiver'] = '55'.$variaveis['receiver'];
    }

    if($config['environment'] == 'dev' || APP_ENV == 'dev') {

      logSalva('sendWhatsMsg', "DEV $endpoint #$conexaoID {$config['environment']} - variaveis ".json_encode($variaveis)." - vars: ".json_encode($vars));

      return ['status' => 'success', 'message' => 'Mensagem MOCADA DEV!'];

    } else {

    logSalva('sendWhatsMsg', "PROD endpoint#$endpoint conexaoID#$conexaoID environment#{$config['environment']} - variaveis ".json_encode($variaveis)." - vars: ".json_encode($vars));
    
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => URL_API."/chat/{$endpoint}?id={$conexaoID}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => http_build_query($variaveis),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      return json_decode($response, true);
    }
  }

}

