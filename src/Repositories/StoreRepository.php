<?php

/**
 * TechDivision\Import\Repositories\StoreRepository
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

use TechDivision\Import\Utils\MemberNames;
use TechDivision\Import\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Repositories\AbstractRepository;

/**
 * Repository implementation to load store data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class StoreRepository extends AbstractRepository implements StoreRepositoryInterface
{

    /**
     * The prepared statement to load the available stores.
     *
     * @var \PDOStatement
     */
    protected $storesStmt;

    /**
     * The prepared statement to load the default store.
     *
     * @var \PDOStatement
     */
    protected $storeDefaultStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->storesStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::STORES));
        $this->storeDefaultStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::STORE_DEFAULT));
    }

    /**
     * Return's an array with the available stores and their
     * store codes as keys.
     *
     * @return array The array with all available stores
     */
    public function findAll()
    {

        // initialize the array with the available stores
        $stores = array();

        // execute the prepared statement
        $this->storesStmt->execute();

        // load the available stores
        $availableStores = $this->storesStmt->fetchAll();

        // fetch the stores and assemble them as array with the store code as key
        foreach ($availableStores as $store) {
            $stores[$store[MemberNames::CODE]] = $store;
        }

        // return the array with the stores
        return $stores;
    }

    /**
     * Return's the default store.
     *
     * @return array The default store
     */
    public function findOneByDefault()
    {

        // execute the prepared statement and return the default store
        $this->storeDefaultStmt->execute();
        return $this->storeDefaultStmt->fetch();
    }
}
