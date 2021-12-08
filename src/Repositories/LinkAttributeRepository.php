<?php

/**
 * TechDivision\Import\Repositories\LinkAttributeRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Repositories;

use TechDivision\Import\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Repositories\AbstractRepository;

/**
 * Repository implementation to load link attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class LinkAttributeRepository extends AbstractRepository implements LinkAttributeRepositoryInterface
{

    /**
     * The statement to load the available link attributes.
     *
     * @var \PDOStatement
     */
    protected $linkAttributesStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->linkAttributesStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::LINK_ATTRIBUTES));
    }

    /**
     * Return's an array with all available link attributes.
     *
     * @return array The available link attributes
     */
    public function findAll()
    {
        $this->linkAttributesStmt->execute();
        return $this->linkAttributesStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
