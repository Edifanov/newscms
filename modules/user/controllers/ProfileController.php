<?php
/**
 * Created by PhpStorm.
 * User: digkill
 * Date: 08.11.17
 * Time: 16:01
 */

namespace app\modules\user\controllers;

use \app\modules\user\forms\PasswordChangeForm;
use app\modules\user\forms\PasswordNewForm;
use \app\modules\user\forms\ProfileUpdateForm;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->findModel();
        $model = new ProfileUpdateForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPasswordNew()
    {
        $user = $this->findModel();
        $model = new PasswordNewForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->newPassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordNew', [
                'model' => $model,
            ]);
        }
    }

    public function actionPasswordChange()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}