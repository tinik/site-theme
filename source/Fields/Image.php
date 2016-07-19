<?php

namespace Fields;


class Image extends File
{

    protected $_type    = 'image';
    protected $_accepts = ['image'];
    protected $_labels  = [
        'title'         => 'Select image',
        'upload_button' => 'Browse',
        'remove_button' => 'Remove Image'
    ];

    /**
     * Set file types accepts is not allowed
     *
     * @param array $accepts
     * @throws RuntimeException
     */
    public function set_accepts(array $accepts)
    {
        throw new \RuntimeException('Image Field can accept only images.');
    }

    protected function _render_file()
    {
        if($this->_value) {
            return vsprintf('%s <strong style="display:none" data-role="title">%s</strong>', [
                wp_get_attachment_image($this->_value, 'thumbnail', true),
                get_the_title($this->_value)
            ]);
        } else {
            return '<img style="display:none" src="" alt="" /><strong style="display: none" data-role="title"></strong>';
        }
    }

}
