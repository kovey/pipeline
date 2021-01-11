<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-11 15:12:40
 *
 */
namespace Kovey\Pipeline;

require_once __DIR__ . '/Middleware/Valid.php';

use PHPUnit\Framework\TestCase;
use Kovey\Container\Container;
use Kovey\Container\Event\Router;
use Kovey\Pipeline\Middleware\Valid;

class PipelineTest extends TestCase
{
    public function testPipeline()
    {
        $path = '';
        $method = '';

        $pipeline = new Pipeline(new Container());
        $pipeline->send(new Router('/login/test', 'POST'))
                 ->through(array(new Valid()))
                 ->via('handle')
                 ->then(function (Router $event) use (&$path, &$method) {
                     $method = $event->getMethod();
                     $path = $event->getPath();
                 });

        $this->assertEquals('/login/test', $path);
        $this->assertEquals('POST', $method);
    }
}
