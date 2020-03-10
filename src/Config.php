<?php
/**
 * Created by PhpStorm.
 * User: lkaybob
 * Date: 05/04/2018
 * Time: 20:12
 */

namespace phpFCMv1;

use phpFCMv1\Config\AndroidConfig;
use phpFCMv1\Config\APNsConfig;
use phpFCMv1\Config\CommonConfig;

class Config implements CommonConfig {
    const PRIORITY_HIGH = 1;
    const PRIORITY_NORMAL = 2;

    public $androidConfig;
    public $apnsConfig;

    public function __construct() {
        $this -> androidConfig = new AndroidConfig();
        $this -> apnsConfig = new APNsConfig();
    }

    /**
     * @param string $key
     * @return $this
     */
    function setCollapseKey($key) {
        $this -> androidConfig -> setCollapseKey($key);
        $this -> apnsConfig -> setCollapseKey($key);

        return $this;
    }

    /**
     * only for android
     *
     * @param $icon
     * @return $this
     */
    function setIcon($icon) {
        $this->androidConfig->setIcon($icon);

        return $this;
    }

    /**
     * only for android
     *
     * @param $tag
     * @return $this
     */
    function setTag($tag) {
        $this->androidConfig->setTag($tag);

        return $this;
    }

    /**
     * only for android
     *
     * @param $color
     * @return $this
     */
    function setColor($color) {
        $this->androidConfig->setColor($color);

        return $this;
    }

    /**
     * @param string $actionName
     * @return $this
     */
    function setClickAction($actionName) {
        $this -> androidConfig -> setClickAction($actionName);
        $this -> apnsConfig -> setClickAction($actionName);

        return $this;
    }

    /**
     * ios only: Will add small red bubbles indicating the number of notifications to your apps icon
     *
     * @param integer $badge
     * @return $this
     */
    function setBadge($badge) {
        $this->apnsConfig->setBadge($badge);

        return $this;
    }

    /**
     * @param string $sound
     * @return $this
     */
    function setSound($sound) {
        $this -> androidConfig -> setSound($sound);
        $this -> apnsConfig -> setSound($sound);

        return $this;
    }

    /**
     * @param integer $priority
     * @return $this
     */
    function setPriority($priority) {
        switch ($priority) {
            case self::PRIORITY_HIGH:
                $this -> androidConfig -> setPriority(AndroidConfig::PRIORITY_HIGH);
                $this -> apnsConfig -> setPriority(APNsConfig::PRIORITY_HIGH);
                break;
            case self::PRIORITY_NORMAL:
                $this -> androidConfig -> setPriority(AndroidConfig::PRIORITY_NORMAL);
                $this -> apnsConfig -> setPriority(APNsConfig::PRIORITY_NORMAL);
                break;
            default:
                throw new \InvalidArgumentException("Priority option not proper");
                break;
        }

        return $this;
    }

    /**
     * Only for ios
     *
     * @param string $type
     */
    function setPushType(string $type) {
        $this->apnsConfig->setPushType($type);

        return $this;
    }

    /**
     * @param integer $time : seconds
     * @return $this
     */
    function setTimeToLive($time) {
        try {
            $this -> androidConfig -> setTimeToLive($time);
            $this -> apnsConfig -> setTimeToLive($time);
        } catch (\Exception $e) {

        }

        return $this;
    }

    /**
     * @return mixed
     */
    function getPayload() {
        $androidConfig = $this -> androidConfig -> getPayload();
        $apnsConfig = $this -> apnsConfig -> getPayload();

        return array_merge($androidConfig, $apnsConfig);
    }

    function __invoke() {
        return $this -> getPayload();
    }
}