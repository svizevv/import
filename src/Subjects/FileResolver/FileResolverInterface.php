<?php

/**
 * TechDivision\Import\Subjects\FileResolver\FileResolverInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Subjects\FileResolver;

use TechDivision\Import\Adapter\FilesystemAdapterInterface;
use TechDivision\Import\Configuration\SubjectConfigurationInterface;

/**
 * Interface for all file resolver implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
interface FileResolverInterface
{

    /**
     * Return's the matches of all filters.
     *
     * @return array The array with the matches
     */
    public function getMatches() : array;

    /**
     * Reset's the registered filters.
     *
     * @return void
     */
    public function reset() : void;

    /**
     * Set's the subject configuration instance.
     *
     * @param \TechDivision\Import\Configuration\SubjectConfigurationInterface $subjectConfiguration The subject configuration
     *
     * @return void
     */
    public function setSubjectConfiguration(SubjectConfigurationInterface $subjectConfiguration) : void;

    /**
     * Return's the subject configuration instance.
     *
     * @return \TechDivision\Import\Configuration\SubjectConfigurationInterface The subject configuration
     */
    public function getSubjectConfiguration() : SubjectConfigurationInterface;

    /**
     * Set's the filesystem adapter instance.
     *
     * @param \TechDivision\Import\Adapter\FilesystemAdapterInterface $filesystemAdapter The filesystem adapter instance
     *
     * @return void
     */
    public function setFilesystemAdapter(FilesystemAdapterInterface $filesystemAdapter) : void;

    /**
     * Return's the filesystem adapter instance.
     *
     * @return \TechDivision\Import\Adapter\FilesystemAdapterInterface The filesystem adapter instance
     */
    public function getFilesystemAdapter() : FilesystemAdapterInterface;

    /**
     * Loads the files from the source directory and return's them sorted.
     *
     * @param string $serial The unique identifier of the actual import process
     *
     * @return array The array with the files matching the subjects suffix
     * @throws \Exception Is thrown, when the source directory is NOT available
     */
    public function loadFiles(string $serial) : array;
}
