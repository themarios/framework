<?php

namespace Kraken\Supervisor;

use Kraken\Promise\PromiseInterface;
use Error;
use Exception;

interface SolverInterface
{
    /**
     * Handle given Error, Exception or string message with set of params using solver's handler method.
     *
     * @see SolverInterface::handle
     *
     * @param Error|Exception|string $ex
     * @param mixed[] $params
     * @return PromiseInterface
     */
    public function __invoke($ex, $params = []);

    /**
     * Handle given Error, Exception or string message with set of params using solver's handler method.
     *
     * @param Error|Exception|string $ex
     * @param mixed[] $params
     * @return PromiseInterface
     */
    public function handle($ex, $params = []);
}
