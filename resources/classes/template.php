<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Copyright (C) 2013
	All Rights Reserved.

Humayun
*/

//define the template class
	if (!class_exists('template')) {
		class template {

			public $engine;
			public $template_dir;
			public $cache_dir;
			private $object;
			private $var_array;

			public function __construct(){
			}

			public function init() {
				if ($this->engine === 'smarty') {
					require_once "resources/templates/engine/smarty/Smarty.class.php";
					$this->object = new Smarty();
					$this->object->setTemplateDir($this->template_dir);
					$this->object->setCompileDir($this->cache_dir);
					$this->object->setCacheDir($this->cache_dir);
					$this->object->registerPlugin("modifier","in_array", "in_array");
				}
				if ($this->engine === 'raintpl') {
					require_once "resources/templates/engine/raintpl/rain.tpl.class.php";
					$this->object = new RainTPL();
					RainTPL::configure('tpl_dir', realpath($this->template_dir)."/");
					RainTPL::configure('cache_dir', realpath($this->cache_dir)."/");
				}
				if ($this->engine === 'twig') {
					require_once "resources/templates/engine/Twig/Autoloader.php";
					Twig_Autoloader::register();
					$loader = new Twig_Loader_Filesystem($this->template_dir);
					$this->object = new Twig_Environment($loader);
					$lexer = new Twig_Lexer($this->object, array(
						'tag_comment'  => array('{*', '*}'),
						'tag_block'    => array('{', '}'),
						'tag_variable' => array('{$', '}'),
					));
					$this->object->setLexer($lexer);
				}
			}

			public function assign($key, $value) {
				if ($this->engine === 'smarty') {
					$this->object->assign($key, $value);
				}
				if ($this->engine === 'raintpl') {
					$this->object->assign($key, $value);
				}
				if ($this->engine === 'twig') {
					$this->var_array[$key] = $value;
				}
			}

			public function render($name) {
				if ($this->engine === 'smarty') {
					return $this->object->fetch($name);
				}
				if ($this->engine === 'raintpl') {
					return $this->object-> draw($name, 'return_string=true');
				}
				if ($this->engine === 'twig') {
					return $this->object->render($name,$this->var_array);
				}
			}
		}
	}

?>