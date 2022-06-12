<?php

namespace Controller;

use Kernel\Controller;
use Kernel\Storage;
use Kernel\View;

class Index extends Controller
{
	public function __construct()
	{
		$db = Storage::driver();
	}

	public function title(): string
	{
		return 'Hola';
	}

	public function content()
	{
		return new View('index.phtml', [
			'user' => $this->name,
		]);
	}
}
