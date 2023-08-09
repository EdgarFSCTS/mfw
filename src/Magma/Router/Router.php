<?php

declare(strict_types=1);

namespace Magma\Router;

use Magma\Router\Exception\RouterBadMethodCallException;
use Magma\Router\RouterInterface;

class Router implements RouterInterface
{

  /**
   * Returns an array of route from our routing table
   * @var array
   */
  protected array $routes = [];

  /**
   * Returns an array of route parameter
   * @var array
   */
  protected array $params = [];

  /**
   * Adds a sufix to the controller name
   * @var string
   */
  protected string $controllerSufix = 'controller';

  /**
   * @inheritDoc
   */
  public function add(string $route, array $params = []) : void
  {
    $this->routes[$route] = $params;
  }

  /**
   * @inheritDoc
   */
  public function dispatch(string $url) : void
  {
    if($this->match($url)){
      $controllerString = $this->params['controller'];
      $controllerString = $this->transformUpperCamelCase($controllerString);
      $controllerString = $this->getNamespace($controllerString);

      if(class_exists($controllerString)){
        $controllerObject = new $controllerString($this->params);
        $action = $this->params['action'];
        $action = $this->transformCamelCase($action);

        if(is_callable([$controllerObject, $action])){
          $controllerObject->$action();
        } else{
          throw new RouterBadMethodCallException();
        }
      } else{
        throw new RouterBadMethodCallException();
      }
    } else {
      throw new RouterBadMethodCallException();
    }
  }

  public function transformUpperCamelCase(string $string) : string
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  public function transformCamelCase(string $string) : string
  {
    return lcfirst($this->transformUpperCamelCase($string));
  }

  /**
   * Match the route to thhe routes int the routing tabme, setting the $this->params property if a route is found
   * 
   * @param string $uurl
   * @return bool
   */ 
  private function match(string $url) : bool
  {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        foreach ($matches as $key => $param){
          if(is_string($key)){
            $params[$key] = $params;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  /**
   * Get the namespace for  the controller class. the  namespace defined within the route parameters only if it was added.
   * 
   * @param string $string
   * @return string
   */
  public function getNamespace(string $string) : string
  {
    $namespace = 'App\Controller\\';
    if(array_key_exists('namespace', $this->params)){
      $namespace .= $this->params['namespace'] . '\\';
    }
    return $namespace;
  }


}