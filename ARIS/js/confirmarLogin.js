function confirmarDelete(id){
  $confirmar = window.confirm("Aperte em 'ok' para excluir este dado");
  if($confirmar == true ){
      window.location.href='classes/medico/deletarMedicoLogin.php?id='+id;            
  }else if ($confirmar == false ){
  }
}