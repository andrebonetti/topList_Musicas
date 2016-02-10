<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Votacao extends CI_Controller{
        
		public function index($order = null){
            
        if($order == null){$musicas =  $this->crud_model->get_desc("Pontuacao");}    
        else{$musicas =  $this->crud_model->get($order); }    
            
        $todas_musicas  =  $this->crud_model->get_desc("Id");  
        $vertentes      =  $this->crud_model->get_vertentes();    
        $todas_votos    =  $this->crud_model->get_votos();
            
        $hasCombate = false;
        $contagem = 0;    
        foreach($todas_musicas as $musica) 
        {
            if($musica["Id"] != count($todas_musicas))
            {
               $contagem = $contagem +  $musica["Id"];
            }
        }
            
            if(count($todas_votos) < $contagem){
                $hasCombate = true;
            }
        
        if($hasCombate == true){            
            $musica1 =  $this->crud_model->get_musica1();     
            $musica2 =  $this->crud_model->get_musica2($musica1["Id"]); 
            
            $validacao              = 0;
            $valida_votacao1        = $this->crud_model->valida_votacao1($musica1["Arquivo"],$musica2["Arquivo"]);    
            $valida_votacao2        = $this->crud_model->valida_votacao2($musica1["Arquivo"],$musica2["Arquivo"]); 
            $lista_vitoriasMusica1  = $this->crud_model->lista_vitorias($musica1["Arquivo"]); 
            $lista_vitoriasMusica2  = $this->crud_model->lista_vitorias($musica2["Arquivo"]);
            $lista_derrotasMusica1  = $this->crud_model->lista_derrotas($musica1["Arquivo"]); 
            $lista_derrotasMusica2  = $this->crud_model->lista_derrotas($musica2["Arquivo"]);
       
            if(( (empty($valida_votacao1)) && (empty($valida_votacao2)) )){       
                $validacao = 1;                            
            }
            else{    
                while( (!empty($valida_votacao1)) or (!empty($valida_votacao2)) )
                {
                    $musica1 =  $this->crud_model->get_musica1();     
                    $musica2 =  $this->crud_model->get_musica2($musica1["Id"]); 
                 
                    $valida_votacao1 = $this->crud_model->valida_votacao1($musica1["Arquivo"],$musica2["Arquivo"]);    
                    $valida_votacao2 = $this->crud_model->valida_votacao2($musica1["Arquivo"],$musica2["Arquivo"]); 

                    if(( (empty($valida_votacao1)) && (empty($valida_votacao2)) )){                        
                        $validacao = 1;  
                        
                        $lista_vitoriasMusica1  = $this->crud_model->lista_vitorias($musica1["Arquivo"]); 
                        $lista_vitoriasMusica2  = $this->crud_model->lista_vitorias($musica2["Arquivo"]);
                        $lista_derrotasMusica1  = $this->crud_model->lista_derrotas($musica1["Arquivo"]); 
                        $lista_derrotasMusica2  = $this->crud_model->lista_derrotas($musica2["Arquivo"]);
                    }
                    
                    if($validacao == 1){break;}
                 }
            }
            
            $destaques_vitoria1 = array();
            
            foreach($lista_vitoriasMusica1 as $vitoria)
            {
                foreach($lista_derrotasMusica2 as $derrota)
                {
                    //echo "Vitoria 1 = ".$vitoria["musica2"] ." derrota 2 = ".$derrota["musica1"]." <br>" ;
                    if($vitoria["musica2"] == $derrota["musica1"]) 
                    {
                        array_push($destaques_vitoria1,$vitoria["musica2"]);
                    }
                }
            }
            
            $destaques_vitoria2 = array();
            
            foreach($lista_vitoriasMusica2 as $vitoria)
            {
                foreach($lista_derrotasMusica1 as $derrota)
                {
                    //echo "Vitoria 2 = ".$vitoria["musica2"] ." derrota 1 = ".$derrota["musica1"]." <br>" ;
                    if($vitoria["musica2"] == $derrota["musica1"])
                    {
                        array_push($destaques_vitoria2,$vitoria["musica2"]);
                    }
                }
            }
            
            if((count($destaques_vitoria1) > 0)&&(count($destaques_vitoria2) == 0)){
                echo "Vitoria Automatica Musica 1";
                $this->votar($musica1["Id"],$musica2["Id"]);
            }
            if((count($destaques_vitoria2) > 0)&&(count($destaques_vitoria1) == 0)){
                echo "Vitoria Automatica Musica 2";
                $this->votar($musica2["Id"],$musica1["Id"]);
            }
            if((count($destaques_vitoria1) > 0)&&(count($destaques_vitoria2) > 0)){
                echo "Erro Votacao";
            }

            if($validacao == 1){ 
                
                /*--------------------------CONTENT----------------------------------*/
                $content = array("atual_page"       => "votacao"
                                ,"musica1"          => $musica1
                                ,"musica2"          => $musica2
                                ,"musicas"          => $musicas
                                ,"ja_votados"       => count($todas_votos)
                                ,"total_combates"   => $contagem
                                ,"vertentes"        => $vertentes
                                ,"derrotas_musica1" => $lista_derrotasMusica1
                                ,"derrotas_musica2" => $lista_derrotasMusica2
                                ,"vitorias_musica1" => $lista_vitoriasMusica1
                                ,"vitorias_musica2" => $lista_vitoriasMusica2
                                ,"destaques_vitoria1" => $destaques_vitoria1
                                ,"destaques_vitoria2" => $destaques_vitoria2);

                /*VIEW*/$this->load->template("votacao.php",$content);

            }
        }
        else{
            redirect("");
        }
        
            
	   }
        
        public function votar($Id1,$Id2){
            
            $musica_vencedora = $this->crud_model->get_where($Id1);   
            $musica_derrotada = $this->crud_model->get_where($Id2); 
            
            $pontuacao = $musica_vencedora["Pontuacao"] + 1;
            $contagem  = $musica_vencedora["NumeroCombates"] + 1;
            
            $data["Pontuacao"] = $pontuacao;
            $data["NumeroCombates"] = $contagem;    
            $this->crud_model->update($Id1,$data);
            
            $contagem2  = $musica_derrotada["NumeroCombates"] + 1;
            
            $data2["NumeroCombates"] = $contagem2;
            $this->crud_model->update($Id2,$data2);
            
            $votadas["Musica1"] = $musica_vencedora["Arquivo"];
            $votadas["Musica2"] = $musica_derrotada["Arquivo"];
            
            $this->crud_model->insert($votadas);
            
            redirect(base_url("index.php/votacao/index"));
        }
        
    }