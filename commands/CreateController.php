<?php

/*
 * This file is part of the grobledo project.
 *
 * (c) grobledo project <http://github.com/grobledo/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace grobledo\user\commands;

use grobledo\user\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Creates new user account.
 *
 * @property \grobledo\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class CreateController extends Controller
{
    /**
     * This command creates new user account. If password is not set, this command will generate new 8-char password.
     * After saving user to database, this command uses mailer component to send credentials (username and password) to
     * user via email.
     *
     * @param string      $email    Email address
     * @param string      $username Username
     * @param null|string $password Password (if null it will be generated automatically)
     */
    public function actionIndex($firstname, $lastname, $email, $password = null, $role)
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'email'    => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'password' => $password,
        ]);

        $auth = Yii::$app->getAuthManager();
        $user_role = $auth->getRole($role);

        if ($user_role == null){
            $this->stdout(Yii::t('user', 'Role not found: ' . $role) . "\n", Console::FG_RED);
            return;
        }

        if ($user->create()) {
            $auth->assign($user_role, $user->id);
            $this->stdout(Yii::t('user', 'User has been created') . "!\n", Console::FG_GREEN);
        } else {
            $this->stdout(Yii::t('user', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }
}
