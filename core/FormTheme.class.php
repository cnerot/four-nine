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
            if (isset($input['div_color2'])) {
                $div_color2 = $input['div_color2'];
            } else {
                $div_color2 = "";
            }
            if (isset($input['div_color3'])) {
                $div_color3 = $input['div_color3'];
            } else {
                $div_color3 = "";
            }
            if (isset($input['div_color4'])) {
                $div_color4 = $input['div_color4'];
            } else {
                $div_color4 = "";
            }
            if (isset($input['div_color5'])) {
                $div_color5 = $input['div_color5'];
            } else {
                $div_color5 = "";
            }
            if (isset($input['div_color6'])) {
                $div_color6 = $input['div_color6'];
            } else {
                $div_color6 = "";
            }
            if (isset($input['div_color7'])) {
                $div_color7 = $input['div_color7'];
            } else {
                $div_color7 = "";
            }
            if (isset($input['div_color8'])) {
                $div_color8 = $input['div_color8'];
            } else {
                $div_color8 = "";
            }
            if (isset($input['div_color9'])) {
                $div_color9 = $input['div_color9'];
            } else {
                $div_color9 = "";
            }
            if (isset($input['div_color10'])) {
                $div_color10 = $input['div_color10'];
            } else {
                $div_color10 = "";
            }
            if (isset($input['div_color11'])) {
                $div_color11 = $input['div_color11'];
            } else {
                $div_color11 = "";
            }
            if (isset($input['div_color12'])) {
                $div_color12 = $input['div_color12'];
            } else {
                $div_color12 = "";
            }
            if (isset($input['div_color13'])) {
                $div_color13 = $input['div_color13'];
            } else {
                $div_color13 = "";
            }
            if (isset($input['div_color14'])) {
                $div_color14 = $input['div_color14'];
            } else {
                $div_color14 = "";
            }
            if (isset($input['div_color15'])) {
                $div_color15 = $input['div_color15'];
            } else {
                $div_color15 = "";
            }
            if (isset($input['div_color16'])) {
                $div_color16 = $input['div_color16'];
            } else {
                $div_color16 = "";
            }
            if (isset($input['div_color17'])) {
                $div_color17 = $input['div_color17'];
            } else {
                $div_color17 = "";
            }
            if (isset($input['div_color18'])) {
                $div_color18 = $input['div_color18'];
            } else {
                $div_color18 = "";
            }
            if (isset($input['div_color19'])) {
                $div_color19 = $input['div_color19'];
            } else {
                $div_color19 = "";
            }
            if (isset($input['div_color20'])) {
                $div_color20 = $input['div_color20'];
            } else {
                $div_color20 = "";
            }
            if (isset($input['div_color21'])) {
                $div_color21 = $input['div_color21'];
            } else {
                $div_color21 = "";
            }
            if (isset($input['div_color22'])) {
                $div_color22 = $input['div_color22'];
            } else {
                $div_color22 = "";
            }
            if (isset($input['div_color23'])) {
                $div_color23 = $input['div_color23'];
            } else {
                $div_color23 = "";
            }
            if (isset($input['div_color24'])) {
                $div_color24 = $input['div_color24'];
            } else {
                $div_color24 = "";
            }
            if (isset($input['div_color25'])) {
                $div_color25 = $input['div_color25'];
            } else {
                $div_color25 = "";
            }
            if (isset($input['div_color26'])) {
                $div_color26 = $input['div_color26'];
            } else {
                $div_color26 = "";
            }
            if (isset($input['div_color27'])) {
                $div_color27 = $input['div_color27'];
            } else {
                $div_color27 = "";
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
                                
                            >
                        </div>
                        <div class="<?php echo $class_wrapper ?>">
                            <input class="<?php echo $class_inputWrapper ?>" placeholder="<?php echo $placeholder ?>" type="text">
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
                    <div class="center-align <?php echo $div_color1 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color1; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id="<?php echo $idClass1 ; ?>"
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color2 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color2; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id="<?php echo $idClass2 ; ?>"
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color3 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color3; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id="<?php echo $idClass3 ; ?>"
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color4 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color4; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id="<?php echo $idClass3 ; ?>"
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color5 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color5; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id="<?php echo $idClass5 ; ?>"
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color6 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color6; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        />
                    </div>
                    <div class="center-align <?php echo $div_color7 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color7; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color8 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color8; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color9; ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color9; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color10 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color10; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color11 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color11; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color12 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color12; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color13 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color13; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color14 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color14; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color15 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color15; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color16 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color16; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color17 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color17; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color18 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color18; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color19 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color19; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color20 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color20; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color21 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color21; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color22 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color22; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color23 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color23; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color24 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color24; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color25 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color25; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color26 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color26; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                    <div class="center-align <?php echo $div_color27 ?>">
                        <input
                            type="<?php echo $type ?>"
                            value="<?php echo  $div_color27; ?>"
                            name="<?php echo $name ?>"
                            class="<?php echo $class ; ?>"
                            id=""
                        /> 
                    </div>
                </div>
                <br/>
  
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