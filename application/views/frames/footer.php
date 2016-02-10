         <footer>
             <div class="myContainer">
             </div>    
        </footer>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  
                        <h4 class="modal-title" id="exampleModalLabel">Acesso a Área restrita</h4>   
                        
                        <p class="alert alert-info">Login: veteranos / Senha: unicid</p>
                    </div>

                    <?= form_open("adm/signin")?>
                        <div class="modal-body">

                                <label>Login:</label>
                                <input type="text" class="form-control" name="usuario" required autofocus>

                                <label>Senha:</label>
                                <input type="password" class="form-control" name="senha" required><br>

                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Entrar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    <?= form_close()?>

                </div>
            </div>
        </div>
        
        <script src="<?=base_url("js/my_script-home.js")?>"></script>
        
    </body>
</html>    
