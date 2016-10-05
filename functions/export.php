<?php
function export()
{
	//processing form submitted
	setlocale (LC_TIME, 'fr_FR.utf8','fra');
	if (!isset($_POST['idformation'])) exit;

	//include PHPExcel library
	global $wpdb;
		$formation = array();
	try{

		$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
		$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
		$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
		$sql_formations.="WHERE {$wpdb->prefix}formation.id = '".$_POST['idformation']."';";


		$reponse_formation = $wpdb->get_results($sql_formations );

		foreach ($reponse_formation as $row)
		{
			$formation = $row;
		}
	}
	catch( Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}

	if( $_POST['inscrit'] == 0)
	{
		$title = "Preinscrits a la formation ".$formation->discipline." ". strftime("du %A %d %B %Y", strtotime($formation->date_debut ))." ".strftime("au %A %d %B %Y" , strtotime($formation->date_fin ))."  a ".$formation->lieu." (".$formation->departement .")";
	}else
	{
		$title = "Inscrits a la formation ".$formation->discipline." ". strftime("du %A %d %B %Y" , strtotime( $formation->date_debut ))." ".strftime("au %A %d %B %Y" , strtotime( $formation->date_fin ))."  a ".$formation->lieu." (".$formation->departement .")";
	}

	if(substr_count(__DIR__, 'functions') == 1)
	{
		$el =  substr(__DIR__, -10);
		$dir = str_replace($el,'',__DIR__);
	}


	include $dir.'/assets/PHPExcel/Classes/PHPExcel.php';
	include $dir.'/assets/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

	$workbook = new PHPExcel;

	$sheet = $workbook->getActiveSheet();

	$sheet->getColumnDimension('A')->setWidth(5);
	$sheet->getColumnDimension('B')->setWidth(5);
	$sheet->getColumnDimension('C')->setWidth(15);
	$sheet->getColumnDimension('D')->setWidth(15);
	$sheet->getColumnDimension('E')->setWidth(20);
	$sheet->getColumnDimension('F')->setWidth(20);
	$sheet->getColumnDimension('G')->setWidth(5);
	$sheet->getColumnDimension('H')->setWidth(30);
	$sheet->getColumnDimension('I')->setWidth(30);
	$sheet->getColumnDimension('J')->setWidth(7);
	$sheet->getColumnDimension('K')->setWidth(15);
	$sheet->getColumnDimension('L')->setWidth(15);
	$sheet->getColumnDimension('M')->setWidth(25);
	$sheet->getColumnDimension('N')->setWidth(25);
	$sheet->getColumnDimension('O')->setWidth(15);
	$sheet->getColumnDimension('P')->setWidth(15);
	$sheet->getColumnDimension('Q')->setWidth(15);
	$sheet->getColumnDimension('R')->setWidth(15);



	$sheet->getRowDimension(2)->setRowHeight(20);

	$styleA2 = $sheet->getStyle('A2');
	$styleA2->applyFromArray(array(
    'font'=>array(
	'bold'=>true,
	'size'=>18,
	'name'=>'Arial',
	'color'=>array(
	'rgb'=>'DD2C00'))
    ));

	$letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M");


	foreach ($letters as $lettre)
	{
		$style = $sheet->getStyle($lettre.'4');
		$style->applyFromArray(array(
		'font'=>array(
        'bold'=>true,
        'size'=>12,
        'name'=>'Arial',
        'color'=>array(
		'rgb'=>'304FFE'))
		));
	}



	$sheet->setCellValue('A4','ID');
	$sheet->setCellValue('B4','Titre');
	$sheet->setCellValue('C4','Nom');
	$sheet->setCellValue('D4','Prenom');
	$sheet->setCellValue('E4','Date Naissance');
	$sheet->setCellValue('F4','Lieu Naisance');
	$sheet->setCellValue('G4','Age');
	$sheet->setCellValue('H4','Adresse 1');
	$sheet->setCellValue('I4','Adresse 2');
	$sheet->setCellValue('J4','CP');
	$sheet->setCellValue('K4','Ville');
	$sheet->setCellValue('L4','Telephone');
	$sheet->setCellValue('M4','E-mail');
	$sheet->setCellValue('N4','Dîplome');
	$sheet->setCellValue('O4','N° Dîpl');
	$sheet->setCellValue('P4','Date Dîpl');
	$sheet->setCellValue('Q4','DR délivrance');
	$sheet->setCellValue('R4','Paiement');
	$sheet->setCellValue('A2', $title );

	$ligne= 5;
	try
	{
		if( $_POST['inscrit'] == 0)
		{
			$sql_preinscrits ="SELECT * FROM {$wpdb->prefix}preinscrits WHERE idformation = '".$_POST['idformation']."'AND estinscrit = '0';";
			$reponse = $wpdb->get_results($sql_preinscrits );
		}
		else
		{
			$sql_inscrits ="SELECT * FROM {$wpdb->prefix}preinscrits WHERE idformation = '".$_POST['idformation']."' AND estinscrit = '1';";
			$reponse = $wpdb->get_results($sql_inscrits );
		}

		if(sizeof($reponse)>=1)
		{
			foreach($reponse as $preinscrits)
			{
				if(age($preinscrits->date_naissance) <18)
				{
						$style = $sheet->getStyle("G".$ligne);
						$style->applyFromArray(array(
							'font'=>array(
							'bold'=>true,
							'size'=>12,
							'name'=>'Arial',
							'color'=>array(
								'rgb'=>'FF0000'))
						));
				}


				$sheet->setCellValue('A'.$ligne,$preinscrits->id);
				$sheet->setCellValue('B'.$ligne,$preinscrits->titre);
				$sheet->setCellValue('C'.$ligne,$preinscrits->nom);
				$sheet->setCellValue('D'.$ligne,$preinscrits->prenom);
				$sheet->setCellValue('E'.$ligne,strftime("%d/%m/%y" , strtotime( $preinscrits->date_naissance)));
				$sheet->setCellValue('F'.$ligne,$preinscrits->lieu_naissance);
				$sheet->setCellValue('G'.$ligne,age($preinscrits->date_naissance));
				$sheet->setCellValue('H'.$ligne,$preinscrits->adresse1);
				$sheet->setCellValue('I'.$ligne,$preinscrits->adresse2);
				$sheet->setCellValue('J'.$ligne,$preinscrits->cp);
				$sheet->setCellValue('K'.$ligne,$preinscrits->ville);
				$sheet->setCellValue('L'.$ligne,"0".$preinscrits->telephone);
				$sheet->setCellValue('M'.$ligne,$preinscrits->email);
				$sheet->setCellValue('N'.$ligne,$preinscrits->diplome);
				$sheet->setCellValue('O'.$ligne,$preinscrits->no_diplome);
				$sheet->setCellValue('P'.$ligne,strftime("%d/%m/%y" , strtotime( $preinscrits->date_diplome)));
				$sheet->setCellValue('Q'.$ligne,$preinscrits->dr_delivrance);
				$sheet->setCellValue('R'.$ligne,$preinscrits->paiement);
				$ligne ++;
			}
		}
	}
	catch( Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}



	$writer = new PHPExcel_Writer_Excel2007($workbook);


	//prepare download


	if( $_POST['inscrit'] == 0)
	{
		$filename= $formation->discipline.'-'.$formation->date_debut.'_preinscrits.xls';
	}
	else
	{
		$filename= $formation->discipline.'-'.$formation->date_debut.'_inscrits.xls';
	}

	$writer->save(__DIR__.'/'.$filename);
	echo plugins_url($filename,__FILE__);
	die();
}


function age($date)
{
  return (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
}
?>
