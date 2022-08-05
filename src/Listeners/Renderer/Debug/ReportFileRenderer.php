<?php

/**
 * TechDivision\Import\Listeners\Renderer\Debug\ReportFileRenderer
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Listeners\Renderer\Debug;

use TechDivision\Import\Utils\RegistryKeys;

/**
 * A renderer for a simple debug report.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-cli
 * @link      http://www.techdivision.com
 */
class ReportFileRenderer extends AbstractDebugRenderer
{

    /**
     * Renders the data to some output, e. g. the console or a logger.
     *
     * @param string $serial The serial of the import to render the dump artefacts for
     *
     * @return void
     */
    public function render(string $serial = null)
    {

        // load the actual status
        $status = $this->getRegistryProcessor()->getAttribute(RegistryKeys::STATUS);

        // clear the filecache
        clearstatcache();

        // query whether or not the configured source directory is available
        if (!is_dir($sourceDir = $status[RegistryKeys::SOURCE_DIRECTORY])) {
            throw new \Exception(sprintf('Configured source directory %s is not available!', $sourceDir));
        }

        // initialize the array for the lines
        $lines = array();

        // log the Magento + the system's PHP configuration
        $lines[] = sprintf('Magento Edition: %s', $this->getConfiguration()->getMagentoEdition());
        $lines[] = sprintf('Magento Version: %s', $this->getConfiguration()->getMagentoVersion());
        $lines[] = sprintf('PHP Version: %s', phpversion());
        $lines[] = sprintf('App Version: %s', $this->getApplicationVersion());
        $lines[] = sprintf('Memory Limit: %s', ini_get('memory_limit'));
        $lines[] = sprintf('Executed Command: %s', implode(' ', $_SERVER['argv']));
        $lines[] = sprintf('Working Directory: %s', getcwd());
        $lines[] = '-------------------- Loaded Extensions -----------------------';
        $lines[] = implode(', ', get_loaded_extensions());
        $lines[] = '------------------- Executed Operations ----------------------';
        $lines[] = implode(' > ', $this->getConfiguration()->getOperationNames());
        $lines[] = '------------------- Configuration Files ----------------------';
        $lines[] = implode(PHP_EOL, $this->getConfiguration()->getConfigurationFiles());

        // finally write the debug report to a file in the source directory
        $this->write(implode(PHP_EOL, $lines), sprintf('%s/debug-report.txt', $sourceDir));
    }
}
