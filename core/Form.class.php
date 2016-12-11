<?php

class Form
{
    public $name;
    protected $method;
    protected $action;
    protected $submit;
    protected $onclick;
    protected $class;
    protected $enctype;
    protected $inputs;

    /**
     * Form constructor.
     * @param array $form
     */
    /*
    $example = [
        'options' => [
            'method' => 'POST',
            'action' => '#',
            'submit' => 'Send',
            'name' => 'postform',
            'class' => '',
            'enctype' => "multipart/form-data"
        ],
        'data' => [
            "id" => [
                "type" => "text",
                "validation" => "int",
                "value" => ''
            ],
            "name" => [
                "type" => "text",
                "validation" => "text",
                "value" => ''
            ],
            "content" => [
                "type" => "text",
                "validation" => "text",
                "value" => ''
            ],
            "filepath" => [
                "type" => "select",
                "validation" => "file",
                "value" => ''
            ],
            "pro" => [
                "type" => "select",
                "validation" => "file",
                "value" => ''
            ]
        ]
    ];
    */

    public function __construct($form = [])
    {
        if (!isset($form['options'])) {
            Logger::log('form options are not set');
            return false;
        }
        if (!isset($form['data'])) {
            Logger::log('form data isn\'t set');
            return false;
        }
        $this->inputs = $form['data'];
        if (isset($form['options']['method'])) {
            $this->method = $form['options']['method'];
        } else {
            $this->method = conf::DEFAULT_FORM_VALIIDATION;
        }
        if (isset($form['options']['name'])) {
            $this->name = $form['options']['name'];
        } else {
            Logger::log('The form must be named');
            return false;
        }
        if (isset($form['options']['action'])) {
            $this->action = $form['options']['action'];
        } else {
            $this->action = '';
        }
        if (isset($form['options']['submit'])) {
            $this->submit = $form['options']['submit'];
        } else {
            $this->submit = conf::DEFAULT_FORM_SUBMIT;
        }
        if (isset($form['options']['form'])) {
            $this->class = implode(" ", $form['options']['form']);
        } else {
            $this->class = '';
        }
        if (isset($form['options']['onclick'])) {
            $this->onclick = $form['options']['onclick'];
        } else {
            $this->onclick = '';
        }
        if (isset($form['options']['enctype'])) {
            $this->enctype = $form['options']['enctype'];
        } else {
            $this->enctype = '';
        }
        return true;
    }

    /**
     * return form result as array
     */
    public function validate()
    {
        if (!isset($_POST['type']) || $_POST['type'] != $this->name) {
            return false;
        }
        $data = [];
        foreach ($this->inputs as $key => $input) {
            if (!isset($input['validation'])) {
                Logger::log('No validation method selected in form ' . $this->name);
                return null;
            }
            $default = true;
            if ($input['validation'] == 'text') {
                $default = false;
                if (true) {
                    $data[$key] = $_POST[$key];
                } else {
                    Logger::log('invalid text value');
                }
            }
            if ($input['validation'] == 'password') {
                $default = false;
                if (true) {
                    $data[$key] = $_POST[$key];
                } else {
                    Logger::log('invalid password value');
                }
            }
            if ($input['validation'] == 'int') {
                $default = false;
                if (true) {
                    $data[$key] = $_POST[$key];
                } else {
                    Logger::log('invalid int value');
                }
            }
            if ($input['validation'] == 'date') {
                $default = false;
                if (true) {
                    $data[$key] = $_POST[$key];
                } else {
                    Logger::log('invalid int value');
                }
            }
            if ($input['validation'] == 'file') {

            }
            if ($default) {
                Logger::log('invalid default value (or unknown component)');
            }
        }
        if (!isset($data['name']) && isset($key)) {
            $data['name'] = $key;
        }
        return $data;
    }

    /**
     * @param array $html -> html to be placed before form & inputs
     * @param array $data -> needs to be removed (deprecated)
     */
    public function display($html = [], $data = [])
    {
        if (isset($html['form']) && isset($html['form']['before'])) {
            echo $html['form']['before'];
        }
        echo '<form action="' . $this->action . '" method="' . $this->method . '" name="' . $this->name . '" class="' . $this->class . '" enctype="' . $this->enctype . '">';
        echo '<input type="hidden" value="' . $this->name . '" name="type">';


        foreach ($this->inputs as $key => $input) {
            /**
             * prepare input data
             */
            if (isset($input['name'])) {
                $name = $input['name'];
            } elseif (isset($key)) {
                $name = $key;
            } else {
                Logger::log('input must have name in form ' . $this->name);
                return false;
            }
            if (isset($input['type'])) {
                $type = $input['type'];
            } else {
                $type = "test";
            }
            if (isset($input['value'])) {
                $value = $input['value'];
            } else {
                $value = "";
            }
            if (isset($input['placeholder'])) {
                $placeholder = $input['placeholder'];
            } else {
                $placeholder = "";
            }
            if (isset($input['label'])) {
                $label = $input['label'];
            } else {
                $label = "";
            }
            /**
             * display input data
             */
            if ($type == "textarea") {

                if (isset($html['label']) && isset($html['label']['before'])) {
                    echo $html['label']['before'];
                }
                ?>
                <label for="<?php echo $name ?>"><?php echo $label ?></label>
                <?php
                if (isset($html['label']) && isset($html['label']['after'])) {
                    echo $html['label']['after'];
                }

                if (isset($html['input']) && isset($html['input']['before'])) {
                    echo $html['label']['before'];
                }
                ?>
                <textarea
                    name="<?php echo $name ?>"
                    placeholder="<?php echo $placeholder ?>"
                >
                            <?php echo (isset($data[$name])) ? $data[$name] : $value; ?>
                        </textarea>
                <?php
                if (isset($html['input']) && isset($html['input']['after'])) {
                    echo $html['input']['after'];
                }
            } else {
                if (isset($html['label']) && isset($html['label']['before'])) {
                    echo $html['label']['before'];
                }
                ?>
                <label for="<?php echo $name ?>"><?php echo $label ?></label>
                <?php
                if (isset($html['label']) && isset($html['label']['after'])) {
                    echo $html['label']['after'];
                }
                if (isset($html['input']) && isset($html['input']['before'])) {
                    echo $html['input']['before'];
                }
                ?>
                <input
                    name="<?php echo $name ?>"
                    type="<?php echo $type ?>"
                    value="<?php echo (isset($data[$name])) ? $data[$name] : $value; ?>"
                    placeholder="<?php echo $placeholder ?>"
                >
                <?php
                if (isset($html['input']) && isset($html['input']['after'])) {
                    echo $html['input']['after'];
                }
            }
        }
        if (isset($html['submit']) && isset($html['submit']['before'])) {
            echo $html['submit']['before'];
        }
        echo '<input type="submit" value="' . $this->submit . '" onclick="' . $this->onclick . '">';
        if (isset($html['submit']) && isset($html['submit']['after'])) {
            echo $html['submit']['after'];
        }
        echo '</form>';
        if (isset($html['form']) && isset($html['form']['after'])) {
            echo $html['form']['after'];
        }
    }
}