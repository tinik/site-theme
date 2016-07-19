<?php

namespace Fields;

class Radio extends Select
{

    /**
     * Render only field html
     *
     * @return string
     */
    public function render_field()
    {
        return $this->_render_options();
    }

    protected function _render_options()
    {
        $name = $this->get_name();

        $output = sprintf('<input type="hidden" name="%s" value="" />', $name);
        if(empty($this->_options['value_options'])) {
            return '';
        }

        $attr = '';
        if(!empty($this->_options['attributes'])) {
            $attr = $this->attributes($this->_options['attributes']);
        }

        $output = [];
        foreach ($this->_options['value_options'] as $value => $title) {
            $output[] = sprintf(
                '<label><input type="radio" name="%s" id="%s" value="%s" %s %s /> %s</label>',
                $name,
                $name .'_'. $value,
                $value,
                checked($value, $this->get_value(), false),
                $attr,
                $title
            );
        }

        return join("<br />\n", $output);
    }

    /**
     * Render only label html
     *
     * @return string
     */
    public function render_label()
    {
        if($this->get_label()) {
            return sprintf('<label style="font-weight:bold">%s</label>', $this->get_label());
        }

        return '';
    }

}