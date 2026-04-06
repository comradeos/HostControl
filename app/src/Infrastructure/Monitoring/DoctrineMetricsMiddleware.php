<?php

declare(strict_types=1);

namespace App\Infrastructure\Monitoring;

use Doctrine\DBAL\Driver as DbalDriver;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Driver\Middleware;
use Doctrine\DBAL\Driver\Middleware\AbstractConnectionMiddleware;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Doctrine\DBAL\Driver\Middleware\AbstractStatementMiddleware;
use Doctrine\DBAL\Driver\Result as DriverResult;
use Doctrine\DBAL\Driver\Statement as DriverStatement;
use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\Histogram;
use SensitiveParameter;

class DoctrineMetricsMiddleware implements Middleware
{
    private Counter $counter;

    private Histogram $histogram;

    /**
     * @throws MetricsRegistrationException
     */
    public function __construct(CollectorRegistry $registry)
    {
        $this->counter = $registry->getOrRegisterCounter(
            'app',
            'db_query_total',
            'Total DB queries',
            ['type']
        );

        $this->histogram = $registry->getOrRegisterHistogram(
            'app',
            'db_query_duration_seconds',
            'DB query duration',
            ['type'],
            [0.001, 0.005, 0.01, 0.05, 0.1, 0.5, 1, 2]
        );
    }

    public function wrap(DbalDriver $driver): DbalDriver
    {
        return new class($driver, $this->counter, $this->histogram) extends AbstractDriverMiddleware {
            private Counter $counter;

            private Histogram $histogram;

            public function __construct(
                DbalDriver $wrappedDriver,
                Counter $counter,
                Histogram $histogram
            ) {
                parent::__construct($wrappedDriver);

                $this->counter = $counter;
                $this->histogram = $histogram;
            }

            public function connect(
                #[SensitiveParameter]
                array $params
            ): DriverConnection {
                return new class(parent::connect($params), $this->counter, $this->histogram) extends AbstractConnectionMiddleware {
                    private Counter $counter;

                    private Histogram $histogram;

                    public function __construct(
                        DriverConnection $wrappedConnection,
                        Counter $counter,
                        Histogram $histogram
                    ) {
                        parent::__construct($wrappedConnection);

                        $this->counter = $counter;
                        $this->histogram = $histogram;
                    }

                    public function prepare(string $sql): DriverStatement
                    {
                        return new class(parent::prepare($sql), $sql, $this->counter, $this->histogram) extends AbstractStatementMiddleware {
                            private string $sql;

                            private Counter $counter;

                            private Histogram $histogram;

                            public function __construct(
                                DriverStatement $wrappedStatement,
                                string $sql,
                                Counter $counter,
                                Histogram $histogram
                            ) {
                                parent::__construct($wrappedStatement);

                                $this->sql = $sql;
                                $this->counter = $counter;
                                $this->histogram = $histogram;
                            }

                            public function execute(): DriverResult
                            {
                                $startTime = microtime(true);

                                try {
                                    return parent::execute();
                                } finally {
                                    $duration = microtime(true) - $startTime;
                                    $type = $this->detectQueryType($this->sql);

                                    $this->counter->inc([$type]);
                                    $this->histogram->observe($duration, [$type]);
                                }
                            }

                            private function detectQueryType(string $sql): string
                            {
                                $normalizedSql = ltrim($sql);
                                $firstWord = strtoupper((string) strtok($normalizedSql, " \n\t\r("));

                                if ($firstWord === '') {
                                    return 'UNKNOWN';
                                }

                                return $firstWord;
                            }
                        };
                    }

                    public function query(string $sql): DriverResult
                    {
                        $startTime = microtime(true);

                        try {
                            return parent::query($sql);
                        } finally {
                            $duration = microtime(true) - $startTime;
                            $type = $this->detectQueryType($sql);

                            $this->counter->inc([$type]);
                            $this->histogram->observe($duration, [$type]);
                        }
                    }

                    public function exec(string $sql): int|string
                    {
                        $startTime = microtime(true);

                        try {
                            return parent::exec($sql);
                        } finally {
                            $duration = microtime(true) - $startTime;
                            $type = $this->detectQueryType($sql);

                            $this->counter->inc([$type]);
                            $this->histogram->observe($duration, [$type]);
                        }
                    }

                    private function detectQueryType(string $sql): string
                    {
                        $normalizedSql = ltrim($sql);
                        $firstWord = strtoupper((string) strtok($normalizedSql, " \n\t\r("));

                        if ($firstWord === '') {
                            return 'UNKNOWN';
                        }

                        return $firstWord;
                    }
                };
            }
        };
    }
}
