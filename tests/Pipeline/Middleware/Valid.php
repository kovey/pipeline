<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-11 15:25:26
 *
 */
namespace Kovey\Pipeline\Middleware;

use Kovey\Event\EventInterface;

class Valid implements MiddlewareInterface
{
    public function handle(EventInterface $event, callable | Array $next)
    {
        return $next($event);
    }
}
