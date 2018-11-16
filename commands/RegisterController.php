<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/16/18
 * Time: 10:38 AM
 */

namespace console\controllers;


use Yii;
use yii\base\Exception;
use yii\console\Controller;
use console\models\User;

class RegisterController extends Controller {

    public function actionAdmin($email) {
        try {

            if (!$email) {
                echo "Missing required parameters: email, AND/OR password";
            }
            echo $email."\n";

            User::registerAdmin($email);

        } catch (Exception $e) {
            echo $e . "\n";
        }

    }
}