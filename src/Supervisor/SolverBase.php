<?php

namespace Kraken\Supervisor;

use Kraken\Promise\Promise;
use Kraken\Throwable\Exception\Logic\IllegalCallException;
use Kraken\Throwable\Exception\Runtime\Execution\RejectionException;
use Error;
use Exception;

class SolverBase implements SolverInterface
{
    /**
     * @var mixed[]
     */
    protected $context;

    /**
     * @var string[]
     */
    protected $requires;

    /**
     * @param mixed[] $context
     */
    public function __construct($context = [])
    {
        $this->context = $context;
        $this->requires = [];

        $this->construct();
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->destruct();

        unset($this->context);
        unset($this->requires);
    }

    /**
     * @override
     * @inheritDoc
     */
    public function __invoke($ex, $params = [])
    {
        return $this->handle($ex, $params);
    }

    /**
     * @override
     * @inheritDoc
     */
    public function handle($ex, $params = [])
    {
        foreach ($this->requires as $require)
        {
            if (!isset($params[$require]))
            {
                return Promise::doReject(
                    new IllegalCallException('Missing parameter [' . $require . '] for [' . get_class($this) . '].')
                );
            }
        }

        return Promise::doResolve($this->handler($ex, $params));
    }

    /**
     * Handler to be called when solver is requested.
     *
     * @param Error|Exception|string $ex
     * @param mixed[] $params
     * @return mixed
     * @throws RejectionException
     */
    protected function handler($ex, $params = [])
    {
        throw new RejectionException('[' . __CLASS__ . '] code undefined.');
    }

    /**
     * Pseudo-Constructor.
     */
    protected function construct()
    {}

    /**
     * Pseudo-Destructor
     */
    protected function destruct()
    {}
}
