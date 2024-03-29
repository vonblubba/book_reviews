<?php

class ErrorController extends Zend_Controller_Action {
    public function errorAction() {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'Ooops, something went very wrong...';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Check the page address for mistakes.<br />Or it could be some moronic PHP programming error by <strong>Figura4</strong>.<br /> Contact him at <strong>figura4 (snail) figura4 (dot) com</strong> and let him know!';
                $this->renderScript('error/error_404.phtml');
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Probably some moronic PHP programming error by <strong>Figura4</strong>.<br /> Contact him at <strong>figura4 (snail) figura4 (dot) com</strong> and let him know!';
                $this->renderScript('error/error_500.phtml');
                break;
        }
        
        // Log exception, if logger available
        if ($log = Zend_Registry::get('logger')) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // conditionally display exceptions
        //if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        //}
        
        $this->view->request   = $errors->request;
    }
    
    public function noauthAction() {
    	
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }
}
