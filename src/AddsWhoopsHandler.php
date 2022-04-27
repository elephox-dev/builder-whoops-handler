<?php
declare(strict_types=1);

namespace Elephox\Builder\Whoops;

use Elephox\DI\Contract\ServiceCollection;
use Elephox\Support\Contract\ExceptionHandler;
use Whoops\Run as WhoopsRun;
use Whoops\RunInterface as WhoopsRunInterface;

trait AddsWhoopsHandler
{
    abstract protected function getServices(): ServiceCollection;

    public function addWhoops(): void
    {
        $this->getServices()->addSingleton(WhoopsRunInterface::class, WhoopsRun::class);
        $this->getServices()->addSingleton(ExceptionHandler::class, WhoopsExceptionHandler::class, replace: true);
    }
}
