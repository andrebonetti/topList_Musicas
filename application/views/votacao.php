<section class="home my-content">
    <div class="myContainer">
        <h1>Votacao (<?=$total_combates?>/<?=$ja_votados?>)</h1>
        
        <table class="table">
        
            <tr>
                <th>Musica 1</th>
                <th>Musica 2</th>
            </tr>
            
            <tr>
                <td style="width: 50%;">
                    <audio style="width: 100%;" controls >
                        <source src="<?=base_url("musicas/Listadas/".$musica1["Arquivo"])?>" type="audio/mpeg">
                        <source src="<?=base_url("musicas/Listadas/".$musica1["Arquivo"])?>" type="audio/ogg">
                    </audio>
                </td>  
                
                <td style="width: 50%;">
                    <audio style="width: 100%;" controls>
                        <source src="<?=base_url("musicas/Listadas/".$musica2["Arquivo"])?>" type="audio/mpeg">
                        <source src="<?=base_url("musicas/Listadas/".$musica2["Arquivo"])?>" type="audio/ogg">
                    </audio>
                </td>                   
            </tr>
            
            <tr>
                <td>
                    <?=anchor("votacao/votar/".$musica1["Id"]."/".$musica2["Id"],$musica1["Artista"]." - ".$musica1["Titulo"]." [ ".$musica1["NomeVertente"]." ]",array("class"=>"btn btn-default"))?>
                </td>  
                
                <td>
                    <?=anchor("votacao/votar/".$musica2["Id"]."/".$musica1["Id"],$musica2["Artista"]." - ".$musica2["Titulo"]." [ ".$musica2["NomeVertente"]." ]",array("class"=>"btn btn-default"))?>
                </td>                   
            </tr>  
            <tr>
                <td>
                    <?php 
                        $numeroDerrotas_musica1 = count($derrotas_musica1);
                        $numeroVitorias_musica1 = count($vitorias_musica1);
                        
                        if($musica1["NumeroCombates"] > 0){
                            $porcentagemVitorias_musica1 = $numeroVitorias_musica1 * 100 / $musica1["NumeroCombates"];
                        }
                        else{
                            $porcentagemVitorias_musica1 = "--";
                        }
                    ?>
                    <h5>Histórico Combates (<?=$musica1["NumeroCombates"]?>) [ <?=$porcentagemVitorias_musica1?>% ]</h5>
                    
                    <?php foreach($destaques_vitoria1 as $musica){?>
                        <p class="alert-warning" style="height: 35px;"><?=$musica?></p>
                        <audio style="width: 100%;" controls >
                            <source src="<?=base_url("musicas/Listadas/".$musica)?>" type="audio/mpeg">
                            <source src="<?=base_url("musicas/Listadas/".$musica)?>" type="audio/ogg">
                        </audio>
                    <?php } ?>
                    
                    <?php foreach($vitorias_musica1 as $musica){?>
                        <p class="alert-success" style="height: 35px;"><?= $musica["musica1"]?> ------>  <?= $musica["musica2"]?></p>
                    <?php } ?>
                    <?php foreach($derrotas_musica1 as $musica){?>
                        <p class="alert-danger" style="height: 35px;"><?= $musica["musica2"]?> <-----  <?= $musica["musica1"]?></p>
                    <?php } ?>
                </td>
                <td>
                    <?php 
                        $numeroDerrotas_musica2 = count($derrotas_musica2);
                        $numeroVitorias_musica2 = count($vitorias_musica2);
                        
                        if($musica2["NumeroCombates"] > 0){
                            $porcentagemVitorias_musica2 = $numeroVitorias_musica2 * 100 / $musica2["NumeroCombates"];
                        }
                        else{
                            $porcentagemVitorias_musica2 = "--";
                        }
                    ?>
                    <h5>Histórico Combates (<?=$musica2["NumeroCombates"]?>) [ <?=$porcentagemVitorias_musica2?>% ]</h5>
                                
                    <?php foreach($destaques_vitoria2 as $musica){?>
                        <p class="alert-warning" style="height: 35px;"><?=$musica?></p>
                        <audio style="width: 100%;" controls >
                            <source src="<?=base_url("musicas/Listadas/".$musica)?>" type="audio/mpeg">
                            <source src="<?=base_url("musicas/Listadas/".$musica)?>" type="audio/ogg">
                        </audio>
                        
                    <?php } ?>
                    
                    <?php foreach($vitorias_musica2 as $musica){?>
                        <p class="alert-success" style="height: 35px;" ><?= $musica["musica1"]?> ------>  <?= $musica["musica2"]?></p>
                    <?php } ?>
                    <?php foreach($derrotas_musica2 as $musica){?>
                    <p class="alert-danger" style="height: 35px;"><?= $musica["musica2"]?> <-----  <?= $musica["musica1"]?></p>
                    <?php } ?>
                </td>
            </tr>
            
        </table>
        
    </div>
</section>