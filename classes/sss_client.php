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
 * S3 client.
 *
 * @package   tool_sssfs
 * @author    Kenneth Hendricks <kennethhendricks@catalyst-au.net>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_sssfs;

use Aws\S3\S3Client;

require_once(__DIR__ . '/../sdk/aws-autoloader.php');

defined('MOODLE_INTERNAL') || die();

define('AWS_API_VERSION', '2006-03-01');
define('AWS_REGION', 'ap-southeast-2');

class sss_client {

    private $s3client;
    private $bucketname;

    public function __construct() {
        global $CFG;

        $config = $CFG->sss_config;

        $this->bucketname = $config['bucket'];

        $this->s3client = S3Client::factory(array(
                'credentials' => array('key' => $config['key'], 'secret' => $config['secret']),
                'version' => AWS_API_VERSION,
                'region' => AWS_REGION
            ));
    }

    public function push_file($filekey, $filecontent) {

        $result = $this->s3client->putObject(array(
                'Bucket' => $this->bucketname,
                'Key' => $filekey,
                'Body' => $filecontent
            ));

        return $result;
    }
}