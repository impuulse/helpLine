<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\Response;
use Yii;
use yii\filters\ContentNegotiator;

class CalcController extends Controller
{
    /**
     * @var array
     */
    public $response = [];

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function actionJson()
    {
        $body = json_decode(Yii::$app->request->rawBody);

        if($body && is_object($body) && property_exists($body, 'exp')){
            if(property_exists($body->exp, 'sum')){
                if(
                    property_exists($body->exp->sum, 'numbers') &&
                    property_exists($body->exp->sum, 'mul')){

                    $sumNumbers = array_sum($body->exp->sum->numbers);
                    $mulNumbers = array_product($body->exp->sum->mul);

                    $result = $sumNumbers + $mulNumbers;

                    $this->response['meta']['success'] = true;
                    $this->response['result'] = $result;
                } else {
                    $this->response['meta']['success'] = false;
                    $this->response['result'] = 'wrong format';
                }
            } else {
                $this->response['meta']['success'] = false;
                $this->response['result'] = 'wrong format';
            }
        } else {
            $this->response['meta']['success'] = false;
            $this->response['result'] = 'wrong format';
        }

        return $this->response;
    }

    /**
     * @return array
     */
    public function actionXml()
    {
        $body = Yii::$app->request->rawBody;
        $object = new \SimpleXMLElement($body);

        if(
            property_exists($object, 'sum') &&
            property_exists($object->sum, 'mul')
        ){
            if(
                property_exists($object->sum, 'number') &&
                property_exists($object->sum->mul, 'number')){

                $sumNumbers = array_sum((array) $object->sum->number);
                $mulNumbers = array_product((array) $object->sum->mul->number);

                $result = $sumNumbers + $mulNumbers;

                $this->response['meta']['success'] = true;
                $this->response['result'] = $result;
            } else {
                $this->response['meta']['success'] = false;
                $this->response['result'] = 'wrong format';
            }
        } else {
            $this->response['meta']['success'] = false;
            $this->response['result'] = 'wrong format';
        }

        return $this->response;
    }
}
