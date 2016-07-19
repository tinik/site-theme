<?php

namespace Fields;

abstract class AbstractField
{

    protected $_name = null;
    protected $_value = null;
    protected $_options = [];
    protected $_type = '';

    public function __construct($name, array $options = [])
    {
        $this->_name    = $name;
        $this->_options = new \ArrayObject($options, \ArrayObject::ARRAY_AS_PROPS);
        $this->_value   = &$this->_options['value'];
    }

    /**
     * Get field html
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    public function type()
    {
        return $this->_type;
    }

    /**
     * Get field label
     *
     * @return Label
     */
    public function label()
    {
        return $this->_options['label'];
    }

    /**
     * Set field name
     *
     * @param string $name field name
     * @param bool $sanitize use sanitize filter
     */
    public function set_name( $name, $sanitize = true )
    {
        $this->_name = $sanitize ? sanitize_key( $name ) : $name;
    }

    /**
     * Get field name
     *
     * @return string field name
     */
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * Set label text
     *
     * @param string $label
     */
    public function set_label( $label )
    {
        return $this->_options['label'] = $label;
    }

    /**
     * Get label text
     *
     * @return string
     */
    public function get_label()
    {
        return $this->_options['label'];
    }

    /**
     * Set field value
     *
     * @param mixed $value field value
     */
    public function set_value( $value )
    {
        if(method_exists($this, 'apply_filter')) {
            $value = $this->apply_filter( $value );
        }

        $this->_value = $value;
    }

    /**
     * Get field value
     *
     * @return string
     */
    public function get_value()
    {
        return $this->_value;
    }

    /**
     * Render full field html (with label)
     *
     * @return string
     */
    public function render()
    {
        $attr = '';
        if(!empty($this->_options['wrapper']['attributes'])) {
            $attr = $this->attributes($this->_options['wrapper']['attributes']);
        }

        $label  = $this->render_label();
        if(!empty($label)) {
            $label .= '<br />';
        }
        $field = $this->render_field();
        return sprintf('<p class="wrapper form-group" %s>%s%s</p>', $attr, $label, $field);
    }

    /**
     * Render only field html
     *
     * @return string
     */
    abstract public function render_field();

    /**
     * Render only label html
     *
     * @return string
     */
    public function render_label()
    {
        if (empty($this->_options['label'])) {
            return '';
        }

        $attr = '';
        if (!empty($this->_options['label_attributes'])) {
            $attr = $this->attributes($this->_options['label_attributes']);
        }

        return sprintf('<label for="%s" %s>%s</label>', $this->get_name(), $attr, $this->get_label());
    }

    public function render_attributes()
    {
        $attr = '';
        if(!empty($this->_options['attributes'])) {
            $attr = $this->attributes($this->_options['attributes']);
        }

        return $attr;
    }

    static public function attributes(array $attributes = [])
    {
        if(!$attributes) {
            return '';
        }

        $render = [];
        foreach ($attributes as $name=>$value) {
            $render[] = sprintf('%s="%s"', $name, esc_attr($value));
        }

        return join(' ', $render);
    }

    /**
     * Get filed <option> value by key
     *
     * @param $option_key
     * @return mixed
     */
    protected function get_option_value($option_key)
    {
        return array_key_exists($option_key, $this->_options) ? $this->_options[$option_key] : null;
    }

}