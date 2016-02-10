<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Adm_crud extends CI_Controller{
        
        /*INSERT*/
        public function produto_insert(){
			
            /*VALIDACAO*/valida_usuario();
            
            /* ----- UPLOAD CONFIG -----*/
            $config['upload_path'] = './img/produtos';
            $config['allowed_types'] = 'gif|jpg|png';
           	$this->load->library('upload', $config);
            
            $data_add = array();
			
			$imagem_principal = $this->upload->do_upload("imagem_principal");
            if (!empty($imagem_principal)){
            	$data_upload = $this->upload->data(); 
                $data["imagem_principal"] = $data_upload["file_name"];
            }	
            
            $data["nome"]            = $this->input->post("nome");
			$data["categoria"]       = $this->input->post("categoria");
			$data["subcategoria"]    = $this->input->post("subcategoria");
			$data["marca"]           = $this->input->post("marca");
			$data["cor"]             = $this->input->post("cor");
			$data["preco"]           = $this->input->post("preco");
			
			/*BD-CRUD*/$this->crud_model->insert("produtos",$data);
            /*MSG*/$this->session->set_flashdata('msg-success',"Produto adicionado com sucesso!");
            /*REDIRECT*/redirect("adm/home");
		} 
        
        /*UPDATE*/
		public function produto_update($id){
			
            /*VALIDACAO*/valida_usuario();
            
			$data["nome"]            = $this->input->post("nome");
			$data["categoria"]       = $this->input->post("categoria");
			$data["subcategoria"]    = $this->input->post("subcategoria");
			$data["marca"]           = $this->input->post("marca");
			$data["cor"]             = $this->input->post("cor");
			$data["preco"]           = $this->input->post("preco");
			
			/*BD-CRUD*/$this->crud_model->update("produtos",$id,$data);
            /*MSG*/$this->session->set_flashdata('msg-success',"Produto alterado com sucesso!");
            /*REDIRECT*/redirect("adm/home");
			
		}
        
        /*DELETE*/
		public function produto_delete($id){
            
            /*VALIDACAO*/valida_usuario();
			/*BD-CRUD*/$this->crud_model->delete("produtos",$id);
            /*MSG*/$this->session->set_flashdata('msg-success',"Produto deletado com sucesso!");
			/*REDIRECT*/redirect("adm/home");
			
		}
        
    }