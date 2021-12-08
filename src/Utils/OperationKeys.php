<?php

/**
 * TechDivision\Import\Utils\OperationKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils;

/**
 * A utility class for the available operations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class OperationKeys
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * The key for 'move-files' operation.
     *
     * @var string
     */
    const MOVE_FILES = 'move-files';

    /**
     * The key for 'convert' operation.
     *
     * @var string
     */
    const CONVERT = 'convert';

    /**
     * The key for 'add-update' operation.
     *
     * @var string
     */
    const ADD_UPDATE = 'add-update';

    /**
     * The key for 'replace' operation.
     *
     * @var string
     */
    const REPLACE = 'replace';

    /**
     * The key for 'delete' operation.
     *
     * @var string
     */
    const DELETE = 'delete';
}
