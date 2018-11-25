<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/31/18
 * Time: 12:07 AM
 */

namespace app\components;

use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                /*'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],*/
                'only' => [
                    'index', 'create', 'update', 'view', 'delete', 'remove',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index', 'create', 'update', 'view', 'delete', 'remove',
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === Yii::$app->params['admin_role'];
                        },

                        /*'roles' => [
                            Yii::$app->params['admin_role']
                        ],*/
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'logout' => ['POST'],
                    'remove' => ['POST'],
                    'submit' => ['POST'],
                ],
            ],
        ];
    }
}