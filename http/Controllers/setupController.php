<?php
use App\App\Request;
class setupController extends Controller{
	public function basic(Request $r){
		$myfile = fopen("projects/".$r->project_name.".chkn", "w");
		$encryption_key_256bit = base64_encode(openssl_random_pseudo_bytes(32));
		$text = "PROJECT_NAME=".$r->project_name."\n";
		$text .= "FOLDER_NAME=".$r->folder_name."\n";
		$text .= "PACKAGE=".$r->packages."\n";
		$text .= "APPLICATION_KEY=".$encryption_key_256bit."\n";

		$text .= "MAINTENANCE="."\n";
		$text .= "LOCAL=1"."\n";
		$text .= "CONSOLE=1"."\n";
		$text .= "CSS_ERROR=1"."\n";
		$text .= "JS_ERROR=1"."\n";
		$text .= "DEFAULT_IMAGE_SIZE=8000000000000"."\n";
		$text .= "DEFAULT_FILE_SIZE=8000000000000"."\n";
		$text .= "DB_CONNECTION=mysql"."\n";
		$text .= "DB_HOST=localhost"."\n";
		$text .= "DB_NAME="."\n";
		$text .= "DB_CHARSET=utf8"."\n";
		$text .= "DB_USER=root"."\n";
		$text .= "DB_PASSWORD="."\n";
		$text .= "VENDOR_SCRIPTS=jquery|bootstrap.min|fontawesome.min"."\n";
		$text .= "VENDOR_STYLES=bootstrap.min|fontawesome.min|fontawesome-all"."\n";

		if (!is_dir("../".$r->folder_name)) {
	        $result = mkdir("../".$r->folder_name, "0777");
	        $this->xcopy("public/package/","../".$r->folder_name);

			fwrite($myfile, $text);
			fclose($myfile);
			$ex1 = explode("|",$r->packages);
			$package_file = fopen("../".$r->folder_name."/config/Package/package.conf", "w");
			$text2 = "";
			for($x=0;$x<count($ex1);$x++){
				$ex2 = explode(":",$ex1[$x]);
				$text2 .= $ex2[0]."=".$ex2[1]."\n";
			}
			fwrite($package_file, $text2);
			fclose($package_file);
			// App
			$this->setAppConfig($r->folder_name,"ROOT_FOLDER",$r->folder_name);
			$this->setAppConfig($r->folder_name,"MAINTENANCE","");
			$this->setAppConfig($r->folder_name,"APPLICATION_KEY",$encryption_key_256bit);
			$this->setAppConfig($r->folder_name,"LOCAL",1);
			$this->setAppConfig($r->folder_name,"CONSOLE",1);
			$this->setAppConfig($r->folder_name,"CSS_ERROR",1);
			$this->setAppConfig($r->folder_name,"JS_ERROR",1);
			$this->setAppConfig($r->folder_name,"DEFAULT_IMAGE_SIZE","8000000000000");
			$this->setAppConfig($r->folder_name,"DEFAULT_FILE_SIZE","8000000000000");
			// Database
			$this->setDatabaseConfig($r->folder_name,"DB_CONNECTION","mysql");
			$this->setDatabaseConfig($r->folder_name,"DB_HOST","mysql");
			$this->setDatabaseConfig($r->folder_name,"DB_CONNECTION","localhost");
			$this->setDatabaseConfig($r->folder_name,"DB_NAME","");
			$this->setDatabaseConfig($r->folder_name,"DB_CHARSET","utf8");
			$this->setDatabaseConfig($r->folder_name,"DB_USER","root");
			$this->setDatabaseConfig($r->folder_name,"DB_PASSWORD","");

			// Script Vendors
			$this->scriptsVendors($r->folder_name,["jquery","bootstrap.min","fontawesome.min"]);

			// Styles Vendors
			$this->stylesVendors($r->folder_name,["bootstrap.min","fontawesome.min","fontawesome-all"]);
			$this->session->put("project_name",$r->project_name);
			$this->session->put("folder_name",$r->folder_name);
	    	echo $this->response(["success"=>"success"],200);
	    }else{
	    	echo $this->response(["error"=>"File is already exists"],401);
	    }
	}

