<?php
/**
 * PHP表单生成器
 *
 * @package  FormBuilder
 * @author   xaboy <xaboy2005@qq.com>
 * @version  2.0
 * @license  MIT
 * @link     https://github.com/xaboy/form-builder
 */

namespace Xaboy\FormBuilder\driver;


use Xaboy\FormBuilder\contract\ValidateInterface;
use Xaboy\FormBuilder\rule\CallPropsRule;

abstract class FormComponent extends CustomComponent
{
    use CallPropsRule;

    protected static $propsRule = [];

    protected $defaultValue = '';

    protected $selectComponent = false;

    /**
     * FormComponentDriver constructor.
     *
     * @param string $field 字段名
     * @param string $title 字段昵称
     * @param mixed $value 字段值
     */
    public function __construct($field, $title, $value = null)
    {
        parent::__construct();
        $this->field($field)->title($title)->value(is_null($value) ? $this->defaultValue : $value);
        if (isset(static::$propsRule['placeholder']))
            $this->placeholder($this->getPlaceHolder());
        $this->init();
    }

    protected function init()
    {
    }

    /**
     * @return ValidateInterface
     */
    abstract public function createValidate();


    /**
     * @param null|string $message
     * @return $this
     */
    public function required($message = null)
    {
        if (is_null($message)) $message = $this->getPlaceHolder();
        $this->appendValidate($this->createValidate()->message($message)->required());
        return $this;
    }

    /**
     * @return string
     */
    protected function getPlaceHolder()
    {
        return ($this->selectComponent ? '请选择' : '请输入') . $this->title;
    }
}