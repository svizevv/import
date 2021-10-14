<?php

/**
 * TechDivision\Import\Adapter\FilesystemAdapterInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Adapter;

/**
 * Interface for the filesystem adapters.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface FilesystemAdapterInterface
{

    /**
     * Creates a new directroy.
     *
     * @param string  $pathname The directory path
     * @param integer $mode     The mode is 0700 by default, which means the widest possible access
     *
     * @return boolean TRUE on success, else FALSE
     */
    public function mkdir($pathname, $mode = 0755);

    /**
     * Query whether or not the passed filename exists.
     *
     * @param string $filename The filename to query
     *
     * @return boolean TRUE if the passed filename exists, else FALSE
     */
    public function isFile($filename);

    /**
     * Tells whether the filename is a directory.
     *
     * @param string $filename Path to the file
     *
     * @return TRUE if the filename exists and is a directory, else FALSE
     */
    public function isDir($filename);

    /**
     * Creates an empty file with the passed filename.
     *
     * @param string $filename The name of the file to create
     *
     * @return boolean TRUE if the file can be created, else FALSE
     */
    public function touch($filename);

    /**
     * Renames a file or directory.
     *
     * @param string $oldname The old name
     * @param string $newname The new name
     *
     * @return boolean TRUE on success, else FALSE
     */
    public function rename($oldname, $newname);

    /**
     * Writes the passed data to file with the passed name.
     *
     * @param string $filename The name of the file to write the data to
     * @param string $data     The data to write to the file
     *
     * @return number The number of bytes written to the file
     */
    public function write($filename, $data);

    /**
     * Delete the file with the passed name.
     *
     * @param string $filename The name of the file to be deleted
     *
     * @return boolean TRUE on success, else FALSE
     */
    public function delete($filename);

    /**
     * Copy's a file from source to destination.
     *
     * @param string $src  The source file
     * @param string $dest The destination file
     *
     * @return boolean TRUE on success, else FALSE
     */
    public function copy($src, $dest);

    /**
     * List the filenames of a directory.
     *
     * @param string  $directory The directory to list
     * @param boolean $recursive Whether to list recursively
     *
     * @return array A list of filenames
     */
    public function listContents($directory = '', $recursive = false);

    /**
     * Removes the passed directory recursively.
     *
     * @param string  $src       Name of the directory to remove
     * @param boolean $recursive TRUE if the directory has to be deleted recursive, else FALSE
     *
     * @return void
     * @throws \Exception Is thrown, if the directory can not be removed
     */
    public function removeDir($src, $recursive = false);

    /**
     * Find and return pathnames matching a pattern
     *
     * @param string $pattern No tilde expansion or parameter substitution is done.
     * @param int    $flags   Flags that changes the behaviour
     *
     * @return array Containing the matched files/directories, an empty array if no file matched or FALSE on error
     */
    public function glob(string $pattern, int $flags = 0);

    /**
     * Return's the size of the file with the passed name.
     *
     * @param string $filename The name of the file to return the size for
     *
     * @return int The size of the file in bytes
     * @throws \Exception  Is thrown, if the size can not be calculated
     */
    public function size($filename);

    /**
     * Read's and return's the content of the file with the passed name as array.
     *
     * @param string $filename The name of the file to return its content for
     *
     * @return array The content of the file as array
     * @throws \Exception  Is thrown, if the file is not accessible
     */
    public function read($filename);
}
