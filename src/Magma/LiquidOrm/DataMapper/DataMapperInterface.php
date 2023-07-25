<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataMapper;

interface DataMapperInterface
{
  /**
   * Prepare the query string
   * @param string $sqlQuery
   * @return self
   */
  public function prepare(string $sqlQuery) : self;

  /**
   * Bind the query string
   * @param string $param
   */
  public function bind($value);

  /**
   * Execute the query string
   * @return mixed
   */
  public function bindParameters(array $fields, bool $isSearch = false) : self;

  /**
   * Execute the query string
   * @return int|null
   */
  public function numRows() : int;

  /**
   * Execute the query string
   * @return void
   */
  public function execute();

  /**
   * Execute the query string
   * @return bool
   */
  public function result(): object;

  /**
   * Execute the query string
   * @return bool
   */
  public function results() : array;

  /**
   * Returns the last inserted row ID from database table
   * 
   * @return int
   * @throws Throwable
   */
    public function getLastId() : int;

}



?>