<!DOCTYPE html>
<html lang="pt-br">
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" type="image/x-icon" href="<" title="" >
        <title> Área Administrativa </title>
                      
        <link rel="stylesheet" type="text/css" href="<?=base_url("css/bootstrap.css")?>">  
        <link rel="stylesheet" type="text/css" href="<?=base_url("css/style.css")?>">    
        <link rel="stylesheet/less" href="<?=base_url("less/style.less")?>">    
        
        <script src="<?=base_url("js/jquery-2.1.3.min.js")?>"></script>
        <script src="<?=base_url("js/bootstrap.js")?>"></script>
        <script src="<?=base_url("js/less.js")?>"></script>
		
	</head>

	<body>
        
        <header>
           <div class="myContainer">
    
                <img src="<?= base_url("img/logo.png")?>">
               
                <?=anchor("adm/signout","Sair",array("class"=>"signout"))?>

            </div>    
        </header> 
