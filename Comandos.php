<?php

class Comandos {
    public $mysqli;
	
	function __construct(){
		$this->mysqli = new mysqli("localhost","root2",'usbw',"",3306);
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
	}

    function criaTabela(){
        $comando = "USE test;";
        $this->mysqli->query($comando);
        //$comando = "DROP table cnpjs2;";
        //$mysqli->query($comando);
        $comando ="CREATE TABLE if not exists `cnpjs2` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `c1` varchar(255) NOT NULL,
            `c2` varchar(255),
            `c3` varchar(255),
            `c4` varchar(255),
            `c5` varchar(255),
            `c6` varchar(255),
            `c7` varchar(255),
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
        $this->mysqli->query($comando);
    }
    function processa(){
        $conta=1;
        $folderName = "pasta/";
        $conteudo = dir($folderName);
        echo "Lista de Arquivos do diretório '<strong>".$folderName."</strong>':<br />";
        while($arquivo = $conteudo -> read()){
            //pular . e .. e .DS_STORE
            if (substr($arquivo,0,1)!="."){
                echo $arquivo." ". filesize($folderName.$arquivo). "<br>";
                $arq=fopen($folderName.$arquivo,"r");
                $linha=fgets($arq);
                while($linha){
                    $linhaLimpa = str_replace("'","",$linha);//tirar o '
                    $linhaLimpa2 = str_replace("\"","",$linhaLimpa);//tirar o "
                    $linhaLimpa2 = str_replace("\\","",$linhaLimpa);//tirar o "
                    $linhaCompleta=explode(";",$linhaLimpa2);
                    $vQuery="INSERT INTO cnpjs2(".
                    "c1,".
                    "c2,".
                    "c3,".
                    "c4,".
                    "c5,".
                    "c6,".
                    "c7".
                    ") VALUES ('".
                    $linhaCompleta[0]."', '".
                    mb_convert_encoding($linhaCompleta[1], 'UTF-8', mb_list_encodings())."', '".
                    mb_convert_encoding($linhaCompleta[2], 'UTF-8', mb_list_encodings())."', '".
                    $linhaCompleta[3]."', '".
                    $linhaCompleta[4]."', '".
                    $linhaCompleta[5]."', '".
                    mb_convert_encoding($linhaCompleta[6], 'UTF-8', mb_list_encodings())."' );";
                    $this->mysqli->query($vQuery);
                    if ($this->mysqli->error) {
                        die($this->mysqli->error);
                    }
                    $linha=fgets($arq);
                    $conta++;
                } 
                //terminamos de ler então precisa fechar o arquivo
                fclose($arq);
            }
        }
        $conteudo -> close();
        echo "<hr>";
        echo "Total de linhas ".$conta;
    }
    
}