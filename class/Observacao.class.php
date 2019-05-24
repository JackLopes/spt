<?php

/**
 * Descricao de Creat.class
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Observacao {

    private $Dados;
    private $Msg;
    private $Resultado;

    const Entity = 'aceite';

    public function ExeCreate(array $Dados) {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado == true):
            $this->Cadastrar();
        endif;
    }

    public function getResultado() {
        return $this->Resultado;
    }

    public function getMsg() {
        return $this->Msg;
    }

    private function validarDados() {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)):
            $this->Resultado = false;
            $this->Msg = "<p style='color:red'></b>Para cadastrar a observacao, preencha todos os campos!</p>";
        else:

            $this->Resultado = true;
        endif;
    }

    private function Cadastrar() {
        $Create = new Create();
        $Create->ExeCreate(self::Entity, $this->Dados);
        if ($Create->getResultado()):
            $this->Resultado = $Create->getResultado();
            $this->Msg = "<p style='color:green'>Observação cadastrada com sucesso!</p>";
        endif;
    }

}
