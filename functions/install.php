<?php

	global $wpdb;


	$sql_centres = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}centre_formation`(";
	$sql_centres.= "`id` int(11) NOT NULL AUTO_INCREMENT, ";
	$sql_centres.= "`centre` varchar(80) NOT NULL, ";
	$sql_centres.= "`adresse` varchar(255) NOT NULL, ";
	$sql_centres.= "`code_postal` int(11) NOT NULL, ";
	$sql_centres.= "`ville` varchar(80) NOT NULL, ";
	$sql_centres.= "`e_mail` varchar(80) NOT NULL, ";
	$sql_centres.= "`site` varchar(100) NOT NULL, ";
	$sql_centres.= "`image` varchar(80) NOT NULL, ";
	$sql_centres.= "`telephone` int(255) NOT NULL, ";
	$sql_centres.= "`gerant` varchar(100) NOT NULL, ";
	$sql_centres.= "`autre` text NOT NULL, ";
	$sql_centres.= "PRIMARY KEY (`id`) );";

	$sql_discipline.= "CREATE TABLE IF NOT EXISTS `SELECT discipline` (";
	$sql_discipline.= "`id` int(11) NOT NULL AUTO_INCREMENT, ";
	$sql_discipline.= "`discipline` varchar(70) NOT NULL, ";
	$sql_discipline.= "PRIMARY KEY (`id`) );";


	$sql_formations ="CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}formation` (";
	$sql_formations.="`id` int(11) NOT NULL AUTO_INCREMENT, ";
	$sql_formations.="`idDiscipline` int(11) NOT NULL, ";
	$sql_formations.="`date_debut` date NOT NULL, ";
	$sql_formations.="`date_fin` date NOT NULL, ";
 	$sql_formations.= "`idCentre` int(11) NOT NULL, ";
 	$sql_formations.= "`departement` int(11) NOT NULL, ";
 	$sql_formations.= "`fichier` varchar(70) NOT NULL, ";
 	$sql_formations.= "`lieu` varchar(70) NOT NULL, ";
 	$sql_formations.= "`infos` varchar(100) NOT NULL, ";
 	$sql_formations.= "PRIMARY KEY (`id`) ); ";

 	$sql_preinscrits = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}preinscrits` (";
 	$sql_preinscrits .= " `nom` varchar(70) NOT NULL,";
 	$sql_preinscrits .= " `prenom` varchar(70) NOT NULL,";
 	$sql_preinscrits .= " `adresse1` varchar(200) NOT NULL,";
 	$sql_preinscrits .= " `adresse2` varchar(200) NOT NULL,";
 	$sql_preinscrits .= " `id` int(11) NOT NULL AUTO_INCREMENT,";
 	$sql_preinscrits .= " `cp` int(11) NOT NULL,";
 	$sql_preinscrits .= " `ville` varchar(100) NOT NULL,";
 	$sql_preinscrits .= " `telephone` int(255) NOT NULL,";
 	$sql_preinscrits .= " `email` varchar(100) NOT NULL,";
 	$sql_preinscrits .= " `idformation` int(11) NOT NULL,";
 	$sql_preinscrits .= " `estinscrit` int(11) NOT NULL,";
 	$sql_preinscrits .= " `carte` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `certif` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `assurance` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `defense` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `date_naissance` date NOT NULL,";
 	$sql_preinscrits .= " `lieu_naissance` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `paiement` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `diplome` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `no_diplome` int(11) NOT NULL,";
 	$sql_preinscrits .= " `date_diplome` date NOT NULL,";
 	$sql_preinscrits .= " `dr_delivrance` varchar(255) NOT NULL,";
 	$sql_preinscrits .= " `titre` varchar(100) NOT NULL,";
 	$sql_preinscrits .= " `titre` varchar(100) NOT NULL,";
 	$sql_preinscrits .= "  PRIMARY KEY (`id`)";
 	$sql_preinscrits .= ");";


	$centres = $wpdb->query($sql_centres);
	$discipline = $wpdb->query($sql_discipline);
	$formations = $wpdb->query($sql_formations);
	$preinscrits = $wpdb->query($sql_preinscrits);
?>
