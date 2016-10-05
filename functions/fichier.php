<?php class Fichier
	{

		private $fichier=null,$path="",$nom="",$type="",$uploadResult="";


		function __construct ($fichier,$type)
		{
			$this->fichier = $fichier;
			$this->name = $fichier["name"];
			$this->type = $type;
		}


		public function fileUpload($directory,$suf,$pre)
		{

			$path_parts = pathinfo($this->fichier["name"] );


			$this->name = $pre.basename($this->fichier["name"] ,'.'.$path_parts['extension']).$suf.'.'.$path_parts['extension'];


			$dir = ABSPATH.'/export/' ;

			if (!is_dir($dir )) {
						mkdir($dir);
					}

			if($this->type=='image')
			{
				$dir.='img/';
				if (!is_dir($dir )) {
					mkdir($dir);
				}

			}

			$target_dir = $dir .$directory ."/" ;


					if (!is_dir($target_dir)) {
						mkdir($target_dir);
					}

			$this->path = $target_dir . $this->name;



			if($this->finalizeupload())
			{
				return array
				(
					"success"=>"true",
					"name"=>$this->name
				);
			}
			else
			{
				return	array
				(
					"success"=>"false",
					"status"=>$this->uploadResult
				);

			}

		}

		private function finalizeupload ()
		{
			 $uploadOk = 1;
			$textresult = "";

			$fileType = pathinfo($this->path,PATHINFO_EXTENSION);

				// Check if file already exists
			if (file_exists($this->path)) {
				$textresult =  "<span style=\"color:#ff9800; \">Le fichier existe déja. </span><br />";
				$uploadOk = 0;
			}
			// Check if file already exists
			if($this->type == "pdf")
			{
				if ($fileType != $this->type) {
						$textresult =  "<span style=\"color:#ff9800; \">Le fichier n'est pas un pdf - <br /> Veuillez mettre un fichier pdf </span><br />";
						$uploadOk = 0;
				}
			}
			// Check file size
			if ($this->fichier["size"] > 30145728) {
				$textresult = "<span style=\"color:#ff0000; \">Votre fichier est trop large. (> 3 Mo ) - </span>";
				$uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0)
			{
				if(substr_count($this->path, 'export') == 1) $textresult .= "<span style=\"color:#ff0000; \">Désolé , impossible de mettre le pdf en ligne - </span>";

				// if everything is ok, try to upload file
				$this->uploadResult =  $textresult;
				return false;
			}
			else
			{
				if (move_uploaded_file($this->fichier["tmp_name"], $this->path))
				{
					return true;
				}
				else
				{
					$this->uploadResult =  "";
					return false;

				}
			}

		}

		public function getResult() {

			return $this->uploadResult;

		}

		public function getName() {

			return $this->name;

		}

		public function get_type() {

			return $this->type;

		}

		public function getPath() {

			return $this->path;

		}
	}
?>
