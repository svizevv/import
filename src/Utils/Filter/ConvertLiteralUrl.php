<?php

/**
 * TechDivision\Import\Utils\Filter\ConvertLiteralUrl
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Utils\Filter;

/**
 * Filter to convert URLs.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class ConvertLiteralUrl extends ConvertLiteral
{
    /**
     * Filter and return the value.
     *
     * @param string $string The value to filter
     *
     * @return string The filtered value
     */
    public function filter($string)
    {

        // replace all characters that are not numbers or simple chars
        $string = preg_replace('#[^0-9a-z]+#i', '-', parent::filter($string));
        $string = strtolower($string);
        $string = trim($string, '-');

        // return the converted URL
        return $string;
    }
}
