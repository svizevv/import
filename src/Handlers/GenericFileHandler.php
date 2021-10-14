<?php

/**
 * TechDivision\Import\Handlers\GenericFileHandler
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Handlers;

use TechDivision\Import\Exceptions\LineNotFoundException;

/**
 * A generic file handler implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class GenericFileHandler implements GenericFileHandlerInterface
{

    /**
     * Remove's the passed line from the file with the passed name.
     *
     * @param string $line     The line to be removed
     * @param string $filename The name of the file the line has to be removed from
     *
     * @return void
     * @throws \TechDivision\Import\Exceptions\LineNotFoundException Is thrown, if the requested line can not be found in the file
     * @throws \Exception Is thrown, if the file can not be written, after the line has been removed
     * @see \TechDivision\Import\Handlers\GenericFileHandlerInterface::removeLineFromFile()
     */
    public function removeLineFromFilename(string $line, string $filename) : void
    {
        $fh = fopen($filename, 'r+');
        $this->removeLineFromFile($line, $fh);
        fclose($fh);
    }

    /**
     * Remove's the passed line from the file with the passed file handle.
     *
     * @param string   $line The line to be removed
     * @param resource $fh   The file handle of the file the line has to be removed
     *
     * @return void
     * @throws \TechDivision\Import\Exceptions\LineNotFoundException Is thrown, if the requested line can not be found in the file
     * @throws \Exception Is thrown, if the file can not be written, after the line has been removed
     */
    public function removeLineFromFile(string $line, $fh) : void
    {

        // initialize the array for the PIDs found in the PID file
        $lines = array();

        // initialize the flag if the line has been found
        $found = false;

        // rewind the file pointer
        rewind($fh);

        // read the lines with the PIDs from the PID file
        while (($buffer = fgets($fh, 4096)) !== false) {
            // remove the new line
            $buffer = trim($buffer);
            // if the line is the one to be removed, ignore the line
            if ($line === $buffer) {
                $found = true;
                continue;
            }

            // add the found PID to the array
            $lines[] = $buffer;
        }

        // query whether or not, we found the line
        if ($found === false) {
            throw new LineNotFoundException(sprintf('Line "%s" can not be found', $line));
        }

        // empty the file and rewind the file pointer
        ftruncate($fh, 0);
        rewind($fh);

        // append the existing lines to the file
        foreach ($lines as $ln) {
            if (fwrite($fh, $ln . PHP_EOL) === false) {
                throw new \Exception(sprintf('Can\'t write "%s" to file', $ln));
            }
        }

        // clear the file status cache
        clearstatcache();
    }
}
