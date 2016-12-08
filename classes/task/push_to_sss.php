<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Task that pushes files to S3.
 *
 * @package   tool_sssfs
 * @author    Kenneth Hendricks <kennethhendricks@catalyst-au.net>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_sssfs\task;

use tool_sssfs\sss_file_pusher;
use tool_sssfs\sss_client;
use tool_sssfs\sss_file_system;

defined('MOODLE_INTERNAL') || die();

class push_to_sss extends \core\task\scheduled_task {

    /**
     * Get task name
     */
    public function get_name() {
        return get_string('push_to_sss_task', 'tool_sssfs');
    }

    /**
     * Execute task
     */
    public function execute() {
        $client = new sss_client();
        $filesystem = sss_file_system::instance();

        $filepusher = new sss_file_pusher($client, $filesystem);

        $filepusher->push();
    }
}


