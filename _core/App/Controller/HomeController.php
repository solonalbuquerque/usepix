<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Home;

class HomeController
{

    public function vazio()
    {
        Helper::view('default/home/index');/*
        if(ENVIRONMENT=="dev") {
            Helper::view('default/home/index');
        } else {
            Helper::view('default/home/index-temp');
        }*/
    }

    public function suporte()
    {
        Helper::view('default/home/suporte');
    }

    public function gerarQrcode()
    {
        Helper::view('default/home/gerarQrcode');
    }

    public function privacidade()
    {
        Helper::view('default/home/privacidade');
    }

    public function desenvolvedores()
    {
        Helper::view('default/home/desenvolvedores');
    }

    public function termos()
    {
        Helper::view('default/home/termos');
    }

    public function tarifas()
    {
        Helper::view('default/home/tarifas');
    }
    
/*
    public function erro($param)
    {
        $response['mensagem'] = ($param[0]) ? base64_decode($param[0]) : 'Página não encontrada';
        
        Helper::view('admin/home/erro', $response);
    }

    public function uploadIMG()
    {
        $model = New Home();

        $id = $model->create('chatbot', $_POST);
        if($id) {
            $caminho = 'files/imagens/';
            $nome_pdf = $_POST['id_conexao'].'_'.time();
            $extensao = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

            if(Helper::upload($_FILES['img'],$nome_pdf,$caminho,$extensao)) {
                $model->save('chatbot',['id'=>$id,'caminho_img'=>$caminho.$nome_pdf.'.'.$extensao]);
            }
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function updateIMG()
    {
        $model = New Home();
        if($model->save('chatbot',$_POST,['img'])) {
            $caminho = 'files/imagens/';
            $nome_img = $_POST['id_conexao'].'_'.time();
            if(Helper::upload(@$_FILES['img'],$nome_img,$caminho, pathinfo(@$_FILES['img']['name'], PATHINFO_EXTENSION))) {
                $model->save('chatbot',['id'=>$_POST['id'],'caminho_img'=>$caminho.$nome_img.'.'.pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION)]);
            }

            echo json_encode(array('status'=>'sucesso'));
        }
    }

    public function uploadPdf()
    {
        $model = New Home();

        $id = $model->create('chatbot', $_POST);
        if($id) {
            $caminho = 'files/pdf/';
            $nome_pdf = $_POST['id_conexao'].'_'.time();
            $extensao = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);

            if(Helper::upload($_FILES['pdf'],$nome_pdf,$caminho,$extensao)) {
                $model->save('chatbot',['id'=>$id,'caminho_pdf'=>$caminho.$nome_pdf.'.'.$extensao]);
            }
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function updatePDF()
    {
        $model = New Home();
        if($model->save('chatbot',$_POST,['pdf'])) {
            $caminho = 'files/pdf/';
            $nome_pdf = $_POST['id_conexao'].'_'.time();
            $extensao = 'pdf';
            if(Helper::upload(@$_FILES['pdf'],$nome_pdf,$caminho,$extensao)) {
                $model->save('chatbot',['id'=>$_POST['id'],'caminho_pdf'=>$caminho.$nome_pdf.'.'.$extensao]);
            }

            echo json_encode(array('status'=>'sucesso'));
        }
    }
	
	// sendmsg
	
	public function uploadVideo()
    {
        $model = New Home();

        $id = $model->create('chatbot', $_POST);
        if($id) {
            $caminho = 'files/video/';
			$nome_video = $_POST['id_conexao'].'_'.time();
            $extensao = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);

            if(Helper::upload($_FILES['video'],$nome_video,$caminho,$extensao)) {
                $model->save('chatbot',['id'=>$id,'caminho_video'=>$caminho.$nome_video.'.'.$extensao]);
            }
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }
	
	// fim sendmsg


     public function restApi()
    {
        Helper::view('admin/home/rest-api');
    }

    public function admin()
    {
        Helper::view('admin/home/index');
    }

    public function client()
    {
        Helper::view('admin/home/index');
    }

    public function loginDireto($param) {
        $codigoCliente = $param[0];
        $model = New Home();
        $dados = $model->find('user', $codigoCliente);
        if(!$dados) {
            $response['mensagem'] = 'Cliente não encontrado';
            Helper::view('admin/home/erro', $response);
        } else {
            die(print_r($dados));
        }
    }
*/
}
