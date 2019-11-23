<?php
use App\App\Request;
class index extends Controller{
	public function index_page(Request $r){
		//Call index template
		$this->template('index');
		//set default title
		$this->title('CHKN Framework');
		//set css
		$this->css(array(
			"index"
		));
		$this->variable("dir",$_SERVER['DOCUMENT_ROOT']);
		//set js
		$this->js(array(
			"index"
		));

		$this->body('homepage/index');
		$this->show();
	}

}
