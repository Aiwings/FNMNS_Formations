<?php function form_inscription()
{
?>
<form id="preinscription_form" >
		<h2></h2>
			<fieldset class="form-group col-md-2">
				<select id="titre" name="titre" required style="position:relative;top:15px;">
					<option  value="" selected>Titre *</option>
					<option value="melle">Mademoiselle</option>
					<option value="mme">Madame</option>
					<option value="mr">Monsieur</option>
				<select>
			</fieldset>	

			<fieldset class="form-group col-md-5">
				<label for="nom">Votre Nom *</label>
				<input type="text"  name="nom" id="nom" class="form-control" pattern="[a-zA-Zéèàê]+" required size="40" />
			</fieldset>

			<fieldset class="form-group col-md-5">
				<label for="prenom">Votre Prénom * </label>
				<input type="text"  name="prenom" id="prenom" class="form-control" pattern="[a-zA-Zéèàê]+"  size="40"  required/>
			</fieldset>
	
			<fieldset class="form-group col-md-6">
				<label for="email">Votre Adresse Email * </label>
				<input type="email"  name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"  class="form-control" size="40" required />
			</fieldset>
	
			<fieldset class="form-group col-md-6">
				<label for="tel">Votre Numéro de Téléphone *</label>
				<input type="tel" name="tel"  id="tel" class="form-control"  required><br />
			</fieldset>

			<fieldset class="form-group col-md-6">
				<label for="adresse1">Votre Adresse *</label>
				<input type="text"  name="adresse1"  id="adresse1" size="40" placeholder="Adresse 1" class="form-control"  required  />
			</fieldset>
		
	
			<fieldset class="form-group col-md-6">
				<label for="adresse2">Adresse 2</label>
				<input type="text"  name="adresse2"  id="adresse2" size="40" placeholder="Adresse 2" class="form-control"  value=""  />
			</fieldset>

			<fieldset class="form-group col-md-4">
				<label for="cp">Code Postal * </label>
				<input type="text" name="cp" id="cp" pattern="[0-9]{5}" class="form-control"  size="40" required />
			</fieldset>
	
	
			<fieldset class="form-group col-md-8">
				<label for="ville">Ville* </label>
				<input type="text" name="ville" id="ville" class="form-control" size="40" required  />
			</fieldset>
	
		<input type="hidden" name="idformation" id="idformation" />
	<p id="psubmit">
		<input type="submit" name="preinscription" value="Se Préinscrire"/>
	</p>
</form>
<?php 
	die();
}
?>