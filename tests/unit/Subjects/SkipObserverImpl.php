<?php

/**
 * TechDivision\Import\Subjects\SkipObserverImpl
 *
* PHP version 7
*
* @author    Tim Wagner <t.wagner@techdivision.com>
* @copyright 2016 TechDivision GmbH <info@techdivision.com>
* @license   https://opensource.org/licenses/MIT
* @link      https://github.com/techdivision/import
* @link      http://www.techdivision.com
*/

namespace TechDivision\Import\Subjects;

use TechDivision\Import\Observers\ObserverInterface;

/**
 * Mock observer that invokes a subject's skip() method.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class SkipObserverImpl implements ObserverInterface
{

    /**
     * Will be invoked by the action on the events the listener has been registered for.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return array The modified row
     * @see \TechDivision\Import\Observers\ObserverInterface::handle()
     */
    public function handle(SubjectInterface $subject)
    {
        $subject->skipRow();
        return $subject->getRow();
    }

    /**
     * Set's the obeserver's subject instance to initialize the observer with.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The observer's subject
     *
     * @return void
     */
    public function setSubject($subject)
    {
    }

    /**
     * Return's the observer's subject instance.
     *
     * @return \TechDivision\Import\Subjects\SubjectInterface The observer's subject instance
     */
    public function getSubject()
    {
    }
}
