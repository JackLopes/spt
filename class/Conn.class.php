<?php

/**
 * Descricao de Conn.class
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
abstract class Conn {
    
    public static $Host = HOST;
    public static $User = USER;
    public static $Pass = PASS;
    public static $Dbname = DBNAME;    
    
    private static $Connect = null;
    
    //Conectar com o banco de dados utilizando o PDO
    private static function Conectar(){
        try{
            if(self::$Connect == null):
                self::$Connect = new PDO('mysql:host=' . self::$Host . ';dbname=' . self::$Dbname, self::$User, self::$Pass);
            endif;
        } catch (Exception $e) {
            echo 'Mensagem: ' . $e->getMessage();
            die;
        }
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }  
    
    protected static function getConn(){
        return self::Conectar();
    }
   
}
