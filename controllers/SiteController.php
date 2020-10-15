<?php

namespace app\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Provider;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => Provider::generateProviders(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Makes a call.
     *
     * @return string
     */
    public function actionCall()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return 'Method not allowed.';
        }

        $credentials = [
            'adminPhone' => $request->post('adminPhone'),
            'providerPhone' => urlencode(str_replace(' ','', $request->post('providerPhone'))),
            'accountSid' => Yii::$app->params['Twilio']['TWILIO_ACCOUNT_SID'],
            'authToken' => Yii::$app->params['Twilio']['TWILIO_AUTH_TOKEN'],
            'twilioNumber' => Yii::$app->params['Twilio']['TWILIO_NUMBER'],
        ];

        if (!empty($request->post('accountSid'))
            && !empty($request->post('authToken'))
            && !empty($request->post('twilioNumber'))) {

            $credentials['accountSid'] = $request->post('accountSid');
            $credentials['authToken'] = $request->post('authToken');
            $credentials['twilioNumber'] = $request->post('twilioNumber');
        }

        $host = parse_url($request->getAbsoluteUrl(), PHP_URL_HOST);

        $client = new \Twilio\Rest\Client(
            $credentials['accountSid'],
            $credentials['authToken']
        );

        try {
            $client->calls->create(
                $credentials['adminPhone'],
                $credentials['twilioNumber'],
                [
                    "url" => "http://$host/outbound/" . $credentials['providerPhone']
                ]
            );
        } catch (\Exception $e) {
            return $e;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['message' => 'Call incoming!'];
    }

    /**
     * Dials with provider.
     *
     * @return string
     */
    public function actionOutbound($providerPhone)
    {
        $sayMessage = 'Thanks for contacting us.';

        $twiml = new \Twilio\TwiML();
        $twiml->say($sayMessage, array('voice' => 'alice'));
        $twiml->dial($providerPhone);

        Yii::$app->response->format = Response::FORMAT_XML;
        return true;
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
