<?php

declare(strict_types=1);

namespace App\Model;

use Exception;

class User extends Base
{

    const TABLE_NAME = 'user_list';
    const TABLE_PY = 'userId';
    const TABLE_IMAGE = 'user_Img';
    const TABLE_USERNAME = 'userName';
    const TABLE_EMAIL = 'userEmail';
    const TABLE_MOBILE = 'userMobile';
    const TABLE_PASSWORD = 'userPassword';
    const TABLE_PASS_HASH = 'userHash';
    const TABLE_REG_TIME = 'userRegtime';
    const TABLE_LOGIN_TIME = 'userLoginTime';
    const TABLE_TEMP_TOKEN = 'userTempToken';
    const TABLE_USER_REALNAME = 'userRealName';
    const TABLE_USER_WECHAT = 'userWechat';
    const TABLE_USER_ADDRESS = 'userAddress';

    const TABLE_POSTCODE = 'userPostcode';
    const TABLE_FIRSTNAME = 'userFirstName';
    const TABLE_LASTNAME = 'userLastName';


    const TABLE_INVITI = 'user_inviti';

    const USER_CACHE_TOKEN_NAME = 'userToken.';
    const TABLE_ORDER = array(
        'userId' => 'DESC',
    );

    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;

    public static function getUserSession($userSessionId)
    {
        return self::getCache(self::USER_CACHE_TOKEN_NAME . $userSessionId);
    }

    public static function removeUsersession($tokenName)
    {
        self::deleteCache(self::USER_CACHE_TOKEN_NAME . $tokenName);
    }

    public static function getUserFeild($userSessionId, $feildName = self::TABLE_PY)
    {
        $userInfo = self::getCache(self::USER_CACHE_TOKEN_NAME . $userSessionId);
        return isset($userInfo[$feildName]) ? $userInfo[$feildName] : '';
    }

