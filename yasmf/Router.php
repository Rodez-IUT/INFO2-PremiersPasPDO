<?php

namespace yasmf;

class Rooter {

    private $dataSource;

    public function __construct($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function route($dataSource) {
        // Create a model
        $model = new model(getPDO());

        // set controller with the current model
        $controllerName = get('controller') + "_controller";
        $controller = new $controllerName($model);
        // set action to trigger
        $action = get('action') ?: 'defaultAction';

        // trigger the appropriate action and get the resulted view
        $view = $controller->$action($model);

        // render the view
        $view->render($model);
    }

    private function get($name) {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }
}

