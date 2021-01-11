<?php
/**
 *
 * @description 管道
 *
 * @package     PipelineInterface
 *
 * @time        2019-10-20 17:21:08
 *
 * @author      kovey
 */
namespace Kovey\Pipeline;

use Kovey\Container\ContainerInterface;
use Kovey\Event\EventInterface;

interface PipelineInterface
{
    /**
     * @description 构造
     *
     * @param ContainerInterface $container
     *
     * @return Pipeline
     */
    public function __construct(ContainerInterface $container);

    /**
     * @description 设置请求对象和相应对象
     *
     * @param EventInterface $event
     *
     * @return PipelineInterface
     */
    public function send(EventInterface $event) : PipelineInterface;

    /**
     * @description 设置中间件
     *
     * @param Array $middlewares
     *
     * @return PipelineInterface
     */
    public function through(Array $middlewares) : PipelineInterface;

    /**
     * @description 设置方法
     *
     * @param string $method
     *
     * @return PipelineInterface
     */
    public function via(string $method) : PipelineInterface;

    /**
     * @description 处理函数
     *
     * @param callable | Array $description
     *
     * @return mixed
     */
    public function then(callable | Array $destination) : mixed;
}
