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
        $error["error"] = false;
        $error['fields'] = [];
        foreach ($this->inputs as $key => $input) {
            if (!isset($input['validation'])) {
                Logger::log('No validation method selected in form ' . $this->name);
                return null;
            }
            $default = true;
            if ($input['validation'] == 'wysiwyg') {
                $default = false;
                if (is_string($_POST[$key])) {
                    /* remove all tags except h2, h3, h4, h5, h6, p, img, table, th, td, tr, ul, li*/
                    $data[$key] = trim(preg_replace("#(?i)<(?!\/?(img|h[2-6]|p|div|label|table|th|td|tr|ul|li)).*?>#"
                        , "", $_POST[$key]));
                } else {
                    $error["error"] = true;
                    $error['fields'][] = $key;
                    Logger::log('invalid text value');
                }
            }
            if ($input['validation'] == 'text') {
                $default = false;
                if (is_string($_POST[$key])) {
                    /* remove all tags*/
                    $data[$key] = trim(preg_replace("#(?i)<(?!\/?).*?>#", "", $_POST[$key]));
                } else {
                    $error["error"] = true;
                    $error['fields'][] = $key;
                    Logger::log('invalid text value');
                }
            }
            if ($input['validation'] == 'int') {
                $default = false;
                if (is_int($_POST[$key])) {
                    $data[$key] = intval($_POST[$key]);
                } else {
                    $error["error"] = true;
                    $error['fields'][] = $key;
                    Logger::log('invalid int value');
                }
            }
            if ($input['validation'] == 'date') {
                $default = false;
                if (true) {
                    $data[$key] = $_POST[$key];
                } else {
                    $error["error"] = true;
                    $error['fields'][] = $key;
                    Logger::log('invalid int value');
                }
            }
            if ($input['validation'] == 'file') {
                $default = false;
                if (true){
                    $data[$key] = $_FILES[$key];
                } else {
                    $error["error"] = true;
                    $error['fields'][] = $key;
                    Logger::log('invalid file');
                }
            }
            if ($default) {
                Logger::log('invalid default value (or unknown component)');
            }
        }
        if ($error['state']){
            return $error;
        }
        return $data;
    }

    /**
     * @param string $main_class
     * @param array $data
     * @return bool
     */
    public function display($main_class = "", $data = [])
    {
        echo '<form action="' . $this->action . '" method="' . $this->method . '" name="' . $this->name . '" class="' . $this->class . ' ' . $main_class . '" enctype="' . $this->enctype . '">';
        echo '<input type="hidden" value="' . $this->name . '" name="type">';
        if (isset($main_class)) {
            echo '<input type="hidden" value="' . $main_class . '" name="seperator">';
        }

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
                $type = "";
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
            if (isset($input['class'])) {
                $class = $input['class'];
            } else {
                $class = "";
            }
            /**
             * display input data
             */
            if ($type == "textarea") {
                ?>
                <label for="<?php echo $name ?>"><?php echo $label ?></label>
                <textarea
                    name="<?php echo $name ?>"
                    placeholder="<?php echo $placeholder ?>"
                    class="<?php echo $class ?>"
                >
                            <?php echo (isset($data[$name])) ? $data[$name] : $value; ?>
                        </textarea>
                <?php
            } else {
                ?>
                <label for="<?php echo $name ?>"><?php echo $label ?></label>
                <input
                    name="<?php echo $name ?>"
                    type="<?php echo $type ?>"
                    class="<?php echo $class ?>"
                    value="<?php echo (isset($data[$name])) ? $data[$name] : $value; ?>"
                    placeholder="<?php echo $placeholder ?>"
                >
                <?php
            }
        }

        echo '<input type="submit" value="' . $this->submit . '" onclick="' . $this->onclick . '">';
        echo '</form>';

    }
}