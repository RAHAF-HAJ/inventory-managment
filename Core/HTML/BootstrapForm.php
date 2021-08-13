<?php
namespace Core\HTML;

class BootstrapForm extends Form{

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html){
        return "<div class='form-group'>{$html}</div>";
    }

    public function input($name, $label, $attributes = [], $value = ''){
        $label = '<label class="main-color">'.$label.'</label>';
        $input =  '<input name="'.$name.'" '.$this->extractAttrs($attributes).' value="'.(empty($value) ? $this->getValue($name) : $value).'"  class="form-control main-border-color ">';
        return $this->surround($label.$input);
    }
    public function file($name, $attributes = []){
        $input =  '<input name="'.$name.'" '.$this->extractAttrs($attributes).' value="'.$this->getValue($name).'" >';
        return $this->surround($input);
    }
    public function select($name, $label, $options, $attributes = [], $first_blank = false){
        $label = '<label>'.$label.'</label>';
        $select =  '<select name="'.$name.'" '.$this->extractAttrs($attributes).'  class="form-control">';
        if($first_blank){
            $select .= "<option value=''></option>";
        }
        foreach($options as $k => $v){
            $opAttr = '';
            if($k == $this->getValue($name)){
                $opAttr = 'selected';
            }
            $select .= "<option value='{$k}' {$opAttr}>{$v}</option>";
        }
        $select .= '</select>';

        return $this->surround($label.$select);
    }
    public function textarea($name, $label, $attributes = []){
        $label = '<label>'.$label.'</label>';
        $textarea =  '<textarea name="'.$name.'" '.$this->extractAttrs($attributes).'   class="form-control">'.$this->getValue($name).'</textarea>';
        return $this->surround($label.$textarea);
    }
    public function submit($name, $caption, $attributes = []){
        return  '<button type="submit" name="'.$name.'" '.$this->extractAttrs($attributes).' class="btn btn-lg btn-block">'.$caption.'</button>';
    }
}