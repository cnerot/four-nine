<?php


class File
{
    private $file;

    /**
     * File constructor.
     * @param $_FILE array key @string
     */
    public function __construct($file)
    {
        if (isset($_FILES[$file])) {
            $this->file = $_FILES[$file];
            return $this;
        }
        return false;
    }

    /**
     * Check file size
     * @param $file = $_FILE
     * @param $size
     * @param $size_ratio ("o", "ko" or "go");
     * @return bool
     */
    public function check_size($size = 102400, $size_ratio = "o")
    {
        if (!isset($this->file['size']))
            return false;
        switch ($size_ratio) {
            case "o":
                $mutiplier = 1;
                break;
            case "ko":
                $mutiplier = 1024;
                break;
            case "mo":
                $mutiplier = 1048576;
                break;
            case "go":
                $mutiplier = 1073741824;
                break;
            default:
                $mutiplier = 1;
                break;
        }
        if (intval($this->file['size']) <= $size * $mutiplier)
            return true;
        return false;
    }

    /**
     * Check file extention
     * @param $file = $_FILES
     * @param $allowed_extentions = array("extention list");
     * @return bool
     */
    public function check_extention($allowed_extentions)
    {
        $file = explode('.', $this->file['name']);
        $file = end($file);
        if (in_array($file, $allowed_extentions)) {
            return true;
        }
        return false;
    }

    /**
     * @param $allowed_types
     * @return bool
     */
    public function check_type($allowed_types)
    {
        if (in_array($this->file['type'], $allowed_types)) {
            return true;
        }
        return false;
    }
    public function getTmpName()
    {
        return $this->file['tmp_name'];
    }
    public function getName()
    {
        return $this->file['name'];

    }
}