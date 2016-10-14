<?php

use function Dgame\Wrapper\string;

require_once 'vendor\autoload.php';

var_dump(string('áàèéìíóòùúûß')->toAscii());
