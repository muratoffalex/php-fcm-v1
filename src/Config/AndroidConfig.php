<?php
/**
 * Created by PhpStorm.
 * User: lkaybob
 * Date: 31/03/2018
 * Time: 00:04
 */

namespace phpFCMv1\Config;

class AndroidConfig implements CommonConfig {
    const PRIORITY_HIGH = 'HIGH', PRIORITY_NORMAL = 'NORMAL';

    const CLICK_ACTION = 'click_action';
    const SOUND = 'sound';
    const ICON = 'icon';
    const TAG = 'tag';
    const COLOR = 'color';

    // notification
    const PRIORITY = 'priority';
    const COLLAPSE_KEY = 'collapse_key';
    const TIME_TO_LIVE = 'ttl';

    private $notification;
    private $payload;

    public function __construct()
    {
        $this->notification = [];
        $this->payload = [];
    }

    private function setPayload(string $name, $value) {
        $this->payload[$name] = $value;

        return $this;
    }

    private function setNotification(string $name, $value) {
        $this->notification[$name] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    function setCollapseKey($key) {
        return $this->setPayload(SELF::COLLAPSE_KEY, $key);;
    }

    /**
     * @param $color
     * @return $this
     */
    function setColor($color) {
        return $this->setNotification(SELF::COLOR, $color);
    }

    /**
     * @param $icon
     * @return $this
     */
    function setIcon($icon) {
        return $this->setNotification(SELF::ICON, $icon);
    }

    /**
     * @param $tag
     * @return $this
     */
    function setTag($tag) {
        return $this->setNotification(SELF::TAG, $tag);
    }

    /**
     * @param $priority
     * @return mixed
     */
    function setPriority($priority) {
        return $this->setPayload(SELF::PRIORITY, $priority);
    }

    /**
     * @param $actionName
     * @return mixed
     */
    function setClickAction($actionName) {
        return $this->setNotification(SELF::CLICK_ACTION, $actionName);
    }

    /**
     * @param $sound
     * @return mixed
     */
    function setSound($sound) {
        return $this->setNotification(SELF::SOUND, $sound);
    }

    /**
     * @param $time
     * @return mixed
     */
    function setTimeToLive($time) {
        return $this->setPayload(SELF::TIME_TO_LIVE, $time . 's');
    }

    /**
     * Set custom notification settings
     *
     * @param string $name
     * @param mixed $value
     */
    function setCustomNotificationSettings(string $name, $value) {
        return $this->setNotification($name, $value);
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (!empty($this->notification)) {
            $this->payload["notification"] = $this->notification;
        }

        if (!empty($this->payload)) {
            return [
                'android' => $this->payload
            ];
        } else {
            return [];
        }
    }

    function __invoke() {
        return $this -> getPayload();
    }
}