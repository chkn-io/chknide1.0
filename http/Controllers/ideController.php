<?php
use App\App\Request;
class ideController extends Controller{
	public function ide(){
		//Call Controller Template
		if($this->session->check("folder_name")){
			$this->session->check("folder_name");
			$this->template("index");

			$this->variable("dir",$_SERVER['DOCUMENT_ROOT']."/".$this->session->get("folder_name")."");
			//Change Page Title
			$this->title("CHKN Framework IDE");

			//Page Style
			$this->css([
				"ide"
			]);
			//Page Script
			$this->js([
				"nicescroll",
				"ide"
			]);

			$this->variable("folder",$this->session->get("folder_name"));
			$this->variable("host",$_SERVER["HTTP_HOST"]);

			//Page Content
			$this->body("ide/index");
			$this->variable("project",$this->session->get("project_name"));

			//App Status
			//$this->chkn_status();

			$this->show();
		}else{
			$this->locate("");
		}
		
	}

	public function getApplication(Request $r){
		$folder = $this->session->get("folder_name");
		$package = $this->session->get("project_name");
		$fn = fopen("projects/".$package,"r");
		$array = [];
		while(! feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'LOCAL') !== false) {
			    $raw = str_replace("LOCAL=", "", $result);
			    $array["LOCAL"] = $raw;
			}
			if (strpos($result, 'CONSOLE') !== false) {
			    $raw = str_replace("CONSOLE=", "", $result);
			    $array["CONSOLE"] = $raw;
			}
			if (strpos($result, 'CSS_ERROR') !== false) {
			    $raw = str_replace("CSS_ERROR=", "", $result);
			    $array["CSS_ERROR"] = $raw;
			}
			
