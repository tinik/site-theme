<?php

namespace Options;

use Fields\AbstractField;
use Fields\FieldFactory;
use Fields\Text;
use Helpers\Action;
use Helpers\GlobalStorage;

class Option
{

    protected $_key    = null;

    protected $_title  = null;

    /** @var AbstractField */
    protected $_field  = null;

    protected $_params = [];

    protected $_value  = null;

    /**
     *
     * @param string $key
     * @param string $title
     * @param array  $params
     */
    public function __construct($key, $title, array $params = [])
    {
        $this->_key    = $this->unique($key);
        $this->_title  = $title;
        $this->_params = new \ArrayObject($params, \ArrayObject::ARRAY_AS_PROPS);

        $this->get_value();
    }

    public function get_params($name = null, $default = null)
    {
        if(!$name) {
            return $this->_params;
        }

        if($this->_params->offsetExists($name)) {
            return $this->_params->offsetGet($name);
        }

        return $default;
    }

    private function unique($key)
    {
        $key  = sanitize_key($key);
        $keys = (array)GlobalStorage::get('option', 'keys');
        if (in_array($key, $keys)) {
            throw new \RuntimeException(sprintf(
                'Option "%s" has non unique key',
                $key
            ));
        }

        array_push($keys, $key);
        GlobalStorage::set('option', $keys, 'keys');

        return $key;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return get_option('option_' . sanitize_key($key));
    }

    public function get_value()
    {
        if(!$this->_value) {
            $this->_value = get_option($this->_key);
        }

        return $this->_value;
    }

    /**
     *
     * @return string
     */
    public function get_key()
    {
        return $this->_key;
    }

    /**
     *
     * @return string
     */
    public function get_title()
    {
        return $this->_title;
    }

    /**
     *
     * @return string
     */
    public function get_label()
    {
        $id = $this->get_field()->get_name();
        return "<label for='$id'>{$this->_title}</label>";
    }

    /**
     *
     * @return AbstractField
     * @throws RuntimeException
     */
    public function get_field()
    {
        if ($this->_field == null) {
            $init = $this->_params->offsetGet('field');

            if ($init == null) {
                $this->_field = new Text();
            } elseif (is_string($init)) {
                $this->_field = FieldFactory::create($init);
            } elseif($init instanceof AbstractField) {
                $this->_field = $init;
            } elseif (Action::is_callable($init)) {
                $this->_field = Action::execute($init);

                if (!$this->_field instanceof AbstractField) {
                    throw new \RuntimeException(sprintf(
                        'Option "%s" init function must return a Field.',
                        $this->_title
                    ));
                }
            } else {
                throw new \RuntimeException('Invalid field type.');
            }

            $this->_field->set_name($this->_key);
            $this->_field->set_label($this->_title);
        }

        return $this->_field;
    }

    public function render()
    {
        $value = $this->get_value();

        $field = $this->get_field();
        $field->set_value($value);

        echo $field->render_field();
    }

    /**
     *
     * @param string $input
     */
    public function filter($input)
    {
        $field = $this->get_field();
        $field->set_value($input);

        return $field->get_value();
    }

}
