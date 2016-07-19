<?php

namespace Fields;

class Button extends AbstractField
{

    public function render_field()
    {
        $attr = '';
        if(!empty($this->_options['attributes'])) {
            $attr = $this->attributes($this->_options['attributes']);
        }

        $type = 'button';
        if(!empty($this->_options['submit']) && $this->_options['submit'] == true) {
            $type = 'submit';
        }

        return vsprintf('<input type="%s" id="%s" %s value="%s" />', [
            $type,
            $this->get_name(),
            $attr,
            $this->get_value()
        ]);
    }

}