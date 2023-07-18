<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\QueryBuilder\Exception; 

use Exception;

class QueryBuilderException extends Exception
{

  /**
   * Main exception handler
   *
   * @param string $message
   * @param integer $code
   * @param Exception $previous
   * @return void
   */
  public function __construct(string $message = null, int $code = 0, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

}

?>