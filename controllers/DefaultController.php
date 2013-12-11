<?php
/*
 * Class for very simple RESTFULL API by Arockia Johnson 
 * Provided under MIT License johnson@arojohnson.tk 
 */
class DefaultController extends Controller {
    /*
     * Action for all requests then it forwards the requests to the regarding action
     * according to the type of http request
     * No params
     */

    public function actionIndex() {
        if ($this->_authenticate())
            $this->forward(strtolower(Yii::app()->request->requestType));
        else {
            $ret_data = array('error' => 'Invalid Request');
            $status = 403;
            $this->renderPartial('index', array('data' => $ret_data, 'status' => $status, 'status_msg' => $this->_getStatusCodeMessage($status)));
        }
    }

    /*
     * Action for the HTTP POST request
     * No params
     */

    public function actionPost() {
        $ret_data = array('error' => 'In Valid Request');
        $status = 404;
        $model = $this->_getModel();
        $attributes = Yii::app()->request->getRestParams();

        if (isset($model)) {
            $model = new $model;
            $model->attributes = $attributes;
            if ($model->save()) {
                $status = 201;
                $ret_data = array('success' => 'Data Saved Successfully');
            } else {
                $status = 404;
                $ret_data = $model->getErrors();
            }
        }


        $this->renderPartial('index', array('data' => $ret_data, 'status' => $status, 'status_msg' => $this->_getStatusCodeMessage($status)));
    }

    /*
     * Action for the HTTP PUT request
     * No params
     */

    public function actionPut() {
        $id = Yii::app()->request->getParam('id');
        $ret_data = array('error' => 'In Valid Request or Model not found');
        $status = 404;
        $model_ = $this->_getModel();
        $attributes = Yii::app()->request->getRestParams();

        if (isset($model_) && !empty($id)) {
            $model = new $model_;
            $model->attributes = $attributes;
            if ($model->updateByPk($id, $attributes)) {
                $status = 200;
                $ret_data = array($model_ => 'Model Updated Successfully for the record ' . $id);
            } else {
                $status = 204;
                $ret_data = $model->getErrors();
            }
        }

        $this->renderPartial('index', array('data' => $ret_data, 'status' => $status, 'status_msg' => $this->_getStatusCodeMessage($status)));
    }

    /*
     * Action for the HTTP DELETE request
     * No params
     */

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $ret_data = array('error' => 'In Valid Request or Model not found');
        $status = 404;
        $model_ = $this->_getModel();

        if (isset($model_) && !empty($id)) {
            $model = new $model_;
            if ($model->deleteByPk($id)) {
                $status = 200;
                $ret_data = array($model_ => 'Data deleted Successfully for the record ' . $id);
            } else {
                $status = 404;
                $ret_data = $model->getErrors();
            }
        }

        $this->renderPartial('index', array('data' => $ret_data, 'status' => $status, 'status_msg' => $this->_getStatusCodeMessage($status)));
    }

    /*
     * Action for the HTTP GET request
     * No params
     */

    public function actionGet() {
        $id = Yii::app()->request->getParam('id');
        $ret_data = array('error' => 'In Valid Request or Model not found');
        $status = 404;
        $model_ = $this->_getModel(); 

        if (isset($model_) && !empty($id)) {
            $model = new $model_;
            $status = 200;
            $ret_data = array($model_ => CJSON::encode($model->findByPk($id)));
        }

        $this->renderPartial('index', array('data' => $ret_data, 'status' => $status, 'status_msg' => $this->_getStatusCodeMessage($status)));
    }

    public function actionTest() {
        $this->render('test');
    }

    /*
     * Function to get the http status
     * Params are status code return type string
     */

    private function _getStatusCodeMessage($status) {

        $codes = Array(
            200 => 'OK',
            201 => 'Data Stored Successfully',
            204 => 'No Content',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /*
     * Function to authenticate the api request 
     * No parameters return type boolean
     */

    private function _authenticate() {

        //Customize with your own authentication processes
        if (isset(Yii::app()->session['api_auth']))
            return true;

        $keys = array(
            1 => 'pass1',
            2 => 'pass2',
            3 => 'pass3',
        );

        if (in_array(base64_decode(Yii::app()->request->getParam('key')), $keys)) {
            $session = new CHttpSession;
            $session->setTimeout(120);
            $session['api_auth'] = base64_encode(Yii::app()->request->getParam('key') . $_SERVER['REMOTE_ADDR']);
            return true;
        } else {
            return false;
        }
    }

    /*
     * Function to get the existing model 
     * No params, Return type string or null
     */

    private function _getModel() {
        $model_ = Yii::app()->request->getParam('model');
        $model = NULL;
        foreach ($this->module->metadata->getModels() as $_model) {
            if (strtolower($_model) == strtolower($model_)) {
                $model = $_model;
                break;
            }
        }
        return $model;
    }

}
