<?php
class MissingMethodException extends ControllerException {
	public function __construct($methodName = 'en metod', $className = 'en klass') {
		print $methodName.' är en metod som saknas i '.$className;
	}
} 