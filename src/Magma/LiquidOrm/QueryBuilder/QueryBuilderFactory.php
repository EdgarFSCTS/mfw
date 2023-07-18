<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use Magma\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;

class QueryBuilderFactory
{

  public function __construct()
  {
  }


  public static function create(string $queryBuilderString): QueryBuilderInterface
  {
    $queryBulderObject = new $queryBuilderString();
    if(!$queryBulderObject instanceof QueryBuilderInterface){
      throw new QueryBuilderException($queryBuilderString . ' is not a valid query builder object.');
    }
    return new QueryBuilder();
  }
}

?>