<?php

/**
 * TechDivision\Import\Loaders\RegistryLoader
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Loaders;

use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Services\RegistryProcessorInterface;

/**
 * Generic loader for data from the registry.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class RegistryLoader implements LoaderInterface
{

    /**
     * The registry processor instance.
     *
     * @var \TechDivision\Import\Services\RegistryProcessorInterface
     */
    protected $registryProcessor;

    /**
     * Registry key to load the data with.
     *
     * @var string
     */
    protected $registryKey;

    /**
     * Construct that initializes the iterator with the registry processor instance.
     *
     * @param \TechDivision\Import\Services\RegistryProcessorInterface $registryProcessor The registry processor instance
     * @param string                                                   $registryKey       The registry key to load the data with
     */
    public function __construct(RegistryProcessorInterface $registryProcessor, $registryKey = RegistryKeys::STATUS)
    {
        $this->registryProcessor = $registryProcessor;
        $this->registryKey = $registryKey;
    }

    /**
     * Loads and returns data.
     *
     * @return \ArrayAccess The array with the data
     */
    public function load()
    {
        return $this->getRegistryProcessor()->load($this->getRegistryKey());
    }

    /**
     * Return's the registry key to load the data with.
     *
     * @return string The registry key
     */
    protected function getRegistryKey()
    {
        return $this->registryKey;
    }

    /**
     * Return's the registry processor instance.
     *
     * @return \TechDivision\Import\Services\RegistryProcessorInterface The processor instance
     */
    protected function getRegistryProcessor()
    {
        return $this->registryProcessor;
    }
}
