<?php

namespace Framework;
use Framework\Session;

class Autorization{
    /**
    * Check if current logged in user owns a listing
    * 
    * @param int $resourceId
    * @return bool
    */

    public static function isOwner($resourceId){
        $sessionUser = Session::get('user');

        if($sessionUser !== null && isset($sessionUser['id'])){
            $sessionUserId = (int) $sessionUser['id'];
            return $sessionUserId === $resourceId;
        }

        return false;
    }
}