<?php

namespace Kernel\Mysql;

use mysqli;

class Mysql extends mysqli
{
	function __destruct() {
		$this->close();
	}
}