			if (strpos($result, 'JS_ERROR') !== false) {
			    $raw = str_replace("JS_ERROR=", "", $result);
			    $array["JS_ERROR"] = $raw;
			}
			if (strpos($result, 'DEFAULT_IMAGE_SIZE') !== false) {
			    $raw = str_replace("DEFAULT_IMAGE_SIZE=", "", $result);
			    $array["DEFAULT_IMAGE_SIZE"] = $raw;
			}
			if (strpos($result, 'DEFAULT_FILE_SIZE') !== false) {
			    $raw = str_replace("DEFAULT_FILE_SIZE=", "", $result);
			    $array["DEFAULT_FILE_SIZE"] = $raw;
			}
		}
		fclose($fn);
		echo $this->response($array,200);
	}

	public function getDatabase(Request $r){
		$folder = $this->session->get("folder_name");
		$package = $this->session->get("project_name");
		$fn = fopen("projects/".$package,"r");
		$array = [];
		while(! feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'DB_CONNECTION') !== false) {
			    $raw = str_replace("DB_CONNECTION=", "", $result);
			    $array["DB_CONNECTION"] = $raw;
			}
			if (strpos($result, 'DB_HOST') !== false) {
			    $raw = str_replace("DB_HOST=", "", $result);
			    $array["DB_HOST"] = $raw;
			}
			if (strpos($result, 'DB_NAME') !== false) {
			    $raw = str_replace("DB_NAME=", "", $result);
			    $array["DB_NAME"] = $raw;
			}
			
			if (strpos($result, 'DB_CHARSET') !== false) {
			    $raw = str_replace("DB_CHARSET=", "", $result);
			    $array["DB_CHARSET"] = $raw;
			}
			if (strpos($result, 'DB_USER') !== false) {
			    $raw = str_replace("DB_USER=", "", $result);
			    $array["DB_USER"] = $raw;
			}
			if (strpos($result, 'DB_PASSWORD') !== false) {
			    $raw = str_replace("DB_PASSWORD=", "", $result);
			    $array["DB_PASSWORD"] = $raw;
			}
		}
		fclose($fn);
		echo $this->response($array,200);
	}

	public function getPackage(Request $r){
		$folder = $this->session->get("folder_name");
		$package = $this->session->get("project_name");
		$fn = fopen("projects/".$package,"r");
		$array = [];
		while(! feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'PACKAGE') !== false) {
			    $raw = str_replace("PACKAGE=", "", $result);
			    $raw = str_replace("\n", "", $raw);
			    $array["PACKAGE"] = $raw;
			}
		}
		fclose($fn);
		$ex =  explode("|",$array["PACKAGE"]);
		$array = [];
		for($x=0;$x<count($ex);$x++){
			$ex2 = explode(":",$ex[$x]);
			$array[$ex2[0]] = $ex2[1];
		}
		echo $this->response($array,200);
	}



	public function getVendors(Request $r){
		$folder = $this->session->get("folder_name");
		$package = $this->session->get("project_name");
		$fn = fopen("projects/".$package,"r");
		$array = [];
		while(! feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'VENDOR_SCRIPTS') !== false) {
			    $raw = str_replace("VENDOR_SCRIPTS=", "", $result);
			    $raw = str_replace("|", "\n", $raw);
			    $array["VENDOR_SCRIPTS"] = $raw;
			}
			if (strpos($result, 'VENDOR_STYLES') !== false) {
			    $raw = str_replace("VENDOR_STYLES=", "", $result);
			    $raw = str_replace("|", "\n", $raw);
			    $array["VENDOR_STYLES"] = $raw;
			}
		}
		fclose($fn);
		echo $this->response($array,200);
	}

	public function saveSApplication(Request $r){
		// Save Project File
		$package = $this->session->get("project_name");
		$file = file_get_contents("projects/".$package);
		$fn = fopen("projects/".$package,"r");
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'LOCAL') !== false) {
			   $file = str_replace($result, "LOCAL=".$r->local."\n", $file);
			}
			if (strpos($result, 'CONSOLE') !== false) {
			   $file = str_replace($result, "CONSOLE=".$r->console."\n", $file);
			}
			if (strpos($result, 'CSS_ERROR') !== false) {
			   $file = str_replace($result, "CSS_ERROR=".$r->css_error."\n", $file);
			}
			if (strpos($result, 'JS_ERROR') !== false) {
			   $file = str_replace($result, "JS_ERROR=".$r->js_error."\n", $file);
			}
			if (strpos($result, 'DEFAULT_IMAGE_SIZE') !== false) {
			   $file = str_replace($result, "DEFAULT_IMAGE_SIZE=".$r->default_image_size."\n", $file);
			}
			if (strpos($result, 'DEFAULT_FILE_SIZE') !== false) {
			   $file = str_replace($result, "DEFAULT_FILE_SIZE=".$r->default_file_size."\n", $file);
			}
		}
		$path = "projects/".$package;
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);

		// Save Main Application File

		$folder = $this->session->get("folder_name");
		$file = file_get_contents("../".$folder."/config/app.conf");
		$fn = fopen("../".$folder."/config/app.conf","r");
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'LOCAL') !== false) {
			   $file = str_replace($result, "LOCAL=".$r->local."\n", $file);
			}
			if (strpos($result, 'CONSOLE') !== false) {
			   $file = str_replace($result, "CONSOLE=".$r->console."\n", $file);
			}
			if (strpos($result, 'CSS_ERROR') !== false) {
			   $file = str_replace($result, "CSS_ERROR=".$r->css_error."\n", $file);
			}
			if (strpos($result, 'JS_ERROR') !== false) {
			   $file = str_replace($result, "JS_ERROR=".$r->js_error."\n", $file);
			}
			if (strpos($result, 'DEFAULT_IMAGE_SIZE') !== false) {
			   $file = str_replace($result, "DEFAULT_IMAGE_SIZE=".$r->default_image_size."\n", $file);
			}
			if (strpos($result, 'DEFAULT_FILE_SIZE') !== false) {
			   $file = str_replace($result, "DEFAULT_FILE_SIZE=".$r->default_file_size."\n", $file);
			}
		}

		$path = "../".$folder."/config/app.conf";
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);

		echo $this->response(["message"=>"success"],200);
	}

	public function saveSDatabase(Request $r){
		// Save Project File
		$package = $this->session->get("project_name");
		$file = file_get_contents("projects/".$package);
		$fn = fopen("projects/".$package,"r");
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'DB_CONNECTION') !== false) {
			   $file = str_replace($result, "DB_CONNECTION=".$r->db_connection."\n", $file);
			}
			if (strpos($result, 'DB_HOST') !== false) {
			   $file = str_replace($result, "DB_HOST=".$r->db_host."\n", $file);
			}
			if (strpos($result, 'DB_NAME') !== false) {
			   $file = str_replace($result, "DB_NAME=".$r->db_name."\n", $file);
			}
			if (strpos($result, 'DB_CHARSET') !== false) {
			   $file = str_replace($result, "DB_CHARSET=".$r->db_charset."\n", $file);
			}
			if (strpos($result, 'DB_USER') !== false) {
			   $file = str_replace($result, "DB_USER=".$r->db_user."\n", $file);
			}
			if (strpos($result, 'DB_PASSWORD') !== false) {
			   $file = str_replace($result, "DB_PASSWORD=".$r->db_password."\n", $file);
			}
		}
		$path = "projects/".$package;
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);

		// Save Main Application File

		$folder = $this->session->get("folder_name");
		$file = file_get_contents("../".$folder."/config/database.conf");
		$fn = fopen("../".$folder."/config/database.conf","r");
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'DB_CONNECTION') !== false) {
			   $file = str_replace($result, "DB_CONNECTION=".$r->db_connection."\n", $file);
			}
			if (strpos($result, 'DB_HOST') !== false) {
			   $file = str_replace($result, "DB_HOST=".$r->db_host."\n", $file);
			}
			if (strpos($result, 'DB_NAME') !== false) {
			   $file = str_replace($result, "DB_NAME=".$r->db_name."\n", $file);
			}
			if (strpos($result, 'DB_CHARSET') !== false) {
			   $file = str_replace($result, "DB_CHARSET=".$r->db_charset."\n", $file);
			}
			if (strpos($result, 'DB_USER') !== false) {
			   $file = str_replace($result, "DB_USER=".$r->db_user."\n", $file);
			}
			if (strpos($result, 'DB_PASSWORD') !== false) {
			   $file = str_replace($result, "DB_PASSWORD=".$r->db_password."\n", $file);
			}
		}

		$path = "../".$folder."/config/database.conf";
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);
		echo $this->response(["message"=>"success"],200);
	}


	public function saveSPackage(Request $r){
		// Save Project File
		$package = $this->session->get("project_name");
		$file = file_get_contents("projects/".$package);
		$fn = fopen("projects/".$package,"r");
		$newarray = [];
		$explode = explode("|",$r->package);
		for($x=0;$x<count($explode);$x++){
			$ex = explode(":",$explode[$x]);
			$newarray[$ex[0]] = $ex[1];
		}

		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'PACKAGE') !== false) {
			   $file = str_replace($result, "PACKAGE=".$r->package."\n", $file);
			}
		}
		$path = "projects/".$package;
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);

		// // Save Main Application File

		$folder = $this->session->get("folder_name");
		$file = file_get_contents("../".$folder."/config/Package/package.conf");
		$fn = fopen("../".$folder."/config/Package/package.conf","r");
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'ALL') !== false) {
			   $file = str_replace($result, "ALL=".$newarray["ALL"]."\n", $file);
			}
			if (strpos($result, 'QUERY_BUILDER') !== false) {
			   $file = str_replace($result, "QUERY_BUILDER=".$newarray["QUERY_BUILDER"]."\n", $file);
			}
			if (strpos($result, 'ENCRYPTION') !== false) {
			   $file = str_replace($result, "ENCRYPTION=".$newarray["ENCRYPTION"]."\n", $file);
			}
			if (strpos($result, 'DEFAULTS') !== false) {
			   $file = str_replace($result, "DEFAULTS=".$newarray["DEFAULTS"]."\n", $file);
			}
			if (strpos($result, 'QUERY_BUILDER') !== false) {
			   $file = str_replace($result, "QUERY_BUILDER=".$newarray["QUERY_BUILDER"]."\n", $file);
			}
			if (strpos($result, 'UPLOAD') !== false) {
			   $file = str_replace($result, "UPLOAD=".$newarray["UPLOAD"]."\n", $file);
			}
			if (strpos($result, 'DOWNLOAD') !== false) {
			   $file = str_replace($result, "DOWNLOAD=".$newarray["DOWNLOAD"]."\n", $file);
			}
			if (strpos($result, 'SESSION') !== false) {
			   $file = str_replace($result, "SESSION=".$newarray["SESSION"]."\n", $file);
			}
			if (strpos($result, 'MAINTENANCE_CLASS') !== false) {
			   $file = str_replace($result, "MAINTENANCE_CLASS=".$newarray["MAINTENANCE_CLASS"]."\n", $file);
			}
			if (strpos($result, 'PAGE_NOT_FOUND') !== false) {
			   $file = str_replace($result, "PAGE_NOT_FOUND=".$newarray["PAGE_NOT_FOUND"]."\n", $file);
			}
			if (strpos($result, 'CSRF') !== false) {
			   $file = str_replace($result, "CSRF=".$newarray["CSRF"]."\n", $file);
			}
			if (strpos($result, 'MODULE') !== false) {
			   $file = str_replace($result, "MODULE=".$newarray["MODULE"]."\n", $file);
			}
		}

		$path = "../".$folder."/config/Package/package.conf";
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);
		echo $this->response(["message"=>"success"],200);
	}

	public function saveSVendor(Request $r){
		$package = $this->session->get("project_name");
		$file = file_get_contents("projects/".$package);
		$fn = fopen("projects/".$package,"r");
		$vs = str_replace("\r\n","|",trim(preg_replace('/\t+/', '', $r->vendor_styles)));
		$vsr = str_replace("\r\n","|",trim(preg_replace('/\t+/', '', $r->vendor_scripts)));
		while(!feof($fn))  {
			$result = fgets($fn);
			if (strpos($result, 'VENDOR_SCRIPTS') !== false) {
			   $file = str_replace($result, "VENDOR_SCRIPTS=".$vsr."\n", $file);
			}
			if (strpos($result, 'VENDOR_STYLES') !== false) {
			   $file = str_replace($result, "VENDOR_STYLES=".$vs."\n", $file);
			}
		}
		$path = "projects/".$package;
		$myfile = fopen($path, "w");
		fwrite($myfile,$file);
		fclose($myfile);
		
		$ex = explode("|",$vsr);

$script = "/**Set your App's Global JavaScript/Libraries
/**Include every file after a new line
/**Save the scripts inside public/vendor/js/
/**Don't include the file extension

/**Start"."\n";
for ($x=0; $x < count($ex); $x++) {
	if($ex[$x] != ""){
		$script.=
$ex[$x]."\n"

		;		
	}
}
$script.="/**End";

		$folder = $this->session->get("folder_name");
		$path = "../".$folder."/config/Vendors/scripts.conf";
		$myfile = fopen($path, "w");
		fwrite($myfile,$script);
		fclose($myfile);


		$ex = explode("|",$vs);

$style = "/**Set your App's Global Stylesheet/Libraries
/**Include every file after a new line
/**Save the stylesheet inside public/vendor/css/
/**Don't include the file extension

/**Start"."\n";
for ($x=0; $x < count($ex); $x++) {
	if($ex[$x] != ""){
		$style.=
$ex[$x]."\n"
		;		
	}
}
$style.="/**End";
		$folder = $this->session->get("folder_name");
		$path = "../".$folder."/config/Vendors/stylesheets.conf";
		$myfile = fopen($path, "w");
		fwrite($myfile,$style);
		fclose($myfile);
		echo $this->response(["message"=>"success"],200);
	}

	public function getController(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		if ($handle = opendir('../'.$folder."/http/Controllers/")) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $entrys[$counter] = $entry;
		            $counter++;
		        }
		    }
		    closedir($handle);
		}

		echo $this->response($entrys,200);
	}

	public function getTemplate(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		if ($handle = opendir('../'.$folder."/view/template/")) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $entrys[$counter] = $entry;
		            $counter++;
		        }
		    }
		    closedir($handle);
		}

		echo $this->response($entrys,200);
	}

	public function getStyles(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		if ($handle = opendir('../'.$folder."/public/css/")) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $entrys[$counter] = $entry;
		            $counter++;
		        }
		    }
		    closedir($handle);
		}

		echo $this->response($entrys,200);
	}

	public function getScripts(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		if ($handle = opendir('../'.$folder."/public/js/")) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $entrys[$counter] = $entry;
		            $counter++;
		        }
		    }
		    closedir($handle);
		}

		echo $this->response($entrys,200);
	}

	public function getPage(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		$dir = "../".$folder."/view/page/";
		$directories = scandir($dir);
		for($x=0;$x<count($directories);$x++){
			if($directories[$x] != "." && $directories[$x] != ".."){
				$entrys[$counter] = $directories[$x];
				$counter++;
			}
		}
		$files = [];
		$counter = 0;
		for($x=0;$x<count($entrys);$x++){
			if ($handle = opendir('../'.$folder."/view/page/".$entrys[$x])) {
			    while (false !== ($entry = readdir($handle))) {
			        if ($entry != "." && $entry != "..") {
			            $files[$counter] = $entrys[$x]."/".$entry;
			            $counter++;
			        }
			    }
			    closedir($handle);
			}
		}

		echo $this->response($files,200);
	}

	public function createController(Request $r){
		$folder = $this->session->get("folder_name");
		$controller = str_replace(" ","",$r->controller);
		if($controller == ""){
			echo $this->response(["message"=>"Undefined value for CREATE CONTROLLER command","type"=>"error"],200);
		}else{
			if(!file_exists("../".$folder."/http/Controllers/".$controller."Controller.php")){
				$cont = fopen("../".$folder."/http/Controllers/".$controller."Controller.php", "w");
				$content = '<?php
use App\App\Request;
class '.$controller.'Controller extends Controller{
	public function '.$controller.'(){
		//Call Controller Template
		$this->template("index");

		//Change Page Title
		$this->title("");

		//Page Style
		$this->css([
		]);

		//Page Script
		$this->js([]);

		//Page Content
		$this->body("'.$controller.'/index");

		//App Status
		//$this->chkn_status();

		$this->show();
	}
}

';
				
				fwrite($cont, $content);
				fclose($cont); 


				if (!file_exists('../'.$folder.'/view/page/'.$controller)) {
				    mkdir('../'.$folder.'/view/page/'.$controller, 0777, true);
				    if(!file_exists("../".$folder."/view/page/".$controller."/index.cvf")){
				    	$page = fopen("../".$folder."/view/page/".$controller."/index.cvf", "w");
				    	$pcontent = '
<div class="clearfix"></div>
	<div class="col-md-12">
		<h1 class="text-center">This is the index page of '.$controller.'Controller.</h1>
	</div>	
<hr>';


						fwrite($page, $pcontent);
						fclose($page); 
				    }
				}
				echo $this->response(["message"=>$controller."Controller.php successfully created","type"=>"success"],200);
			}else{
				echo $this->response(["message"=>$controller."Controller.php is already exist","type"=>"error"],200);
			}
		}
	}

	public function createTemplate(Request $r){
		$folder = $this->session->get("folder_name");
		$controller = str_replace(" ","",$r->template);
		if($controller == ""){
			echo $this->response(["message"=>"Undefined value for CREATE CONTROLLER command","type"=>"error"],200);
		}else{
		    if(!file_exists("../".$folder."/view/template/".$r->template.".tpl")){
		    	$page = fopen("../".$folder."/view/template/".$r->template.".tpl", "w");
		    	$pcontent = '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="[chkn:csrf]" name="csrf-token">
    <title>[chkn:title]</title>
    <link rel="icon" href="[chkn:path]public/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    [chkn:style]

    <style>
    	#content .container{
    		margin-top:15em;
    	}
    	#content img{
    		width:80px;
    		float:left;
    	}
    	#content p{
    		float:left;
    		font-size:43pt;
    		margin-top:10pt;
    		color:#404040;
    	}

    	#content nav{
    		float:right;
    		margin-top:-20pt;
    	}
    	#content nav a{
    		color:#404040;
    		text-decoration: none;
    		transition:.2s;
    	}

    	#content nav a:hover{
    		text-decoration: none;
    		color:#404040;
    		border-bottom:2px solid #404040;
    		font-weight: bold;
    	}
    </style>
</head>
<body>
    <div id="content">
        [chkn:body]              
    </div>
[chkn:script]
</body>

</html>
';
				fwrite($page, $pcontent);
				fclose($page); 
				echo $this->response(["message"=>$r->template.".tpl successfully created","type"=>"success"],200);
		    }else{
				echo $this->response(["message"=>$r->template.".tpl is already exists","type"=>"error"],200);
		    }
		}
	}

	public function deleteFile(Request $r){
		$folder = $this->session->get("folder_name");
		if($r->group == "controller"){
			$path = "../".$folder."/http/Controllers/";
		}
		if($r->group == "page"){
			$path = "../".$folder."/view/page/";
		}
		if($r->group == "template"){
			$path = "../".$folder."/view/template/";
		}
		if($r->group == "style"){
			$path = "../".$folder."/public/css/";
		}
		if($r->group == "script"){
			$path = "../".$folder."/public/js/";
		}

		unlink($path.$r->file);
	}

	public function getControllerFolders(Request $r){
		$folder = $this->session->get("folder_name");
		$entrys = [];
		$counter = 0;
		$dir = "../".$folder."/view/page/";
		$directories = scandir($dir);
		for($x=0;$x<count($directories);$x++){
			if($directories[$x] != "." && $directories[$x] != ".."){
				$entrys[$counter] = $directories[$x];
				$counter++;
			}
		}

		echo $this->response($entrys,200);
	}
	public function createStyle(Request $r){
		$folder = $this->session->get("folder_name");
	    if(!file_exists("../".$folder."/public/css/".$r->style.".css")){
	    	$page = fopen("../".$folder."/public/css/".$r->style.".css", "w");
			fwrite($page, "");
			fclose($page); 
			echo 1;
	    }else{
	    	echo 0;
	    }
				
	}
	public function createScript(Request $r){
		$folder = $this->session->get("folder_name");
	    if(!file_exists("../".$folder."/public/js/".$r->style.".js")){
	    	$page = fopen("../".$folder."/public/js/".$r->style.".js", "w");
			fwrite($page, "");
			fclose($page); 
			echo 1;
	    }else{
	    	echo 0;
	    }
				
	}


	public function createPage(Request $r){
		$folder = $this->session->get("folder_name");
				
	    if(!file_exists("../".$folder."/view/page/".$r->controller."/".$r->file.".cvf")){
	    	$page = fopen("../".$folder."/view/page/".$r->controller."/".$r->file.".cvf", "w");
			fwrite($page, "");
			fclose($page); 
			echo 1;
	    }else{
	    	echo 0;
	    }
				
	}

	public function getContent(Request $r){
		$folder = $this->session->get("folder_name");
		$ex = explode("/",$r->file);
		if($ex[0] == "controller"){
			$file = file_get_contents("../".$folder."/http/Controllers/".$ex[1]);
		}
		if($ex[0] == "page"){
			$file = file_get_contents("../".$folder."/view/page/".$ex[1]."/".$ex[2]);
		}
		if($ex[0] == "template"){
			$file = file_get_contents("../".$folder."/view/template/".$ex[1]);
		}
		if($ex[0] == "css"){
			$file = file_get_contents("../".$folder."/public/css/".$ex[1]);
		}
		if($ex[0] == "js"){
			$file = file_get_contents("../".$folder."/public/js/".$ex[1]);
		}
		echo $file;
	}

	public function saveFile(Request $r){
		$folder = $this->session->get("folder_name");
		$ex = explode("/",$r->source);
		if($ex[0] == "controller"){
			$myfile = fopen("../".$folder."/http/Controllers/".$ex[1], "w") or die("Unable to open file!");
			$txt =$r->value;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		if($ex[0] == "page"){
			$myfile = fopen("../".$folder."/view/page/".$ex[1]."/".$ex[2], "w") or die("Unable to open file!");
			$txt =$r->value;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		if($ex[0] == "template"){
			$myfile = fopen("../".$folder."/view/template/".$ex[1], "w") or die("Unable to open file!");
			$txt =$r->value;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		if($ex[0] == "css"){
			$myfile = fopen("../".$folder."/public/css/".$ex[1], "w") or die("Unable to open file!");
			$txt =$r->value;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		if($ex[0] == "js"){
			$myfile = fopen("../".$folder."/public/js/".$ex[1], "w") or die("Unable to open file!");
			$txt =$r->value;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		
	}
}

