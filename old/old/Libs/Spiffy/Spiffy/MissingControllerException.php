<?php
class ControllerMissingException extends ControllerException {
	public function __construct($methodName = 'en metod', $className = 'en klass') {
		print $methodName.' är en klass som saknas';
	}
} 