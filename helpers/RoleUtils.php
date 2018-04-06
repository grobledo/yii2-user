<?php
/**
 * Created by PhpStorm.
 * User: groble
 * Date: 4/4/2018
 * Time: 23:01
 */

namespace grobledo\user\helpers;


class RoleUtils
{
    public static function getRoles(){
        $roles = array_keys(\Yii::$app->authManager->getRoles());
        $roles_combined = array_combine($roles, $roles);
        unset($roles_combined["superadmin"]);
        return $roles_combined;
    }
}