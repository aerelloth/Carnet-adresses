<?php 

abstract class Controller
{
	protected $viewData = [];
	public function generateView($viewPath, $templatePath=DEFAULT_TEMPLATE_PATH)
	{
		$view = new View($viewPath, $this -> viewData, $templatePath);
		$view -> generate();
	}
}


 ?>