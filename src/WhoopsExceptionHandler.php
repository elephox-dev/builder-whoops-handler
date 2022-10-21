<?php
declare(strict_types=1);

namespace Elephox\Builder\Whoops;

use Elephox\Support\Contract\ErrorHandler;
use Elephox\Support\Contract\ExceptionHandler;
use NunoMaduro\Collision\Handler as CollisionHandler;
use Throwable;
use Whoops\Exception\ErrorException as WhoopsErrorException;
use Whoops\Handler\PlainTextHandler;
use Whoops\RunInterface as WhoopsRunInterface;

class WhoopsExceptionHandler implements ExceptionHandler, ErrorHandler
{
	public function __construct(
		private readonly WhoopsRunInterface $whoopsRun,
	) {
	}

	protected function checkHandlers(): void
	{
		if (!empty($this->whoopsRun->getHandlers())) {
			return;
		}

		/**
		 * @psalm-suppress InternalClass
		 * @psalm-suppress InternalMethod
		 * @noinspection PhpInternalEntityUsedInspection
		 */
		if (class_exists(CollisionHandler::class)) {
			$this->whoopsRun->pushHandler(new CollisionHandler());
		} else {
			$this->whoopsRun->pushHandler(new PlainTextHandler());
		}
	}

	public function handleException(Throwable $exception): void
	{
		$this->checkHandlers();

		$this->whoopsRun->handleException($exception);
	}

	/**
	 * @throws WhoopsErrorException
	 */
	public function handleError(int $severity, string $message, string $file, int $line): bool
	{
		$this->checkHandlers();

		return $this->whoopsRun->handleError($severity, $message, $file, $line);
	}
}
