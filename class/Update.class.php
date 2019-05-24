<?php

/**
 * Descricao de Creat.class
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Update extends Conn {
    
    private $Tabela;
    private $Dados;
    private $Termos;
    private $Values;
    
    private $Resultado;
    private $Msg;
    
    private $Query;
    
    private $Conn;
    
    public function ExeUpdate($Tabela, array $Dados, $Termos, $ParseString) {
        $this->Tabela = (String) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (String) $Termos;
        
        parse_str($ParseString, $this->Values);
        $this->getIntrucao();
        $this->ExecutarInstrucao();
    }
    
    public function getResultado() {
        return $this->Resultado;
    }
    
    public function getMsg() {
        return $this->Msg;
    }
    
    public function getRowCount() {
        return $this->Query->rowCount;
    }
    
    public function Conexao() {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }
    
    private function getIntrucao() {
        foreach ($this->Dados as $key => $Value) {
            $Values[] = $key . ' = :' . $key;                    
        }
        $Values = implode(', ', $Values);
        $this->Query = "UPDATE {$this->Tabela} SET {$Values} {$this->Termos}";
    }
    
    private function ExecutarInstrucao(){
        $this->Conexao();
        try {
            $this->Query->execute(array_merge($this->Dados, $this->Values));
            $this->Resultado = true;
            $this->Msg = "<b>Alterado com sucesso</b>";
        } catch (Exception $e) {
            $this->Resultado = null;
            $this->Msg = "<b>Erro ao Alterar</b> {$e->getMessage()}";
        }
    }
}
