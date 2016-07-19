<?php

namespace Fields;

class Text extends AbstractField
{

    protected $_type = 'text';

    public function render_field()
    {
        return vsprintf('<input type="text" name="%s" id="%s" %s value="%s" />', [
            $this->get_name(),
            $this->get_name(),
            $this->render_attributes(),
            $this->get_value()
        ]);
    }

}