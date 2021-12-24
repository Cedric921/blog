<?php

namespace App\HTML;

use App\Model\Post;
use DateTimeInterface;

class Form{

    private $data;
    private $errors;

    public function __construct($data,array $errors){
        $this->data = $data;
        $this->errors = $errors;
    }
    private function getValue(string $key){
        if (is_array($this->data)) {
            # code...
            return $this->data[$key] ?? null;
        }
        //ucwords permet de rajouter les majuscule a chaque mot
        $method = "get". ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ',$key))));
        $value =  $this->data->$method();
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;

    }

    private function getInputClass(string $key): string{
        $inputClass = "form-control";
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }
    private function getErrorsFeedback(string $key): string{
        if (isset($this->errors[$key])) {
            if (is_array($this->errors[$key])) {
                
                $error = implode('<br>', $this->errors[$key]);
            } else{
                $error = $this->errors[$key]; 
            }
            return '<div class="invalid-feedback">' . $error . '</div>';
        }
        return '';
            
    }
    public function input(string $key, string $label): string{

        $value = $this->getValue($key);
        $type = $key === 'password' ? 'password' : 'text';

        return <<<HTML
        <div class="form-group">
            <label for="field-{$key}" >{$label}</label>
            <input type="{$type}"  id="field-{$key}" name="{$key}" class="{$this->getInputClass($key)}" value="{$value}" required>
            {$this->getErrorsFeedback($key)}
        </div>
HTML;
    }

    public function textarea(string $key, string $label): string{

        $value = $this->getValue($key);
        return <<<HTML
        <div class="form-group">
            <label for="field-{$key}" >{$label}</label>
            <textarea type="text"  id="field-{$key}" name="{$key}" class="{$this->getInputClass($key)}" required>{$value}</textarea>
            {$this->getErrorsFeedback($key)}
        </div>
HTML;
    }
}