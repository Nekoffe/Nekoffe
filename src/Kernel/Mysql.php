<?php

namespace Kernel;

use mysqli;

class Mysql extends mysqli
{
	function __destruct() {
		$this->close();
	}
}
