<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Votacao extends CI_Controller{
        
		public function index(){
            
        $nao_votados = $this->crud_model->nao_votados(); 
        $ja_votados = $this->crud_model->ja_votados(); 
        $total_combates = $this->crud_model->total_combates();    
        
        if(count($nao_votados) > 0){
            $musica1 =  $this->crud_model->get_where_arquivo($nao_votados[0]["musica1"]);
            $musica2 =  $this->crud_model->get_where_arquivo($nao_votados[0]["musica2"]);
            
            $lista_vitoriasMusica1  = $this->crud_model->lista_vitorias($musica1["Arquivo"]); 
            $lista_vitoriasMusica2  = $this->crud_model->lista_vitorias($musica2["Arquivo"]);
            $lista_derrotasMusica1  = $this->crud_model->lista_derrotas($musica1["Arquivo"]); 
            $lista_derrotasMusica2  = $this->crud_model->lista_derrotas($musica2["Arquivo"]);
            
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
                $this->votar($musica1["Id"],$musica2["Id"],1);
            }
            if((count($destaques_vitoria2) > 0)&&(count($destaques_vitoria1) == 0)){
                echo "Vitoria Automatica Musica 2";
                $this->votar($musica2["Id"],$musica1["Id"],1);
            }
            if((count($destaques_vitoria1) > 0)&&(count($destaques_vitoria2) > 0)){
                echo "Erro Votacao";
            }
            
            /*--------------------------CONTENT----------------------------------*/
            $content = array("atual_page"       => "votacao"
                                ,"musica1"          => $musica1
                                ,"musica2"          => $musica2
                                ,"ja_votados"       => count($ja_votados)
                                ,"nao_votados"      => count($nao_votados)
                                ,"total_combates"   => count($total_combates)
                                ,"vitorias_musica1" => $lista_vitoriasMusica1
                                ,"vitorias_musica2" => $lista_vitoriasMusica2 
                                ,"derrotas_musica1" => $lista_derrotasMusica1
                                ,"derrotas_musica2" => $lista_derrotasMusica2
                                ,"destaques_vitoria1" => $destaques_vitoria1
                                ,"destaques_vitoria2" => $destaques_vitoria2);

            /*VIEW*/$this->load->template("votacao.php",$content);
            
        }   
        
	   }
        
        public function votar($Id1,$Id2,$isAutomatico = 0){
            
            $this->output->enable_profiler(true);
            
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
            
            
            /* ----- INSERE COMBATE ----- */
            
            $data = date('Y-m-d'); 
            $hora = localtime();
            
            if($hora[8] < 10)
            {
                $horaA = "0".$hora[8];
            }
            else{$horaA = $hora[8];}
            
            if($hora[1] < 10)
            {
                $minuto = "0".$hora[1];
            }
            else{$minuto = $hora[1];}
            
            if($hora[0] < 10)
            {
                $segundo = "0".$hora[0];
            }
            else{$segundo = $hora[0];}
            
            $busca_Id1 = $this->crud_model->buscaId_votacao1($musica_vencedora["Arquivo"],$musica_derrotada["Arquivo"]); 
            var_dump($busca_Id1);
            if(!(empty($busca_Id1))){
                $IdVotacao = $busca_Id1["Id"];
            }
            else{
                $busca_Id2 = $this->crud_model->buscaId_votacao1($musica_vencedora["Arquivo"],$musica_derrotada["Arquivo"]); 
                var_dump($busca_Id2);
                $IdVotacao = $busca_Id2["Id"];
            }

            $dataEhora = $data." ".$horaA.":".$minuto.":".$segundo;
            $votadas["Musica1"] = $musica_vencedora["Arquivo"];
            $votadas["Musica2"] = $musica_derrotada["Arquivo"];
            $votadas["IsVotado"] = 1;
            $votadas["Data"] = $dataEhora;
            $votadas["IsAutomatico"] = $isAutomatico;
            
            $this->crud_model->update_votacao($IdVotacao,$votadas);
            
            redirect(base_url("index.php/votacao/index"));
        }
        
        public function crate_combate($id = 0){
            
            $this->output->enable_profiler(true);
        
            for($i=6;$i<=10;$i++){
                
                $musica1   =   $this->crud_model->get_where($i);

                $musicas =  $this->crud_model->get_desc("Pontuacao");

                foreach($musicas as $musica2){

                    if($musica1["Arquivo"] != $musica2["Arquivo"])
                    {
                        $valida_votacao1 = $this->crud_model->valida_Combate1($musica1["Arquivo"],$musica2["Arquivo"]);    
                        $valida_votacao2 = $this->crud_model->valida_Combate2($musica1["Arquivo"],$musica2["Arquivo"]); 

                        if(( (empty($valida_votacao1)) && (empty($valida_votacao2)) )){ 

                            $combate["Musica1"] = $musica1["Arquivo"];
                            $combate["Musica2"] = $musica2["Arquivo"];
                            $combate["IsVotado"] = 0;
                            $combate["Data"] = '0';
                            $combate["IsAutomatico"] = 0;

                            $this->crud_model->insert($combate);
                        }
                    }
                }
                
            }
            
            echo "pronto";
        }
    }