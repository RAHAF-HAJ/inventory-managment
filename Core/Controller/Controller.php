<?php

namespace Core\Controller;


use App;
use HTML2PDF;
use HTML2PDF_exception;

class Controller
{
    protected $viewPath;
    protected $template = 'default';
    public function __construct()
    {
        $this->viewPath = ROOT.'/App/Views/';

        foreach ($_POST as $key => $value) {
            if(!is_array($_POST[$key]))
                $_POST[$key] = htmlentities($value);
            else {
                foreach ($_POST[$key] as $k => $v) {
                    $_POST[$key][$k] = htmlentities($v);
                }

            }
        }
    }

    protected function loadModel($model_name){
        $this->$model_name = \App::getInstance()->getModel($model_name);
    }

    protected function render($view, $variables = []){
        ob_start();
        extract($variables);
        include($this->viewPath . $view.'.php');
        $content = ob_get_clean();
        include($this->viewPath. 'templates/'.$this->template.'.php');

    }

    protected function pdf($view, $variables = []){
        require_once ROOT.'/lib/vendor/autoload.php';

        ob_start();
        extract($variables);
        include($this->viewPath . $view.'.php');
        $content = ob_get_clean();

        try {
            /*$lg = Array();
            $lg['a_meta_charset'] = 'UTF-8';
            $lg['a_meta_dir'] = 'rtl';
            $lg['a_meta_language'] = 'fa';
            $lg['w_page'] = 'page';
            */
            $pdf = new HTML2PDF('P', 'A4', 'en');
            //$pdf->pdf->setLanguageArray($lg);
            $pdf->writeHTML($content);
            $pdf->Output('artilces.pdf');
        }
        catch(HTML2PDF_exception $e){
            echo $e;
            exit();
        }
    }

    protected function redirect($location){
        header('location: '. App::$path.$location);
    }
}