<?php

/**
 * TechDivision\Import\Utils\TablePrefixUtil
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils;

use TechDivision\Import\Configuration\ConfigurationInterface;
use TechDivision\Import\Services\RegistryProcessorInterface;

/**
 * Utility class for table prefix handling.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class TablePrefixUtil implements TablePrefixUtilInterface
{

    /**
     * The configuration instance.
     *
     * @var \TechDivision\Import\Configuration\ConfigurationInterface
     */
    protected $configuration;

    /**
     * The import processor instance.
     *
     * @var \TechDivision\Import\Services\RegistryProcessorInterface
     */
    private $registryProcessor;

    /**
     * Construct a new instance.
     *
     * @param \TechDivision\Import\Configuration\ConfigurationInterface $configuration     The configuration instance
     * @param \TechDivision\Import\Services\RegistryProcessorInterface  $registryProcessor The registry Processor instance
     */
    public function __construct(
        ConfigurationInterface $configuration,
        RegistryProcessorInterface $registryProcessor
    ) {
        $this->configuration = $configuration;
        $this->registryProcessor = $registryProcessor;
    }
    
    /**
     * Return's the registry processor instance.
     *
     * @return \TechDivision\Import\Services\RegistryProcessorInterface The registry processor instance
     */
    public function getRegistryProcessor() : RegistryProcessorInterface
    {
        return $this->registryProcessor;
    }
    
    /**
     * Returns the prefixed table name.
     *
     * @param string $tableName The table name to prefix
     *
     * @return string The prefixed table name
     * @throws \Exception Is thrown if the table name can't be prefixed
     */
    public function getPrefixedTableName($tableName)
    {

        // try to load the table prefix from the configuration
        if ($tablePrefix = $this->configuration->getDatabase()->getTablePrefix()) {
            $tableName = sprintf('%s%s', $tablePrefix, $tableName);
        }

        // return the prefixed table name
        return $tableName;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration(): ConfigurationInterface
    {
        return $this->configuration;
    }
    
    /**
     * Compiles the passed SQL statement.
     *
     * @param string $statement The SQL statement to compile
     *
     * @return string The compiled SQL statement
     */
    public function compile($statement)
    {
        return preg_replace_callback(sprintf('/\$\{%s:(.*)\}/U', TablePrefixUtilInterface::TOKEN), function (array $matches) {
            return $this->getPrefixedTableName($matches[1]);
        }, $statement);
    }
}
