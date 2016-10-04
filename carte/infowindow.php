<?php 
function infowindow()
{
	if (isset($_POST['id']))
	{
		global $wpdb ;
	
		$url = get_bloginfo("url")."/export/img/centres/";

		$sql_select = 'SELECT * FROM `centre_formation` WHERE id="'.$_POST['id'].'";';

		$reponse_select = $wpdb->get_results($sql_select );

	if (sizeof($reponse_select)== 1) 
	{
		foreach ($reponse_select as $row)
			{
			?>
<table width="350" cellspacing="0" cellpadding="5" border="0" bgcolor="#ffffff">
<tbody>
	<tr>
		<td width="20%" valign="top">
	<?php	if( $row->image != "")
	{
	?>
		<p><span style="color: rgb(0,0,0)"><img width="160" height="200" src="<?php echo $url.$row->image; ?>" alt="" /></span><span style="color: rgb(0,0,0)"><br type="_moz" />
<?php
	}
	?>
		</span></p>
		</td>
		<td width="80%" valign="top">
		<p>&nbsp;<i>Lieu :</i> <b><?php echo $row->ville; ?></b></p>
		<p><span style="color: rgb(0,0,0)">
		<i>Pr&eacute;sident :</i><br />
		<b><a href="mailto:<?php echo $row->e_mail; ?>" title="Envoyer un e-mail" ><?php echo $row->gerant; ?></a></b><br />
		<T&eacute;l. 0<?php echo $row->telephone; ?></span></p>
		</td>
	</tr>
	<tr>
		<td colspan="2"><span style="color: rgb(0,0,0)">
			<b><?php echo $row->centre; ?></b><br />
			<?php echo $row->adresse; ?><br />
			<?php if(isset ($row->code_postal)) echo $row->code_postal; ?> <span style="text-transform:uppercase;"><?php echo $row->ville; ?></span><br />
			<?php if(isset ($row->site)) echo $row->site; ?>
			<?php if(isset ($row->autre)) { 
						$autre = str_replace ("&lt;","<",$row->autre);
						$autre = str_replace ("&gt;",">",$autre);
				echo $autre;
				}?>
		</span></td>
	</tr>
</tbody>
</table>
					
					<?php
					}
				
			}
	

	}
	die();
}
