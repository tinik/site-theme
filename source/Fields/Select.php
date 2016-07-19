<?php

namespace Fields;

class Select extends AbstractField
{

    public function __construct($name, array $options = [])
    {
        parent::__construct($name, $options);
        if (! empty($this->_options['value_options'])) {
            $this->set_options($this->_options['value_options']);
        }
    }

    /**
     * Render only field html
     *
     * @return string
     */
    public function render_field()
    {
        $attr = '';
        if(!empty($this->_options['attributes'])) {
            $attr = $this->attributes($this->_options['attributes']);
        }

        $name = $this->get_name();
        return vsprintf('<select name="%s" id="%s" %s>%s</select>', [
            $name,
            $name . ($this->is_multiple() ? '[]' : ''),
            $attr,
            $this->_render_options()
        ]);
    }

    /**
     * Get options of select
     *
     * @return array
     */
    public function get_options()
    {
        return $this->_options['value_options'];
    }

    /**
     * Set options of select
     *
     * @param array $options
     *            key => value to set
     */
    public function set_options(array $options)
    {
        foreach ($options as $key => $title) {
            $this->add_option($title, $key);
        }
    }

    /**
     * Add single option
     *
     * @param string $title
     * @param mixed $key
     */
    public function add_option($title, $key = null)
    {
        if ($key === null) {
            $key = sanitize_key($title);
        }

        $sufix = 1;
        while (isset($this->_options[$key])) {
            $key = sanitize_key($title) . '-' . $sufix;
            $sufix ++;
        }

        $this->_options[$key] = esc_html($title);
    }

    /**
     * Sort options
     *
     * @param bool $desc
     * @return bool
     */
    public function sort_options($desc = false)
    {
        return $desc ? arsort($this->_options) : asort($this->_options);
    }

    /**
     * Get field value
     *
     * @param bool $humanic
     *            if $humanic = false, will return a key of option
     * @return null|string
     */
    public function get_value($humanic = false)
    {
        return $humanic ? $this->get_option_value(parent::get_value()) : parent::get_value();
    }

    /**
     * Set field value
     *
     * @param mixed $value
     *            field value
     */
    public function set_value($value)
    {
        if ($this->is_multiple() && is_array($value)) {
            $new_value = [];
            foreach ($value as $v) {
                $new_value[] = $this->_set_single_value($v);
            }
        }
        else {
            $new_value = $this->_set_single_value($value);
        }
        $this->_value = $new_value;
    }

    protected function _set_single_value($value)
    {
        $key = sanitize_key($value);
        if (array_key_exists($key, $this->_options)) {
            return $key;
        } else {
            foreach ($this->_options as $key => $option) {
                if ($value == $option) {
                    return $key;
                    break;
                }
            }
        }

        return null;
    }

    protected function _render_options()
    {
        if(empty($this->_options['value_options'])) {
            return '';
        }

        $output = [];
        foreach ($this->_options['value_options'] as $key => $title) {
            $selected = $this->_selected($key);
            $output[] = "<option {$selected} value='{$key}'>{$title}</option>";
        }

        return join('', $output);
    }

    protected function _selected($value)
    {
        if ($this->is_multiple()) {
            if (is_array($this->get_value()) && in_array($value, $this->get_value())) {
                return selected($value, $value, false);
            }

            return "";
        } else {
            return selected($value, $this->get_value(), false);
        }
    }

    /**
     * Check, is select is multiple
     *
     * @return bool
     */
    public function is_multiple()
    {
        return isset($this->_attributes['multiple']);
    }

    /**
     * Set multiple attribute
     *
     * @param bool $is_multiple
     */
    public function set_multiple($is_multiple)
    {
        if ($is_multiple) {
            $this->_attributes['multiple'] = 'multiple';
        }
        elseif ($this->is_multiple()) {
            unset($this->_attributes['multiple']);
        }
    }
}