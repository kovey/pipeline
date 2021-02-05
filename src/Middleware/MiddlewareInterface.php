<?php
/**
 *
 * @description Middleware Interface
 *
 * @package     Middleware
 *
 * @time        2019-10-19 12:32:28
 *
 * @author      kovey
 */
namespace Kovey\Pipeline\Middleware;

use Kovey\Event\EventInterface;

interface MiddlewareInterface
{
    /**
     * @description handle function
     *
     * @param EventInterface $event
     *
     * @param callable | Array $next
     *
     * @return mixed
     */
    public function handle(EventInterface $event, callable | Array $next) : mixed;
}
