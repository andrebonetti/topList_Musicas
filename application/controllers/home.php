<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Home extends CI_Controller{
        
		public function index($pag = 1,$order = null){	
            
        if($order == null){
            $todas_musicas =  $this->crud_model->get_desc("Pontuacao");                        
        }    
        else{
            $todas_musicas =  $this->crud_model->get($order); 
        }
                    
        /*------PAGINACAO-------*/
		$limite 			= '10';
		$start				= ($pag*$limite)-$limite;
		$finish				= $pag*$limite;
		$num_produtos 		= count($todas_musicas);	
		$num_pages 			= ($num_produtos/$limite);
        
        $musicas = array();    
		for($n = $start; $n < $finish; $n++){
		if(!empty($todas_musicas[$n])){array_push($musicas, $todas_musicas[$n]);}}    
            
		/*--------------------------CONTENT----------------------------------*/
		$content = array("atual_page"       => $pag
                        ,"musicas"          => $musicas
                        ,"start"            => $start 
                        ,"numero_paginas"   => $num_pages);
		
		/*VIEW*/$this->load->template("home.php",$content);
            
	   }
    }