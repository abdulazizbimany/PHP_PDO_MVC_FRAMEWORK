<?php

//Core App Class
class Core
{
    protected $currentController = 'Pages'; //automatically loaded if no controllers in controllers
    protected $currentMethod = 'index'; //inside pages controllers will load index page
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        //look inside controllers folder for the first value/element in $url domain/shop/....
        //ucwords will capitalize the first letter
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            //override and set a new controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        //Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        if (isset($url[0])) {
            //check for the second part of url like domain/shop/glasses... if method exists
            if (method_exists($this->currentController, $url[0])) {
                $this->currentMethod = $url[0];
                unset($url[0]);
            }
        }

        //Get parameters
        //check if are parameters else keep empty
        $this->params = $url ? array_values($url) : array();

        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            // remove / on last on url
            $url = rtrim($_GET['url'], '/');

            //allow to filter variable as string/number only
            $url = filter_var($url, FILTER_SANITIZE_URL);

            //breaking it into array
            $url = explode('/', $url);
            return $url;
        }
    }
}

?>


