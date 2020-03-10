<?php
/**
 * Created by PhpStorm.
 * User: lkaybob
 * Date: 31/03/2018
 * Time: 00:12
 */

namespace phpFCMv1\Config;

use DateInterval;
use DateTime;
use Exception;

class APNsConfig implements CommonConfig {
    const PRIORITY_HIGH = '10', PRIORITY_NORMAL = '5';

    // headers
    const COLLAPSE_KEY = 'apns-collapse-id';
    const PRIORITY = 'apns-priority';
    const PUSH_TYPE = 'apns-push-type';
    const EXPIRATION = 'apns-expiration';

    // aps
    const SOUND = 'sound';
    const BADGE = 'badge';
    const CLICK_ACTION = 'category';

    const PUSH_TYPE_BACKGROUND = 'background',
        PUSH_TYPE_ALERT = 'alert',
        PUSH_TYPE_VOIP = 'voip',
        PUSH_TYPE_COMPLICATION = 'complication',
        PUSH_TYPE_FILEPROVIDER = 'fileprovider',
        PUSH_TYPE_MDM = 'mdm';

    private $headers;
    private $aps;

    public function __construct()
    {
        $this->headers = [];
        $this->aps = [];
    }

    public function __invoke() {
        return $this->getPayload();
    }

    function setHeader(string $name, $value) {
        $this->headers[$name] = $value;

        return $this;
    }

    function setAPS(string $name, $value) {
        $this->aps[$name] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    function setCollapseKey($key) {
        return $this->setHeader(SELF::COLLAPSE_KEY, $key);
    }

    /**
     * @param integer $priority
     * @return mixed
     */
    function setPriority($priority) {
        return $this->setHeader(SELF::PRIORITY);
    }

    /**
     * For ios 13
     *
     * @param string $pushType
     * @return $this
     */
    function setPushType($pushType) {
        return $this->setHeader(SELF::PUSH_TYPE, $pushType);
    }

    /**
     * @param string $sound
     * @return mixed
     */
    function setSound($sound) {
        return $this->setAPS(SELF::SOUND, $sound);
    }

    /**
     * Will add small red bubbles indicating the number of notifications to your apps icon
     *
     * @param integer $sound
     * @return mixed
     */
    function setBadge($badge) {
        return $this->setAPS(SELF::BADGE, $badge);
    }

    /**
     * @param string $actionName
     * @return mixed
     */
    function setClickAction($actionName) {
        return $this->setAPS(SELF::CLICK_ACTION, $actionName);
    }

    /**
     * @param $time : Time for notification to live in seconds
     * @return mixed    : Expiration option using UNIX epoch date
     * @throws Exception
     */
    function setTimeToLive($time) {
        $expiration = DateTime::createFromFormat('U', $this->roundUpMilliseconds());
        $expiration -> add(new DateInterval('PT' . $time . 'S'));
        $expValue = $expiration -> format('U');

        return $this->setHeader(SELF::EXPIRATION, $expValue);
    }

    /**
     * @return array
     */
    public function getPayload() {
        $payload = array();

        if (!empty($this->headers)) {
            $payload['headers'] = $this->headers;
        }

        if (!empty($this->aps)) {
            $payload['payload'] = array('aps' => $this->aps);
        }

        if (!empty($payload)) {
            return [
                'apns' => $payload
            ];
        } else {
            return [];
        }
    }

    /**
     * Path for PHP@7.2. Refer to the issue.
     * https://github.com/lkaybob/php-fcm-v1/issues/3
     * @return string
     */
    private function roundUpMilliseconds() {
        $converted = new DateTime('now');

        if ($converted->format('u') != 0 && strpos(PHP_VERSION,'7.1') !== 0) {
            $converted = $converted->add(new DateInterval('PT1S'));
        }

        return $converted->format('U');
    }
}