<?php
require_once 'Conexao.php';
class Prontuario{
    private $codProntuario;
    private $codPaciente;
    private $codMedico;
    private $observacaoProntuario;
//    
//
//
    public function getCodProntuario(){
        return $this->codProntuario;
    }
    public function getCodPaciente(){
        return $this->codPaciente;
    }
    public function getCodMedico(){
        return $this->codMedico;
    }
    public function getCodAnamnese(){
        return $this->codAnamnese;
    }
    public function getCodTriagem(){
        return $this->codTriagem;
    }
    public function getObservacaoProntuario(){
        return $this->observacaoProntuario;
    }
    public function getHoraEntradaProntuario(){
        return $this->horaEntradaProntuario;
    }
    public function getHoraSaidaProntuario(){
        return $this->horaSaidaProntuario;
    }
    public function getStatusProntuario(){
        return $this->statusProntuario;
    }
    public function getDataProntuario(){
        return $this->dataProntuario;
    }
    
//                                                                                                      
//                                                                                                                    
//                                                                                                                    
    public function setCodProntuario($cod){
        $this->codProntuario = $cod;
    }
    public function setCodPaciente($codP){
        $this->codPaciente = $codP;
    }
    public function setCodMedico($codM){
        $this->codMedico = $codM;
    }
    public function setCodAnamnese($codA){
        $this->codAnamnese = $codA;
    }
    public function setCodTriagem($codT){
        $this->codTriagem  = $codT;
    }
    public function setObservacaoProntuario($obs){
        $this->observacaoProntuario = $obs;
    }
    public function setHoraEntradaProntuario($horaEntrada){
        $this->horaEntradaProntuario  = $horaEntrada;
    }
    public function setHoraSaidaProntuario($horaSaida){
        $this->horaSaidaProntuario = $horaSaida;
    }
    public function setStatusProntuario($statusProntuario){
        $this->statusProntuario = $statusProntuario;
    }
    public function setDataProntuario($dataProntuario){
        $this->dataProntuario = $dataProntuario;
    }
// 
//
// 
    public function cadastrar($Prontuario){
        $conexao = Conexao::pegarConexao();
        $queryInsert = "INSERT INTO tbProntuario 
        (codPaciente
        ,codMedico
        ,horaEntradaProntuario
        ,statusProntuario
        ,dataProntuario
        )
        VALUES 
        ('".$Prontuario->getCodPaciente()."'
        ,'".$Prontuario->getCodMedico()."'
        ,'".$Prontuario->getHoraEntradaProntuario()."'
        ,'".$Prontuario->getStatusProntuario()."'
        ,'".$Prontuario->getDataProntuario()."'
        )";
        $conexao->exec($queryInsert);
    }
//
//
//
public function cadastrarAnamneseProntuario($Prontuario){
    $conexao = Conexao::pegarConexao();
    $queryUpdate = "update tbProntuario
                         set codAnamnese = '".$Prontuario->getCodAnamnese()."'
                          where codPaciente = ".$Prontuario->getCodPaciente() ;
    $conexao->exec($queryUpdate);
}
//
//
//
public function observacaoMedico($Prontuario){
    $conexao = Conexao::pegarConexao();
    $queryUpdate = "update tbProntuario
                         set observacaoProntuario = '".$Prontuario->getObservacaoProntuario()."'
                          where codProntuario = ".$Prontuario->getCodProntuario()." and
                           codMedico like '".$Prontuario->getCodMedico()."' 
                           and statusProntuario like 'consulta'" ;
    $conexao->exec($queryUpdate);
}
//
//
//    
public function cancelar($Prontuario){
    $conexao = Conexao::pegarConexao();
    $queryUpdate = "update tbProntuario
                         set statusProntuario = '".$Prontuario->getStatusProntuario()."'
                          where codProntuario = ".$Prontuario->getCodProntuario() ;
    $conexao->exec($queryUpdate);
}  
public function finalizar($Prontuario){
    $conexao = Conexao::pegarConexao();
    $queryUpdate = "update tbProntuario
        set statusProntuario = '".$Prontuario->getStatusProntuario()."'
        ,horaSaidaProntuario = '".$Prontuario->getHoraSaidaProntuario()."'
        where codProntuario = ".$Prontuario->getCodProntuario() ;
    $conexao->exec($queryUpdate);
}  
//
//
//
    public function listar($numCartaoSus,$codMedico){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT * FROM tbprontuario INNER JOIN tbpaciente on (tbprontuario.codPaciente = tbpaciente.codPaciente)
        where numCartaoSusPaciente like '$numCartaoSus' and codMedico like '".$codMedico."'  order by numCartaoSusPaciente";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;   
    }
    public function listarPaciente($Prontuario){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT * FROM tbprontuario INNER JOIN tbpaciente on 
        (tbprontuario.codPaciente = tbpaciente.codPaciente)
        where tbprontuario.codPaciente like '".$Prontuario->getCodPaciente()."' 
        and statusProntuario like 'consulta' and codMedico like '".$Prontuario->getCodMedico()."' 
        order by tbprontuario.codPaciente";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;   
    }
    public function listarProntuarioCartao($numCartaoSus,$codMedico){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT * FROM tbprontuario INNER JOIN tbpaciente on 
        (tbprontuario.codPaciente = tbpaciente.codPaciente) where numCartaoSusPaciente like '$numCartaoSus' 
        and codMedico like '".$codMedico."'
        and statusProntuario like 'consulta' 
        order by numCartaoSusPaciente";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;   
    }
    public function listarProntuarioConsulta($Prontuario){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT * FROM tbprontuario INNER JOIN tbpaciente on 
        (tbprontuario.codPaciente = tbpaciente.codPaciente) where statusProntuario like 'consulta' 
        and codMedico like '".$Prontuario->getCodMedico()."'
        order by numCartaoSusPaciente";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;   
    }
    public function listarHistoricoComCartao($numCartaoSus){
        $conexao = Conexao::pegarConexao();
        $querySelect = "SELECT * FROM tbprontuario INNER JOIN tbpaciente on
         (tbprontuario.codPaciente = tbpaciente.codPaciente)
        where numCartaoSusPaciente like '".$numCartaoSus."' and statusProntuario like 'finalizado'
         order by numCartaoSusPaciente";
        $resultado = $conexao->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;   
    }
//
//
//    
}