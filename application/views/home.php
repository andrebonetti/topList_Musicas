<section class="home my-content">
    <div class="myContainer">
        <h1>Top List</h1>
        
        <table class="table">
        
            <tr>
                <th>Ranking</th>
                <th>Artista</th>
                <th>Titulo</th>
                <th>Play</th>
                <th>Pontuação</th>
            </tr>
            
            
            <?php 
            $cont = $start + 1;
            foreach($musicas as $musica){ ?>
                <tr>
                    <td><?=$cont?></td>
                    <td><?=$musica["Artista"]?></td>
                    <td><?=$musica["Titulo"]?></td>
                    <td>
                        <audio controls>
                          <source src="<?=base_url("musicas/Listadas/".$musica["Arquivo"])?>" type="audio/mpeg">
                          <source src="<?=$musica["Arquivo"]?>" type="audio/ogg">
                        </audio>
                    </td>
                    <td><?=$musica["Pontuacao"]?></td>
                </tr>
                 
            <?php $cont++; } ?>
                    
        </table>
        
            <!-- Pagination -->
            <ul class="pagination">
            	<?php for($i = 1;$i <= $numero_paginas;$i++){?>
            	   <li class="<?=active_class($i, $atual_page)?>"><?=anchor("home/index/".$i,$i)?></li>
		    	<?php } ?>            	
        	</ul>
    </div>
</section>