    public static function checkUserName($userName)
    {
        $isHave = self::getCountByWhere([
            self::TABLE_USERNAME => $userName
        ]);
        if ($isHave > 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkPassword($password)
    {
        if (strlen($password) < 6 || strlen($password) > 32) {
            return false;
        } else {
            return true;
        }
    }

    public static function regUserByWeb($userName, $password, $email, $mobile, $postcode = '', $firstname = '', $lastname = '')
    {
        return self::regToWebUser($userName, $password, $mobile, $email, $postcode, $firstname, $lastname);
    }

    public static function regUserByWeChat($userName, $openId, $address, $sex, $images, $inviti)
    {
        $userName = preg_replace("/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u", "", $userName);
        return self::Insert([
            self::TABLE_USERNAME => $userName,
            self::TABLE_EMAIL => '',
            self::TABLE_MOBILE => '',
            self::TABLE_PASSWORD => password_hash('12345678', PASSWORD_DEFAULT),
            self::TABLE_USER_WECHAT => '',
            'sex' => $sex,
            self::TABLE_PASS_HASH => time(),
            self::TABLE_REG_TIME => time(),
            self::TABLE_USER_ADDRESS => $address,
            self::TABLE_INVITI => intval($inviti),
            self::TABLE_IMAGE => $images,
            'openId' => $openId
        ], true);
    }

    public static function getOpenId($Id)
    {
        return self::getByWhere([
            'openId' => trim($Id)
        ]);
    }

    public static function loginUser($userName, $password)
    {
        $userInfo = self::getByWhere([
            self::TABLE_USERNAME => trim($userName)
        ]);
        if (empty($userInfo)) {
            throw new Exception('User not already exists');
        }
        if (password_verify($password, $userInfo[self::TABLE_PASSWORD]) == false) {
            throw new Exception('Password verify fail');
        }
        $tempToken = self::createLoginUserInfo($userInfo);
        return $tempToken;
    }

    public static function loginByUserId($userId)
    {
        $userInfo = self::getByWhere([
            self::TABLE_PY => $userId
        ]);
        return self::createLoginUserInfo($userInfo);
    }

    private static function createLoginUserInfo($userInfo)
    {
        $tempToken = self::createSessionToken($userInfo[self::TABLE_PY]);

        self::reUpdateSessionLogin($tempToken, [
            'userName' => $userInfo[self::TABLE_USERNAME],
            'img' => $userInfo[self::TABLE_IMAGE],
            'loginTime' => time(),
            'userId' => $userInfo[self::TABLE_PY],
            'openId' => $userInfo['openId'],
            self::TABLE_MOBILE => $userInfo[self::TABLE_MOBILE],
            self::TABLE_EMAIL => $userInfo[self::TABLE_EMAIL]
        ]);
        self::UpdateById($userInfo[self::TABLE_PY], [
            self::TABLE_LOGIN_TIME => time(),
            self::TABLE_TEMP_TOKEN => $tempToken
        ]);
        return $tempToken;
    }

    public static function reUpdateSessionLogin($tokenName, $tokenInfo)
    {
        self::setCache(self::USER_CACHE_TOKEN_NAME . $tokenName, $tokenInfo, 86400);
        //\Uoke\Request\Client::getInstance()->setCookies('userSessionId', $tokenName, 86400);
    }

    public static function createSessionToken($userId)
    {
        return md5(time() . uniqid() . $userId);
    }

    private static function regToWebUser($userName, $password, $mobile = '', $mail = '', $postcode = '', $firstname = '', $lastname = '')
    {
        $userName = preg_replace("/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u", "", $userName);
        $userName = htmlspecialchars(strip_tags($userName));
        if (self::checkUserName($userName) == false) {
            throw new Exception('Username already exists');
        }
        if (self::checkPassword($password) == false) {
            throw new Exception('Password length must between 6 and 32' . strlen($password));
        }
        return self::Insert([
            self::TABLE_USERNAME => $userName,
            self::TABLE_EMAIL => $mail,
            self::TABLE_MOBILE => $mobile,
            self::TABLE_PASSWORD => password_hash($password, PASSWORD_DEFAULT),
            self::TABLE_FIRSTNAME => $firstname,
            self::TABLE_LASTNAME => $lastname,
            self::TABLE_POSTCODE => $postcode,
            self::TABLE_PASS_HASH => time(),
            self::TABLE_REG_TIME => time()
        ], true);
    }

    private static function regToUser($userName, $password, $mobile = '', $wechat = '', $openId = '')
    {
        $userName = preg_replace("/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u", "", $userName);
        $userName = htmlspecialchars(strip_tags($userName));
        if (self::checkUserName($userName) == false) {
            //throw new Exception('Username already exists');
        }
        if (self::checkPassword($password) == false) {
            throw new Exception('Password length must between 6 and 32' . strlen($password));
        }
        return self::Insert(
            [
                self::TABLE_USERNAME => $userName,
                self::TABLE_EMAIL => '',
                self::TABLE_MOBILE => $mobile,
                self::TABLE_PASSWORD => password_hash($password, PASSWORD_DEFAULT),
                self::TABLE_USER_WECHAT => $wechat,
                self::TABLE_PASS_HASH => time(),
                self::TABLE_REG_TIME => time(),
                'openId' => $openId
            ],
            true
        );
    }

    private static function removeEmoji($nickname)
    {
        $clean_text = "";
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $clean_text);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }

    public static function getCache($key)
    {
        $item = self::cache()->getItem($key);
        return $item->get();
    }

    public static function setCache($key, $value, $time = 384600)
    {
        $item = self::cache()->getItem($key);
        $item->expiresAfter($time);
        self::cache()->save($item->set($value));
    }
    
    public static function updateCache($key, $value)
    {
        $item = self::cache()->getItem($key);
        self::cache()->save($item->set($value));
    }
    
    public static function deleteCache($key)
    {
        self::cache()->deleteItem($key);
    }
}
