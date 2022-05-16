<?php
declare(strict_types=1);

namespace Elephox\Builder\Whoops;

use Elephox\DI\Contract\ServiceCollection;
use Elephox\Support\Contract\ErrorHandler;
use Elephox\Support\Contract\ExceptionHandler;
use Whoops\Run as WhoopsRun;
use Whoops\RunInterface as WhoopsRunInterface;

trait AddsWhoopsHandler
{
	abstract protected function getServices(): ServiceCollection;

	public function addWhoops(bool $registerErrorHandler = false): void
	{
		$this->getServices()->addSingleton(WhoopsRunInterface::class, WhoopsRun::class);
		$this->getServices()->addSingleton(ExceptionHandler::class, WhoopsExceptionHandler::class, replace: true);

		if ($registerErrorHandler) {
			$this->getServices()->addSingleton(ErrorHandler::class, WhoopsExceptionHandler::class, replace: true);
		}
	}
}
