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

namespace tool_objectfs\task;

use core\task\adhoc_task;

/**
 * Ad-hoc task to update objects table. Used for async upgrade.
 *
 * @package    tool_objectfs
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2022 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class populate_objects_filesize extends adhoc_task {

    /**
     * Action of task.
     */
    public function execute() {
        global $DB;

        // Get all objects without a filesize and join them to a filesize from the files table.
        $sql = "SELECT o.id, o.contenthash, o.timeduplicated, o.location, f.filesize
                  FROM {tool_objectfs_objects} o
             LEFT JOIN {files} f ON o.contenthash = f.contenthash
                 WHERE o.filesize = 0
              GROUP BY o.id,
                       o.contenthash,
                       f.filesize";
        $records = $DB->get_records_sql($sql);
        foreach ($records as $record) {
            if (!empty($record->filesize)) {
                $DB->update_record('tool_objectfs_objects', $record, true);
            }
        }
    }
}
