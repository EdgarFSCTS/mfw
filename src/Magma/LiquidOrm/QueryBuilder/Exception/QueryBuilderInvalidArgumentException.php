<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\QueryBuilder\Exception;

use InvalidArgumentException;

class QueryBuilderInvalidArgumentException extends InvalidArgumentException
{
  public function __construct(string $message = null, int $code = 0, \Throwable $previous = null)
  {
    if($message === null){
      $message = 'Invalid argument supplied for query builder';
    }
    parent::__construct($message, $code, $previous);
  }
}

?>