<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/20/18
 * Time: 4:29 PM
 */

namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ClientController extends Controller
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
                    'index', 'create', 'update', 'view', 'delete', 'submit',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index', 'create', 'update', 'view', 'delete', 'submit',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === Yii::$app->params['consumer_role'];
                        },
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'submit' => ['POST'],
                ],
            ],
        ];
    }
}