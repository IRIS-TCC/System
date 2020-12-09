<?php

    require_once ('../conexao.php');

    $apresentar = '';

            $sql = "SELECT (nomeMedico), (crmMedico), (nomePaciente) AS 'Nome', (rgPaciente), (dataDeclaracao), (horaEntradaDeclaracao) as 'horaEntrada', (horaSaidaDeclaracao)  as 'horaSaida'
            FROM tbdeclaracao 
            INNER JOIN tbPaciente ON (tbPaciente.codPaciente = tbDeclaracao.codPaciente) 
            INNER JOIN tbMedico ON (tbMedico.codMedico = tbDeclaracao.codMedico) 
            WHERE tbpaciente.codPaciente = '8' LIMIT 1";

            $result = mysqli_query($connect, $sql);
            while ($dados = mysqli_fetch_assoc($result)){
                $horaEntrada = date("H:i", strtotime($dados['horaEntrada']));
                $horaSaida = date("H:i", strtotime($dados['horaSaida']));
                $data = date("d/m/Y", strtotime($dados['dataDeclaracao']));

                $apresentar .= '    
                <p style="margin-top: 10%; font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif; font-size: 19px; text-align: justify;">Declaro para os devidos fins que o(a) Sr(a) '.' Paciente: '.$dados['Nome'].', Portador do RG '.$dados['rgPaciente'].' foi atendido nesta Unidade de Saúde, no dia '.$data.' sob meus cuidados profissionais, durante o período das '.$horaEntrada.' ás '.$horaSaida.'.'."</p>";
                $apresentar .= '
                <p style="margin-top: 10%;">'.$dados['nomeMedico'].'</p>
                <p style="margin-top: 1%;">CRM '.$dados['crmMedico'].'</p>';
        }
        $apresentar .= '
        <div style="width: 40%; margin-left: 30%; margin-top: 15%;">
        <hr>
        <h4 style="text-align: center; font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;">Assinatura Médico</h4>
        </div>
        <img src="img/logoAris.jpg" style="width: 15%; margin-top: 5%; float:right;">

</body>

</html>';



	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF('isRemoteEnabled', TRUE);


	// Carrega seu HTML
    $dompdf->load_html('
    <html>

    <head>
        <meta charset="utf-8">
        <link rel="icon" href="img/iconeAris.jpg">
        <title>DECLARAÇÃO</title>
    </head>
    
    
    <body style="width: 100%;">
        <img src="img/logo-prefeitura.png" style="width: 35%; margin-bottom: 7%;">
        <img src="img/logo-sus.png" style="width: 20%; float: right; margin-bottom: 5%; margin-top: 2%;">
        <h1 style="text-align: center; 
        font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif; color: black;">
            DECLARAÇÃO</h1>
			'. $apresentar .'
		');

	
	$dompdf->setPaper('A4', 'portrait');	
		
	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"certificado.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>