<?php

namespace Kernel;

class View
{
	/**
	 * The file name with the path
	 * @var string
	 * */
	protected string $file;

	/**
	 * The data that exists inside the template as variables
	 * @var array 
	 * */
	protected array $data;

	/**
	 * Create a new view
	 * @param string $file the file name
	 * @param array $data the variables
	 * */
	public function __construct(string $file, array $data = [])
	{
		$this->data = $data;
		$this->file = "./src/Views/$file";
	}

	/**
	 * Get the rendered view
	 * @return string
	 * */
	public function __toString(): string
	{
		extract($this->data);
		ob_start();
		include $this->file;
		return ob_get_clean();
	}
}
