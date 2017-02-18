<?php

class FormTheme
{
    public $name;
    protected $id;
    protected $method;
    protected $action;
    protected $submit;
    protected $onclick;
    protected $class;
    protected $enctype;
    protected $inputs;


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
        if (isset($form['options']['id'])) {
            $this->id = $form['options']['name'];
        } else {
            Logger::log('The form must have an id');
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
        if (isset($error['state'])){
            return $error;
        }
        return $data;
    }

    /**
     * @param string $main_class
     * @param array $data
     * @return bool
     */
   
    public function display($main_class = "", $data = [], $sumited = null)
    {
        echo '<form action="' . $this->action . '" method="' . $this->method . '" name="' . $this->name . '" class="' . $this->class . ' ' . $main_class . '" id="' . $this->id . ' ' . $main_class . '" enctype="' . $this->enctype . '">';
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
            if (isset($input['id'])) {
                $id = $input['id'];
            } else {
                $id = "";
            }
            if (isset($input['icon_class'])) {
                $icon_class = $input['icon_class'];
            } else {
                $icon_class = "";
            }
            if (isset($input['icon_content'])) {
                $icon_content = $input['icon_content'];
            } else {
                $icon_content = "";
            }
            if (isset($input['div_class'])) {
                $div_class = $input['div_class'];
            } else {
                $div_class = "";
            }
            if (isset($input['file_class'])) {
                $file_class = $input['file_class'];
            } else {
                $file_class = "";
            }
            if (isset($input['class_wrapper'])) {
                $class_wrapper = $input['class_wrapper'];
            } else {
                $class_wrapper = "";
            }
            if (isset($input['class_inputWrapper'])) {
                $class_inputWrapper= $input['class_inputWrapper'];
            } else {
                $class_inputWrapper = "";
            }
            if (isset($input['type_inputWrapper'])) {
                $type_inputWrapper= $input['type_inputWrapper'];
            } else {
                $type_inputWrapper = "";
            }
            if (isset($input['value1'])) {
                $value1 = $input['value1'];
            } else {
                $value1 = "";
            }
            if (isset($input['value2'])) {
                $value2 = $input['value2'];
            } else {
                $value2 = "";
            }
            if (isset($input['value3'])) {
                $value3 = $input['value3'];
            } else {
                $value3 = "";
            }
            if (isset($input['value4'])) {
                $value4 = $input['value4'];
            } else {
                $value4 = "";
            }
            if (isset($input['value5'])) {
                $value5 = $input['value5'];
            } else {
                $value5 = "";
            }
            if (isset($input['idClass1'])) {
                $idClass1 = $input['idClass1'];
            } else {
                $idClass1 = "";
            }
            if (isset($input['idClass2'])) {
                $idClass2 = $input['idClass2'];
            } else {
                $idClass2 = "";
            }
            if (isset($input['idClass3'])) {
                $idClass3 = $input['idClass3'];
            } else {
                $idClass3 = "";
            }
            if (isset($input['idClass4'])) {
                $idClass4 = $input['idClass4'];
            } else {
                $idClass4 = "";
            }
            if (isset($input['idClass5'])) {
                $idClass5 = $input['idClass5'];
            } else {
                $idClass5 = "";
            }
           
                if (isset($input['div_color1'])) {
                    $div_color1 = $input['div_color1'];
                } else {
                    $div_color1 = "";
                }
           
            /**
             * display input data
             */
            if ($type == "textarea") {
                ?>
                <div class="<?php echo $div_class ?>">
                    <i class="<?php echo $icon_class ?>"><?php echo $icon_content ?></i>
                    <label for="<?php echo $name ?>"><?php echo $label ?></label>
                    <textarea
                        name="<?php echo $name ?>"
                        placeholder="<?php echo $placeholder ?>"
                        class="<?php echo $class ?>"
                        id="<?php echo $id ?>"
                    >
                    <?php echo (isset($data[$name])) ? $data[$name] : $value; ?>
                    </textarea>
                </div>
                <?php
            } elseif($type == "file") {
                ?>
                    <div class="<?php echo $file_class ?>">
                        <div class="<?php echo $div_class ?>">
                            <i class="<?php echo $icon_class ?>"><?php echo $icon_content ?></i>
                            <label for="<?php echo $name ?>"><?php echo $label ?></label>
                            <input
                                name="<?php echo $name ?>"
                                type="<?php echo $type ?>"
                                class="<?php echo $class ?>"
                                value="<?php echo (isset($data[$name])) ? $data[$name] : $value; ?>"
                                placeholder="<?php echo $placeholder ?>"
                            >
                        </div>
                        <div class="<?php echo $class_wrapper ?>">
                            <input class="<?php echo $class_inputWrapper ?>" type="text">
                        </div>
                    </div>
  
                <?php
            } elseif($type == "radio") {
                ?>
                <div class="<?php echo $div_class ?>">
                    <label
                        class="<?php echo $idClass1 ; ?>"
                        for="<?php echo $idClass1 ; ?>">
                            <?php echo  $label; ?>
                    </label>
                    <div class="<?php echo $div_color1 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color1; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $idClass1 ; ?>"
                            id="<?php echo $idClass1 ; ?>"
                        /> 
                    </div>
                    <input
                        type="<?php echo $type ?>"
                        value="<?php echo  $value2; ?>"
                        name="<?php echo $name ?>"
                        class="<?php echo $idClass2 ; ?>"
                        id="<?php echo $idClass2 ; ?>"
                    />
                    <input 
                        type="<?php echo $type ?>"
                        value="<?php echo  $value3; ?>"
                        name="<?php echo $name ?>"
                        class="<?php echo $idClass3 ; ?>"
                        id="<?php echo $idClass3 ; ?>" 
                    />
                    <input
                        type="<?php echo $type ?>"
                        value="<?php echo  $value4; ?>"
                        name="<?php echo $name ?>"
                        class="<?php echo $idClass4; ?>"
                        id="<?php echo $idClass4; ?>"
                    />
                    <input
                        type="<?php echo $type ?>"
                        value="<?php echo  $value5; ?>"
                        name="<?php echo $name ?>"
                        class="<?php echo $idClass5; ?>"
                        id="<?php echo $idClass5; ?>"
                    />
                </div>
  
                <?php
            } else {
                ?>
                    <div class="<?php echo $div_class ?>">
                        <i class="<?php echo $icon_class ?>"><?php echo $icon_content ?></i>
                        <label for="<?php echo $name ?>"><?php echo $label ?></label>
                        <input
                            name="<?php echo $name ?>"
                            type="<?php echo $type ?>"
                            class="<?php echo $class ?>"
                            value="<?php echo (isset($data[$name])) ? $data[$name] : $value; ?>"
                        >
                    </div>

                <?php
            }
        }
        echo '<div class="row">'
                             . '<div class="col s4">'
                             . '<a class="waves-effect waves-light btn left grey lighten-2 black-text" href="#">'
                             . '<i class="material-icons left">subdirectory_arrow_left</i>Retour'
                             . '</a>'
                             . '</div>'
                             . '<div class="col s4"></div>'
                             . '<div class="col s4">'
                             . '<button name="submit" id="submit" type="submit" onclick="' . $this->onclick . '" class="btn right green accent-4">'. $this->submit 
                             . '<i class="material-icons">arrow_forward</i>'
                             . '</button>'
                             . '</div>';
        echo '</form>';
    }
}