<?php

/**
 * TechDivision\Import\Listeners\InitializeRegistryListener
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use TechDivision\Import\Utils\CacheKeys;
use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Configuration\ConfigurationInterface;
use TechDivision\Import\Services\RegistryProcessorInterface;

/**
 * An listener implementation that initializes the registry.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class InitializeRegistryListener extends AbstractListener
{

    /**
     * The RegistryProcessor instance to handle running threads.
     *
     * @var \TechDivision\Import\Services\RegistryProcessorInterface
     */
    protected $registryProcessor;

    /**
     * The configuration instance.
     *
     * @var \TechDivision\Import\Configuration\ConfigurationInterface
     */
    protected $configuration;

    /**
     * Initializes the event.
     *
     * @param \TechDivision\Import\Configuration\ConfigurationInterface $configuration     The configuration instance
     * @param \TechDivision\Import\Services\RegistryProcessorInterface  $registryProcessor The registry processor instance
     */
    public function __construct(ConfigurationInterface $configuration, RegistryProcessorInterface $registryProcessor)
    {
        $this->configuration = $configuration;
        $this->registryProcessor = $registryProcessor;
    }

    /**
     * Handle the event.
     *
     * @param \League\Event\EventInterface $event The event that triggered the listener
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {

        // initialize the status
        $status = array(
            RegistryKeys::STATUS                => 1,
            RegistryKeys::BUNCHES               => 0,
            RegistryKeys::STARTED_AT            => time(),
            RegistryKeys::FINISHED_AT           => 0,
            RegistryKeys::SOURCE_DIRECTORY      => $this->getConfiguration()->getSourceDir(),
            RegistryKeys::TARGET_DIRECTORY      => $this->getConfiguration()->getTargetDir(),
            RegistryKeys::MISSING_OPTION_VALUES => array()
        );

        // register the status and the references in the registry (use the serial as tag also)
        $this->getRegistryProcessor()->setAttribute(CacheKeys::STATUS, $status);
    }

    /**s
     * Return's the RegistryProcessor instance to handle the running threads.
     *
     * @return \TechDivision\Import\Services\RegistryProcessor The registry processor instance
     */
    protected function getRegistryProcessor()
    {
        return $this->registryProcessor;
    }

    /**
     * Returns the configuration instance.
     *
     * @return \TechDivision\Import\Configuration\ConfigurationInterface The configuration instance
     */
    protected function getConfiguration()
    {
        return $this->configuration;
    }
}
