<?php

/**
 * TechDivision\Import\Subjects\FileResolver\MoveFilesFileResolver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Subjects\FileResolver;

use TechDivision\Import\Configuration\ConfigurationInterface;
use TechDivision\Import\Services\RegistryProcessorInterface;
use TechDivision\Import\Configuration\Subject\FileResolverConfigurationInterface;
use TechDivision\Import\Utils\BunchKeys;

/**
 * A custom file resolver implementation for the move files subject
 * that try's to load the prefix from the configuration.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class MoveFilesFileResolver extends OkFileAwareFileResolver
{

    /**
     * The configuration instance.
     *
     * @var \TechDivision\Import\Configuration\ConfigurationInterface
     */
    private $configuration;

    /**
     * Initializes the file resolver with the application and the registry instance.
     *
     * @param \TechDivision\Import\Configuration\ConfigurationInterface $configuration     The configuration instance
     * @param \TechDivision\Import\Services\RegistryProcessorInterface  $registryProcessor The registry instance
     */
    public function __construct(
        ConfigurationInterface $configuration,
        RegistryProcessorInterface $registryProcessor
    ) {

        // pass the application + registry processor to the parent class
        parent::__construct($registryProcessor);

        // set the configuration instance
        $this->configuration = $configuration;
    }

    /**
     * Return's the configuration instance.
     *
     * @return \TechDivision\Import\Configuration\ConfigurationInterface The configuration instance
     */
    protected function getConfiguration() : ConfigurationInterface
    {
        return $this->configuration;
    }

    /**
     * Returns the file resolver configuration instance.
     *
     * @return \TechDivision\Import\Configuration\Subject\FileResolverConfigurationInterface The configuration instance
     */
    protected function getFileResolverConfiguration() : FileResolverConfigurationInterface
    {

        // load the file resolver configuration from the parent instance
        $fileResolverConfiguration = parent::getFileResolverConfiguration();

        // reduce the pattern elements in case a specific
        // file has been given as commandline argument
        if ($this->getConfiguration()->getFilename()) {
            $fileResolverConfiguration->setPatternElements(array(BunchKeys::FILENAME));
        }

        // use the move files prefix from the configuration
        if (empty($this->getConfiguration()->getFilename()) &&
            $moveFilesPrefix = $this->getConfiguration()->getMoveFilesPrefix()
        ) {
            $fileResolverConfiguration->setPrefix($moveFilesPrefix);
        }

        // return the customized file resolver configuration
        return $fileResolverConfiguration;
    }
}
