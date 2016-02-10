<?php
	class Produtos_model extends CI_Model {
		
		function lista_tabelas($table){	
            $this->db->order_by("id_".$table);
			$this->db->where("id_".$table." !=","0");
			return $this->db->get($table)->result_array();		
		}
        
        function filtra_tabela($filtros,$distinct){
            
            /* SELECT */
            $this->db->from("produtos");
            
            /* FILTROS */
            if(!empty($filtros['categoria'])){
            $this->db->where("categoria",$filtros['categoria']);}
            if(!empty($filtros['marca'])){
            $this->db->where("marca",$filtros['marca']);}
            
            /* JOIN */
            $this->db->join("categoria", "categoria.id_categoria = produtos.categoria");
            $this->db->join("marca", "marca.id_marca = produtos.marca");
            $this->db->join("cor", "cor.id_cor = produtos.cor");
            $this->db->join("sub_categoria", "sub_categoria.id_sub_categoria = produtos.subcategoria");
            
            /* DISTINCT */
            if($distinct !== 0){
                $this->db->select("nome_".$distinct);
                $this->db->select($distinct);
                $this->db->distinct();
            }
            
            /* ORDER */
            $this->db->order_by("id");
            
            /* RESULT */
			return $this->db->get()->result_array();		
		}
        
        function titulo($type,$value){	
            $this->db->from($type);
            $this->db->where("id_".$type."",$value);
            return $this->db->get()->row_array();		
		}
        
        function atual_page($id,$table){	
            $this->db->where("id",$id);
			return $this->db->get($table)->row_array();		
		}
        
        function produto_descricao($id){
            
            /* SELECT */
            $this->db->from("produtos")->where("produtos.id",$id);
            
            /* JOIN */
            $this->db->join("categoria", "categoria.id_categoria = produtos.categoria");
            $this->db->join("marca", "marca.id_marca = produtos.marca");
            $this->db->join("cor", "cor.id_cor = produtos.cor");
            $this->db->join("sub_categoria", "sub_categoria.id_sub_categoria = produtos.subcategoria");
            
            /* RESULT */
			return $this->db->get()->row_array();		
		}
        
        function produtos_relacionados($produto){
            
            /* SELECT */
            $this->db->from("produtos");
            
            /* WHERE */
            $this->db->where("produtos.categoria",$produto["categoria"]);
            $this->db->where("produtos.marca",$produto["marca"]);
            
            /* LIMIT */
            $this->db->limit("8");
            
            /* JOIN */
            $this->db->join("categoria", "categoria.id_categoria = produtos.categoria");
            $this->db->join("marca", "marca.id_marca = produtos.marca");
            $this->db->join("cor", "cor.id_cor = produtos.cor");
            $this->db->join("sub_categoria", "sub_categoria.id_sub_categoria = produtos.subcategoria");
            
            /* RESULT */
			return $this->db->get()->result_array();		
		}
        
        function produtos_destaque($limit){
            
            /* SELECT */
            $this->db->from("produtos");
            
            /* ORDER */
            $this->db->order_by("destaque");
            
            /* LIMIT */
            $this->db->limit($limit);
            
            /* JOIN */
            $this->db->join("categoria", "categoria.id_categoria = produtos.categoria");
            $this->db->join("marca", "marca.id_marca = produtos.marca");
            $this->db->join("cor", "cor.id_cor = produtos.cor");
            $this->db->join("sub_categoria", "sub_categoria.id_sub_categoria = produtos.subcategoria");
            
            /* RESULT */
			return $this->db->get()->result_array();		
		}
        
        function produtos_novidade($limit){
            
            /* SELECT */
            $this->db->from("produtos");
            
            /* ORDER */
            $this->db->order_by("id","desc");
            
            /* LIMIT */
            $this->db->limit($limit);
            
            /* JOIN */
            $this->db->join("categoria", "categoria.id_categoria = produtos.categoria");
            $this->db->join("marca", "marca.id_marca = produtos.marca");
            $this->db->join("cor", "cor.id_cor = produtos.cor");
            $this->db->join("sub_categoria", "sub_categoria.id_sub_categoria = produtos.subcategoria");
            
            /* RESULT */
			return $this->db->get()->result_array();		
		}
	
	}	