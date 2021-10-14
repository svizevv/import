<?php

/**
 * TechDivision\Import\Listeners\RenderAnsiArtListener
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use TechDivision\Import\ApplicationInterface;

/**
 * A listener implementation that renders the ANSI art.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class RenderAnsiArtListener extends AbstractListener
{

    /**
     * The TechDivision company name as ANSI art.
     *
     * @var string
     */
    protected $ansiArt = <<<ART
 _______        _     _____  _       _     _
|__   __|      | |   |  __ \(_)     (_)   (_)
   | | ___  ___| |__ | |  | |___   ___ ___ _  ___  _ __
   | |/ _ \/ __| \_ \| |  | | \ \ / / / __| |/ _ \| \_ \
   | |  __/ (__| | | | |__| | |\ V /| \__ \ | (_) | | | |
   |_|\___|\___|_| |_|_____/|_| \_/ |_|___/_|\___/|_| |_|
ART;

    /**
     * Handle the event.
     *
     * @param \League\Event\EventInterface              $event       The event that triggered the listener
     * @param \TechDivision\Import\ApplicationInterface $application The application instance
     *
     * @return void
     */
    public function handle(EventInterface $event, ApplicationInterface $application = null)
    {

        // write the TechDivision ANSI art icon to the console
        $application->log($this->ansiArt);
    }
}
