<?php
	class crud_model extends CI_Model {
        
        /* SELECT */
		function get($order){
            $this->db->order_by($order,"asc");
            $this->db->join('vertentes', 'vertentes.IdVertente = lista_musicas.Vertente');
			return $this->db->get("lista_musicas")->result_array();	
		}
        
        /* SELECT */
		function get_vertentes(){
            $this->db->order_by("NomeVertente asc");
			return $this->db->get("vertentes")->result_array();	
		}
        
        function get_votos(){
			return $this->db->get("votacao")->result_array();	
		}
        
        function get_desc($order){
            $this->db->order_by("{$order} desc, NumeroCombates desc"); 
			return $this->db->get("lista_musicas")->result_array();	
		}
        
        function get_where($Id){
			$this->db->where("Id",$Id);
            $this->db->join('vertentes', 'vertentes.IdVertente = lista_musicas.Vertente');
			return $this->db->get("lista_musicas")->row_array();	
		}
        
        function get_where_arquivo($Arquivo){
			$this->db->where("Arquivo",$Arquivo);
            $this->db->join('vertentes', 'vertentes.IdVertente = lista_musicas.Vertente');
			return $this->db->get("lista_musicas")->row_array();	
		}
        
        /*CRIA VOTACAO*/
        function get_musica1(){
            $this->db->join('vertentes', 'vertentes.IdVertente = lista_musicas.Vertente');
			$this->db->order_by("Id","random");    
			return $this->db->get("lista_musicas")->row_array();	
		}
        
        function get_musica2($Id){
            $this->db->join('vertentes', 'vertentes.IdVertente = lista_musicas.Vertente');
            $this->db->where("Id !=",$Id);
			$this->db->order_by("Id","random");         
			return $this->db->get("lista_musicas")->row_array();	
		}
        
        /*VALIDA VOTACAO*/
        function valida_votacao1($musica1,$musica2){
            $this->db->where("musica1",$musica1);
            $this->db->where("musica2",$musica2);
            $this->db->where("IsVotado",1);
			return $this->db->get("votacao")->result_array();	
		}
        
        /*VALIDA VOTACAO*/
        function valida_votacao2($musica1,$musica2){
            $this->db->where("musica1",$musica2);
            $this->db->where("musica2",$musica1);
            $this->db->where("IsVotado",1);
			return $this->db->get("votacao")->result_array();	
		}
        
        function buscaId_votacao1($musica1,$musica2){
            $this->db->where("musica1",$musica1);
            $this->db->where("musica2",$musica2);
            $this->db->where("IsVotado",0);
			return $this->db->get("votacao")->row_array();	
		}
        
        function buscaId_votacao2($musica1,$musica2){
            $this->db->where("musica1",$musica2);
            $this->db->where("musica2",$musica1);
            $this->db->where("IsVotado",0);
			return $this->db->get("votacao")->row_array();	
		}
        
        function valida_Combate1($musica1,$musica2){
            $this->db->where("musica1",$musica1);
            $this->db->where("musica2",$musica2);
			return $this->db->get("votacao")->row_array();	
		}
        function valida_Combate2($musica1,$musica2){
            $this->db->where("musica1",$musica2);
            $this->db->where("musica2",$musica1);
			return $this->db->get("votacao")->row_array();	
		}
        
        function valida_votacao3($musica1){
            $this->db->where("IsVotado",1);
            $this->db->where("musica1",$musica1);
            $this->db->or_where("musica2",$musica1);
			return $this->db->get("votacao")->result_array();	
		}
        
        function lista_derrotas($musica){
            $this->db->where("musica2",$musica);
            $this->db->where("IsVotado",1);
			return $this->db->get("votacao")->result_array();	
		}
        
        function lista_vitorias($musica){
            $this->db->where("musica1",$musica);
            $this->db->where("IsVotado",1);
			return $this->db->get("votacao")->result_array();	
		} 
        
        function nao_votados(){
            $this->db->where("IsVotado",0);
            $this->db->order_by("Id","random");
			return $this->db->get("votacao")->result_array();	
		} 
        
        function ja_votados(){
            $this->db->where("IsVotado",1);
            $this->db->order_by("Id","random");
			return $this->db->get("votacao")->result_array();	
		}  
        
        function total_combates(){
			return $this->db->get("votacao")->result_array();	
		}  
		
		/* INSERT */
		function insert($data){
			$this->db->insert("votacao", $data);
		}
		
		/* UPDATE */
		function update($Id,$data){
			$this->db->where 	('Id', $Id);
			$this->db->update	("lista_musicas",$data);
		}
        
        function update_votacao($Id,$data){
			$this->db->where 	('Id', $Id);
			$this->db->update	("votacao",$data);
		}
		
		/* DELETE */
		function delete($table,$id){
        	$this->db->delete($table, array('id' => $id));
		}
		
	}	