<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 20/10/2016
 * Time: 17:31
 */

namespace User\Utility;


use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Log\Logger;

class LogEvents implements ListenerAggregateInterface
{

    use ListenerAggregateTrait;

    private $log;


    /**
     * LogEvents constructor.
     * @param Logger $log
     */
    public function __construct(Logger $log)
    {
        $this->log = $log;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('do', [$this, 'log']);
        $this->listeners[] = $events->attach('doAnother', [$this, 'log']);
    }

    /**
     *
     */
    public function log(EventInterface $e)
    {
        $event = $e->getName();
        $params = $e->getParams();
        $this->log->info(sprintf('%s: $s', $event, json_encode($params)));
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }

}