<?php class NormalView
	{
		private $date;

		public function __construct()
		{
			setlocale (LC_ALL,"fr_FR");

			$this->date = date("Y-m-d", time());
			$this->getRows();
		}

		private function tabHeaders()
		{
			?>
			<div class="table">
				<table class="formations">
					<tr>
						<th width="100px;" >
							Contact
						</th>
						<th width="100px;" >
							Formation
						</th>
						<th width="100px;" >
							Infos
						</th>
						<th style=" width:150px;">
							Date de début
						</th>
						<th style=" width:150px;">
							Date de fin
						</th>
						<th width="200px" >
							Lieu
						</th>
						<th width="100px">
							Dept
						</th>
						<th width="130px">
						</th>
					</tr>
			<?php

		}

		private function getRows()
		{
			global $wpdb;

			$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
			$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
			$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
			$sql_formations.= 'WHERE `date_fin` > "'.$this->date.'" ORDER BY `date_debut`;';

			$reponse_formations = $wpdb->get_results($sql_formations );


			try
			{
				if (sizeof($reponse_formations) >= 1)
				{
					$this->tabHeaders();
					$this->displayRows($reponse_formations);
					$this->tabEnd();
				}
				else
				{
				?>
					<h3 style="color:red">Désolé, Aucune Formation n'est prévue à ce jour</h3>
				<?php
				}
			}
			catch( Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
		}

		private function displayRows($reponse_formations)
		{
			foreach ($reponse_formations as $row_formations)
			{
				?>
				<tr id="<?php echo $row_formations->id;?>">
					<td  class="centre" id="centre_<?php echo $row_formations->id;?>">
						<a onclick="displaywindow(<?php echo $row_formations->idCentre;?>)">
							<?php echo $row_formations->centre; ?>
						</a>
					</td>
					<td >
						<p  class="discipline" id="discipline_<?php echo $row_formations->id;?>">
							<?php echo $row_formations->discipline;?>
						</p>
					</td>
					<td width="100px">
						<?php if($row_formations->infos!=""){ ?>
						<a href="<?php echo plugins_url("formations/export/").$row_formations->discipline."/".$row_formations->infos;?>" title="infos">
							infos...
						</a>
						<?php } ?>
					</td>
					<td >
						<p class="date_debut" id="date_debut_<?php echo $row_formations->id;?>">
							<?php echo strftime("%d/%m/%y",strtotime($row_formations->date_debut)); ?>
						</p>
					</td>
					<td>
						<p  class="date_fin" id="date_fin_<?php echo $row_formations->id;?>">
							<?php echo strftime("%d/%m/%y",strtotime($row_formations->date_fin)); ?>
						</p>
					</td>
					<td >
						<p   class="lieu" id="lieu_<?php echo $row_formations->id;?>">
							<?php echo $row_formations->lieu; ?>
						</p>
					</td>
					<td >
						<p class="departement"  id="departement_<?php echo $row_formations->id;?>" >
							<?php echo $row_formations->departement; ?>
						</p>
					</td>
					<td >
						<a style="cursor:pointer;" onclick="preinscription(<?php echo $row_formations->id ; ?>)">Se Préinscrire</a>
					</td>

				</tr>

				<?php
			}

		}

		private function tabEnd()
		{
		?>
			</table>
		</div>
		<div id="response"><div>
		<div id="preinscription" class="popup hidden">
			<div class="popup-content">
				<span class="close" onclick ="hide('preinscription');">x</span>
				<div id="md_body"></div>
			</div>
		</div>
		<?php
		}
	}
?>
