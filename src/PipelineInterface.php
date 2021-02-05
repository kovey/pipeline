<?php
/**
 *
 * @description pipeline interface
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
     * @description construct
     *
     * @param ContainerInterface $container
     *
     * @return Pipeline
     */
    public function __construct(ContainerInterface $container);

    /**
     * @description send event
     *
     * @param EventInterface $event
     *
     * @return PipelineInterface
     */
    public function send(EventInterface $event) : PipelineInterface;

    /**
     * @description through middlewares
     *
     * @param Array $middlewares
     *
     * @return PipelineInterface
     */
    public function through(Array $middlewares) : PipelineInterface;

    /**
     * @description via method
     *
     * @param string $method
     *
     * @return PipelineInterface
     */
    public function via(string $method) : PipelineInterface;

    /**
     * @description then callback
     *
     * @param callable | Array $description
     *
     * @return mixed
     */
    public function then(callable | Array $destination) : mixed;
}
