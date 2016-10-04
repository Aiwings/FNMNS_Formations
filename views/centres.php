<?php 

	class Centres
	{
		private $content;
		private $settings;
		
		public function __construct(){
			$this->content = "";
			
			$this->settings = array( 'textarea_name' => 'autre_centre',
							'media_buttons' => false
							);
			
			$this->head();
			$this->form();
		}
		private function head(){
			?>
				
				
			<?php 	
			if(searchcentres()!="")
			{ 
				?>
				<div class="row">
					<h2>Choix du Mode </h2>
					<form id="selectCentres">
						<input id="create" type="radio" name="select" value="create" /> Ajouter un nouveau centre<br />
						<input id="select" type="radio" name="select" value="select" checked /> Modifier un centre<br />
						
						<?php echo searchcentres(); ?> <br />
					</form>	
					
				</div>
				<h2 id="title">Selectionnez un centre</h2>
				<?php
		
			}
			else
			{
				?>
				<h2>Aucun centre de formation </h2>
				<?php
			}
		}
		
		private function form()
		{
			?>
			<form id="centre" style="z-index :999999999;">
				<fieldset class="form-group col-md-6">
					<label for="nom-centre">Nom du Centre *</label>
					<input type="text" class="form-control" id="nom-centre"	name="nom_centre" placeholder="Nom" required >
				</fieldset>
				
				<fieldset class="form-group col-md-6">
					<label for="nom-centre">Président *</label>
					<input type="text" class="form-control" id="gerant-centre"	name="gerant_centre" placeholder="Gèrant" required >
				</fieldset>
				
				<fieldset class="form-group col-md-6">
					<label for="tel-centre">Telephone *</label>
					<input type="tel" class="form-control" id="tel-centre"	name="tel_centre" placeholder="Telephone" required >
				</fieldset>
				
				<fieldset class="form-group col-md-6">
					<label for="email-centre">Adresse E-mail *</label>
					<input type="email" class="form-control" id="email-centre" name="email_centre"placeholder="E-mail" required >
				</fieldset>
				
				<fieldset class="form-group col-md-6">
					<label for="adresse-centre">Adresse *</label>
					<input type="text" class="form-control" id="adresse-centre" name="adresse_centre" placeholder="Adresse" required >
				</fieldset>
				
				<fieldset class="form-group col-md-4">
					<label for="ville-centre">Ville *</label>
					<input type="text" class="form-control" id="ville-centre"  name="ville_centre" placeholder="Ville" required >
				</fieldset>
				
				<fieldset class="form-group col-md-2">
					<label for="cp-centre">CP</label>
					<input type="text" class="form-control" id="cp-centre" name="cp_centre" placeholder="CP">
				</fieldset>

				<fieldset class="form-group  col-md-6">
					<label for="image-centre">Image</label>
					<input type="file" class="form-control" id="image-centre" name="image_centre" placeholder="E-mail">
				</fieldset>
				
				<fieldset class="form-group  col-md-6">
					<label for="site-centre">Site Web</label>
					<input type="text" class="form-control" id="site-centre" name="site_centre" placeholder="Site Web">
				</fieldset>
				
				<span></span>
				<?php wp_editor( $this->content, 'autre-centre',$this->settings ); ?>
				
				<p style="text-align:center">
					<input type="submit" value="Valider" />
				</p>
			</form>
		<?php
		}
	}
