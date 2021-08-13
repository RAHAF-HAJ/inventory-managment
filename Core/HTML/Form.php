<?php
namespace Core\HTML;

class Form{
    protected $data;
    protected $surround = 'p';

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function extractAttrs($attributes){
        $attrs = '';
        foreach ($attributes as $k => $v) {
            $attrs .= $k.'="'.$v.'" ';
        }
        return $attrs;
    }

    protected function getValue($index){
        if(is_object($this->data)){
            return isset($this->data->$index)? $this->data->$index : null;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }
    protected function surround($html){
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }
    public function input($name, $label){
        $label = '<label>'.$label.'</label>';
        $input =  '<input type="text" name="'.$name.'" value="'.$this->getValue($name).'">';
        return $this->surround($label.$input);
    }
    public function submit($name, $caption){
        return  $this->surround('<button type="submit" name="'.$name.'">'.$caption.'</button>');
    }
}