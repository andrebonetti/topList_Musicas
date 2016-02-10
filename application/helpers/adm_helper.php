<?php

	function login_result($result){
       $ci = get_instance();    
        
	   if (!empty ($result)){
           $ci->session->set_userdata("usuario",$result['usuario']);			
           redirect("adm/home");
        }
        else{
            $ci->session->set_flashdata('msg-error',"Usuário e senha inválidos");
            redirect("home");
        }
	}
	
	function valida_usuario(){
		$ci = get_instance();
		$usuario = $ci->session->userdata('usuario');
		if(empty($usuario)){
			$ci->session->set_flashdata('msg-error','Efetue o login para ter acesso a essa página.');
			redirect("home");
		}
	}