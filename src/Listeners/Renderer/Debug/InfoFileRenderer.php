<?php

/**
 * TechDivision\Import\Listeners\Renderer\Debug\InfoFileRenderer
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
 * A renderer for the PHP info.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-cli
 * @link      http://www.techdivision.com
 */
class InfoFileRenderer extends AbstractDebugRenderer
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

        // render the PHP info content
        ob_start();
        phpinfo();

        // finally write the PHP info to a file in the source directory
        $this->write(ob_get_clean(), sprintf('%s/debug-php-info.txt', $sourceDir));
    }
}