	public function advance(Request $r){
		$myfile = fopen("projects/".$r->project_name.".chkn", "w");
		$encryption_key_256bit = base64_encode(openssl_random_pseudo_bytes(32));
		$text = "PROJECT_NAME=".$r->project_name."\n";
		$text .= "FOLDER_NAME=".$r->folder_name."\n";
		$text .= "PACKAGE=".$r->packages."\n";
		$text .= "APPLICATION_KEY=".$encryption_key_256bit."\n";

		$text .= "MAINTENANCE="."\n";
		$text .= "LOCAL=".$r->local."\n";
		$text .= "CONSOLE=".$r->console."\n";
		$text .= "CSS_ERROR=".$r->css_error."\n";
		$text .= "JS_ERROR=".$r->js_error."\n";
		$text .= "DEFAULT_IMAGE_SIZE=".$r->default_image_size."\n";
		$text .= "DEFAULT_FILE_SIZE=".$r->default_file_size."\n";
		$text .= "DB_CONNECTION=".$r->db_connection."\n";
		$text .= "DB_HOST=".$r->db_host."\n";
		$text .= "DB_NAME=".$r->db_name."\n";
		$text .= "DB_CHARSET=".$r->db_charset."\n";
		$text .= "DB_USER=".$r->db_user."\n";
		$text .= "DB_PASSWORD=".$r->db_password."\n";
		$s = str_replace("\n", "|", $r->vendor_scripts);
		$text .= "VENDOR_SCRIPTS=".$s."\n";
		$s2 = str_replace("\n", "|", $r->vendor_styles);
		$text .= "VENDOR_STYLES=".$s2."\n";


		if (!is_dir("../".$r->folder_name)) {
	        $result = mkdir("../".$r->folder_name, "0777");
	        $this->xcopy("public/package/","../".$r->folder_name);

			fwrite($myfile, $text);
			fclose($myfile);
			$ex1 = explode("|",$r->packages);
			$package_file = fopen("../".$r->folder_name."/config/Package/package.conf", "w");
			$text2 = "";
			for($x=0;$x<count($ex1);$x++){
				$ex2 = explode(":",$ex1[$x]);
				$text2 .= $ex2[0]."=".$ex2[1]."\n";
			}
			fwrite($package_file, $text2);
			fclose($package_file);

			// App
			$this->setAppConfig($r->folder_name,"ROOT_FOLDER",$r->folder_name);
			$this->setAppConfig($r->folder_name,"MAINTENANCE","");
			$this->setAppConfig($r->folder_name,"APPLICATION_KEY",$encryption_key_256bit);
			$this->setAppConfig($r->folder_name,"LOCAL",$r->local);
			$this->setAppConfig($r->folder_name,"CONSOLE",$r->console);
			$this->setAppConfig($r->folder_name,"CSS_ERROR",$r->css_error);
			$this->setAppConfig($r->folder_name,"JS_ERROR",$r->js_error);
			$this->setAppConfig($r->folder_name,"DEFAULT_IMAGE_SIZE",$r->default_image_size);
			$this->setAppConfig($r->folder_name,"DEFAULT_FILE_SIZE",$r->default_file_size);
			// Database
			$this->setDatabaseConfig($r->folder_name,"DB_CONNECTION",$r->db_connection);
			$this->setDatabaseConfig($r->folder_name,"DB_HOST",$r->db_host);
			$this->setDatabaseConfig($r->folder_name,"DB_NAME",$r->db_name);
			$this->setDatabaseConfig($r->folder_name,"DB_CHARSET",$r->db_charset);
			$this->setDatabaseConfig($r->folder_name,"DB_USER",$r->db_user);
			$this->setDatabaseConfig($r->folder_name,"DB_PASSWORD",$r->db_password);

			// Script Vendors
			$v_scripts = explode("\n",$r->vendor_scripts);
			$this->scriptsVendors($r->folder_name,$v_scripts);

			// Styles Vendors
			$v_styles = explode("\n",$r->vendor_styles);
			$this->stylesVendors($r->folder_name,$v_styles);
			$this->session->put("project_name",$r->project_name);
			$this->session->put("folder_name",$r->folder_name);
	    	echo $this->response(["success"=>"success"],200);
	    }else{
	    	echo $this->response(["error"=>"File is already exists"],401);
	    }
	}

	public function setAppConfig($folder = "",$field="",$value = ""){
		$path = "../".$folder."/config/app.conf";
		$app = file_get_contents($path);
		$app = str_replace("{".$field."}", $value, $app);
		$myfile = fopen($path, "w");
		fwrite($myfile,$app);
		fclose($myfile);
	}

	public function setDatabaseConfig($folder = "",$field="",$value = ""){
		$path = "../".$folder."/config/database.conf";
		$app = file_get_contents($path);
		$app = str_replace("{".$field."}", $value, $app);
		$myfile = fopen($path, "w");
		fwrite($myfile,$app);
		fclose($myfile);
	}

	public function scriptsVendors($folder = "",$scripts = []){
		$path = "../".$folder."/config/Vendors/scripts.conf";
		$app = file_get_contents($path);
		$text = "";
		for($x=0;$x<count($scripts);$x++){
			$text.=$scripts[$x]."\n";
		}
		$app = str_replace("{SCRIPTS}", $text, $app);
		$myfile = fopen($path, "w");
		fwrite($myfile,$app);
		fclose($myfile);
	}

	public function stylesVendors($folder = "",$scripts = []){
		$path = "../".$folder."/config/Vendors/stylesheets.conf";
		$app = file_get_contents($path);
		$text = "";
		for($x=0;$x<count($scripts);$x++){
			$text.=$scripts[$x]."\n";
		}
		$app = str_replace("{STYLES}", $text, $app);
		$myfile = fopen($path, "w");
		fwrite($myfile,$app);
		fclose($myfile);
	}


	public function xcopy($source, $dest, $permissions = 0755){
	    // Check for symlinks
	    if (is_link($source)) {
	        return symlink(readlink($source), $dest);
	    }

	    // Simple copy for a file
	    if (is_file($source)) {
	        return copy($source, $dest);
	    }

	    // Make destination directory
	    if (!is_dir($dest)) {
	        mkdir($dest, $permissions);
	    }

	    // Loop through the folder
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {
	        // Skip pointers
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        // Deep copy directories
	        $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
	    }

	    // Clean up
	    $dir->close();
	    return true;
	}

	public function getProjects(Request $r){
		$dir = "projects/";
		// $files = array_diff(scandir($path), array('.', '..'));
		// echo $this->response($files,200);
		chdir($dir);
		array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_DESC, $files);
		$array = [];
		$counter = 0;
		foreach($files as $filename)
		{
			$array[$counter] = substr($filename,0,-5);
			$counter++;
		}

		echo $this->response($array,200);
	}

	public function deleteProject(Request $r){
		$myFile = "projects/".$r->project;
		unlink($myFile);
		unlink("../".$r->folder."/.htaccess");
		$this->deleteDir("../".$r->folder);
	}

	public function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            $this->deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}

	public function openProject(Request $r){
		if(is_dir("../".$r->folder)){
			$this->session->put("project_name",$r->project);
			$this->session->put("folder_name",$r->folder);
			echo $this->response(["message"=>"success"],200);
		}else{
			echo $this->response(["message"=>"error"],422);
		}
		
	}
}

