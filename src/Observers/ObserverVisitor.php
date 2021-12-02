<?php

/**
 * TechDivision\Import\Observers\ObserverVisitor
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Observers;

use TechDivision\Import\Subjects\SubjectInterface;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;

/**
 * Visitor implementation for a subject's observers.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class ObserverVisitor implements ObserverVisitorInterface
{

    /**
     * The DI container builder instance.
     *
     * @var \Symfony\Component\DependencyInjection\TaggedContainerInterface
     */
    protected $container;

    /**
     * The constructor to initialize the instance.
     *
     * @param \Symfony\Component\DependencyInjection\TaggedContainerInterface $container The container instance
     */
    public function __construct(TaggedContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Visitor implementation that initializes the observers of the passed subject.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject to initialize the observers for
     *
     * @return void
     */
    public function visit(SubjectInterface $subject)
    {

        // load the observers from the configuration
        $availableObservers = $subject->getConfiguration()->getObservers();

        // prepare the observers
        foreach ($availableObservers as $observers) {
            $this->prepareObservers($subject, $observers);
        }
    }

    /**
     * Prepare the observers defined in the system configuration.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject   The subject to prepare the observers for
     * @param array                                          $observers The array with the observers
     * @param string                                         $type      The actual observer type
     *
     * @return void
     */
    protected function prepareObservers(SubjectInterface $subject, array $observers, $type = null)
    {

        // iterate over the array with observers and prepare them
        foreach ($observers as $key => $observer) {
            // we have to initialize the type only on the first level
            if ($type == null) {
                $type = $key;
            }

            // query whether or not we've an subarry or not
            if (is_array($observer)) {
                $this->prepareObservers($subject, $observer, $type);
            } else {
                // create the instance of the observer/factory
                $instance = $this->container->get($observer);
                // query whether or not a factory has been specified
                if ($instance instanceof ObserverFactoryInterface) {
                    $observ = $instance->createObserver($subject);
                    $observ->setSubject($subject);
                    $subject->registerObserver($observ, $type);
                } elseif ($instance instanceof ObserverInterface) {
                    $subject->registerObserver($instance, $type);
                } else {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Instance of "%s" doesn\'t implement interface "%s" or "%s"',
                            $observer,
                            ObserverFactoryInterface::class,
                            ObserverInterface::class
                        )
                    );
                }
            }
        }
    }
}
