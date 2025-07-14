<?php

namespace DAMA\DoctrineTestBundle\Doctrine\DBAL;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\ParameterType;

/**
 * @internal
 */
abstract class AbstractStaticConnection implements Connection
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var bool
     */
    protected $transactionStarted = false;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function lastInsertId($name = null): string
    {
        return $this->connection->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        if ($this->transactionStarted) {
            return $this->connection->beginTransaction();
        }

        return $this->transactionStarted = true;
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    public function getWrappedConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        return $this->connection->quote($input, $type);
    }
}
