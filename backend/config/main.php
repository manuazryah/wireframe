<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'], // adjust this to your needs
            'generators' => [//here
                'crud' => [// generator name
                    'class' => 'yii\gii\generators\crud\Generator', // generator class
                    'templates' => [//setting for out templates
                        'custom' => '@common/myTemplates/crud/custom', // template name => path to template
                    ]
                ]
            ],
        ],
        'admin' => [
            'class' => 'backend\modules\admin\Module',
        ],
        'masters' => [
            'class' => 'backend\modules\masters\Module',
        ],
        'appointment' => [
            'class' => 'backend\modules\appointment\Module',
        ],
        'accounts' => [
            'class' => 'backend\modules\accounts\Module',
        ],
        'licence_procedure' => [
            'class' => 'backend\modules\licence_procedure\Module',
        ],
        'reports' => [
            'class' => 'backend\modules\reports\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'notifications' => [
            'class' => 'backend\modules\notifications\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUsers',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
//                'yii\bootstrap\BootstrapAsset' => [
//                    'css' => [],
//                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
            ],
        ],
    ],
    'params' => $params,
];
