<?php

/**
 * TechDivision\Import\Services\RegistryProcessor
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Services;

use TechDivision\Import\Cache\CacheAdapterInterface;

/**
 * Array based implementation of a registry.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class RegistryProcessor implements RegistryProcessorInterface
{

    /**
     * The cache adapter instance.
     *
     * @var \TechDivision\Import\Cache\CacheAdapterInterface
     */
    protected $cacheAdapter;

    /**
     * Initialize the repository with the passed connection and utility class name.
     *
     * @param \TechDivision\Import\Cache\CacheAdapterInterface $cacheAdapter The cache adapter instance
     */
    public function __construct(CacheAdapterInterface $cacheAdapter)
    {
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * Register the passed attribute under the specified key in the registry.
     *
     * @param string  $key        The cache key to use
     * @param mixed   $value      The value that has to be cached
     * @param array   $references An array with references to add
     * @param array   $tags       An array with tags to add
     * @param boolean $override   Flag that allows to override an exising cache entry
     *
     * @return void
     * @throws \Exception Is thrown, if the key has already been used
     */
    public function setAttribute($key, $value, array $references = array(), array $tags = array(), $override = false)
    {
        $this->cacheAdapter->toCache($key, $value, $references, $tags, $override);
    }

    /**
     * Return's the attribute with the passed key from the registry.
     *
     * @param mixed $key The key to return the attribute for
     *
     * @return mixed The requested attribute
     */
    public function getAttribute($key)
    {
        return $this->cacheAdapter->fromCache($key);
    }

    /**
     * Query whether or not an attribute with the passed key has already been registered.
     *
     * @param mixed $key The key to query for
     *
     * @return boolean TRUE if the attribute has already been registered, else FALSE
     */
    public function hasAttribute($key)
    {
        return $this->cacheAdapter->isCached($key);
    }

    /**
     * Remove the attribute with the passed key from the registry.
     *
     * @param mixed $key The key of the attribute to return
     *
     * @return void
     */
    public function removeAttribute($key)
    {
        $this->cacheAdapter->removeCache($key);
    }

    /**
     * Flush the cache.
     *
     * @return void
     */
    public function flushCache()
    {
        $this->cacheAdapter->flushCache();
    }

    /**
     * Raises the value for the attribute with the passed key by one.
     *
     * @param mixed $key         The key of the attribute to raise the value for
     * @param mixed $counterName The name of the counter to raise
     *
     * @return integer The counter's new value
     */
    public function raiseCounter($key, $counterName)
    {
        return $this->cacheAdapter->raiseCounter($key, $counterName);
    }

    /**
     * Lowers the value for the attribute with the passed key by one.
     *
     * @param mixed $key         The key of the attribute to lower the value for
     * @param mixed $counterName The name of the counter to lower
     *
     * @return integer The counter's new value
     */
    public function lowerCounter($key, $counterName)
    {
        return $this->cacheAdapter->lowerCounter($key, $counterName);
    }

    /**
     * This method merges the passed attributes with an array that
     * has already been added under the passed key.
     *
     * If no value will be found under the passed key, the attributes
     * will simply be registered.
     *
     * @param mixed $key        The key of the attributes that has to be merged with the passed ones
     * @param array $attributes The attributes that has to be merged with the exising ones
     *
     * @return void
     * @throws \Exception Is thrown, if the already registered value is no array
     * @link http://php.net/array_replace_recursive
     */
    public function mergeAttributesRecursive($key, array $attributes)
    {
        $this->cacheAdapter->mergeAttributesRecursive($key, $attributes);
    }

    /**
     * Load's the data with the passed key from the registry.
     *
     * @param string $key       The key of the data to load
     * @param string $delimiter The delimiter to explode the key with
     *
     * @return mixed The data
     */
    public function load($key, $delimiter = '.')
    {

        // explode the key elements by the passed delimiter
        $elements = explode($delimiter, $key);

        // load the data for the first key element
        $data = $this->getAttribute(array_shift($elements)) ;

        // try to resolve the data recursively by the key elemens
        while ($k = array_shift($elements)) {
            if (isset($data[$k])) {
                $data = $data[$k];
            } else {
                throw new \InvalidArgumentException(sprintf('Can\'t resolve data for registry key "%s"', $k));
            }
        }

        // finally return the loaded data
        return $data;
    }
}
