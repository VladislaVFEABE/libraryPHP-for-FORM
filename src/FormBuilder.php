<?php
namespace FormLib;

/**
 * Класс FormBuilder для генерации HTML-форм и валидации данных
 */
class FormBuilder
{
    private $action;
    private $method;
    private $fields = [];
    private $data = [];
    private $errors = [];

    /**
     * Конструктор формы
     */
    public function __construct(string $action = "", string $method = "POST")
    {
        $this->action = $action;
        $this->method = strtoupper($method);
    }

    public function addInput(string $type, string $name, string $label = "", string $value = "")
    {
        $this->fields[] = ['type'=>$type,'name'=>$name,'label'=>$label,'value'=>$value];
    }

    public function addTextarea(string $name, string $label = "", string $value = "")
    {
        $this->fields[] = ['type'=>'textarea','name'=>$name,'label'=>$label,'value'=>$value];
    }

    public function addSelect(string $name, array $options, string $label = "")
    {
        $this->fields[] = ['type'=>'select','name'=>$name,'label'=>$label,'options'=>$options];
    }

    public function addSubmit(string $value = "Отправить")
    {
        $this->fields[] = ['type'=>'submit','value'=>$value];
    }

    /**
     * Рендер HTML формы
     */
    public function render(): string
    {
        $html = "<form action='{$this->action}' method='{$this->method}'>\n";

        foreach ($this->fields as $field) {
            if (!empty($field['label'])) {
                $html .= "<label>{$field['label']}</label>\n";
            }

            switch ($field['type']) {
                case 'textarea':
                    $html .= "<textarea name='{$field['name']}'>{$field['value']}</textarea>\n";
                    break;
                case 'select':
                    $html .= "<select name='{$field['name']}'>\n";
                    foreach ($field['options'] as $val=>$text) {
                        $html .= "<option value='{$val}'>{$text}</option>\n";
                    }
                    $html .= "</select>\n";
                    break;
                case 'submit':
                    $html .= "<button type='submit'>{$field['value']}</button>\n";
                    break;
                default:
                    $html .= "<input type='{$field['type']}' name='{$field['name']}' value='{$field['value']}'>\n";
            }
        }

        $html .= "</form>\n";
        return $html;
    }

    /**
     * Валидация
     */
    public function setData(array $data) { $this->data = $data; }

    public function required(string $field)
    {
        if (empty($this->data[$field])) $this->errors[$field][] = "Поле {$field} обязательно.";
    }

    public function email(string $field)
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL))
            $this->errors[$field][] = "Поле {$field} должно быть корректным email.";
    }

    public function minLength(string $field, int $length)
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length)
            $this->errors[$field][] = "Поле {$field} должно содержать минимум {$length} символов.";
    }

    public function fails(): bool { return !empty($this->errors); }
    public function errors(): array { return $this->errors; }
}
