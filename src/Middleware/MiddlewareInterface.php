<?php
/**
 *
 * @description 中间件接口
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
     * @description 中间件实现方法
     *
     * @param EventInterface $event
     *
     * @param callable | Array $next
     *
     * @return mixed
     */
    public function handle(EventInterface $event, callable | Array $next);
}
