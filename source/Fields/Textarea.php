<?php

namespace Fields;

class Textarea extends AbstractField
{

    public function __construct($name, array $options = [])
    {
        parent::__construct($name, $options);

        $options['attributes'] = ['rows' => 10, 'style' => 'resize: vertical'];
    }

    public function render_field()
    {
        $attr = '';
        if(!empty($this->_options['attributes'])) {
            $attr = $this->attributes($this->_options['attributes']);
        }

        return vsprintf('<textarea name="%s" id="%s" %s >%s</textarea>', [
            $this->get_name(),
            $this->get_name(),
            $attr,
            $this->get_value()
        ]);
    }

}