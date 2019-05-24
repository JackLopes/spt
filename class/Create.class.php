<?php

/**
 * Descricao de Creat.class
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Create extends Conn{
    private $Tabela;    
    private $Dados;
    private $Resultado;
    private $Msg;
    private $Query;
    private $Conn;
    
    public function ExeCreate($Tabela, array $Dados) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;  
        
        $this->getInstrucao();
        $this->ExecutarInstrucao();
    }
    
    public function getResultado() {
        return $this->Resultado;
    }
    
    public function getMsg() {
        return $this->Msg;
    }
    
    private function Conexao() {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }
    
    private function getInstrucao() {
        $Keys = implode(', ', array_keys($this->Dados));
        $Values = ':' . implode(', :', array_keys($this->Dados));
        
        $this->Query = "INSERT INTO {$this->Tabela} ({$Keys}) VALUES ({$Values})";
    }
    
    private function ExecutarInstrucao() {
        $this->Conexao();
        try {
            $this->Query->execute($this->Dados);
            $this->Resultado = $this->Conn->lastInsertId();
        } catch (Exception $e) {
            $this->Resultado = null;
            $this->Msg = "<b>Erro ao Cadastrar: </b> {$e->getMessage()}";
        }
    }
    
}
