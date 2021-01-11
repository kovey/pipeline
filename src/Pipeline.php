<?php
/**
 *
 * @description 中间件管道
 *
 * @package     Middleware
 *
 * @time        2019-10-19 12:34:45
 *
 * @author      kovey
 */
namespace Kovey\Pipeline;

use Kovey\Container\ContainerInterface;
use Kovey\Event\EventInterface;
use Kovey\Pipeline\Middleware\MiddlewareInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @description event
     *
     * @var EventInterface
     */
    private EventInterface $event;

    /**
     * @description 方法
     *
     * @var string
     */
    private string $method;

    /**
     * @description 容器
     *
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @description 构造
     *
     * @param ContainerInterface $container
     *
     * @return Pipeline
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @description 设置请求对象和相应对象
     *
     * @param EventInterface $event
     *
     * @return Pipeline
     */
    public function send(EventInterface $event) : PipelineInterface
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @description 设置中间件
     *
     * @param Array $middlewares
     *
     * @return Pipeline
     */
    public function through(Array $middlewares) : PipelineInterface
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @description 设置方法
     *
     * @param string $method
     *
     * @return Pipeline
     */
    public function via(string $method) : PipelineInterface
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @description trigger pipe
     *
     * @param callable | Array $description
     *
     * @return mixed
     */
    public function then(callable | Array $destination) : mixed
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares), $this->carry(), $this->prepareDestination($destination)
        );

        return $pipeline($this->event);
    }

    /**
     * @description construct pipe
     *
     * @return callable | Array
     */
    protected function carry() : callable | Array
    {
        return function (callable | Array $stack, string | MiddlewareInterface | callable | Array $pipe) {
            return function (EventInterface $event) use ($pipe, $stack) {
                if (is_callable($pipe)) {
                    return call_user_func($pipe, $event, $stack);
                } elseif (!is_object($pipe)) {
                    list($name, $parameters) = $this->parsePipeString($pipe);

                    $pipe = $this->container->get($name, $event->getTraceId());

                    $parameters = array_merge(array($event, $stack), $parameters);
                } else {
                    $parameters = array($event, $stack);
                }

                return $pipe->{$this->method}(...$parameters);
            };
        };
    }

    /**
     * @description prepare final callback
     *
     * @param callable | Array $description
     *
     * @return callable
     */
    protected function prepareDestination(callable | Array $destination) : callable
    {
        return function (EventInterface $event) use ($destination) {
            return call_user_func($destination, $event);
        };
    }

    /**
     * @description parse pipe params
     *
     * @param string $pipe
     *
     * @return Array
     */
    protected function parsePipeString(string $pipe) : Array
    {
        list($name, $parameters) = array_pad(explode(':', $pipe, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return array($name, $parameters);
    }
}
