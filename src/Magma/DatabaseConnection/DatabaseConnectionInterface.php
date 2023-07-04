<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection;

interface DatabaseConnectionInterface
{
  /**
   * Create a new database connecdtion
   *
   * @return PDO
   */
  public function open(): PDO;

  /**
   * Close the database connection
   *
   * @return void
   */
  public function close(): void;
}