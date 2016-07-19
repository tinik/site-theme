<?php

namespace Admin;

use Options\OptionBox;

class Options extends AbstractAdmin
{

    /**
     * Get page content html
     *
     * @return string
     */
    public function render()
    {
        print '<div class="wrap">';
        print "<h2>{$this->_title}</h2>";
        print '<form action="' . admin_url('options.php') . '" method="POST">';
        settings_fields($this->_key);
        do_settings_sections($this->_key);
        submit_button();
        print '</form>';
        print '</div>';
    }

    /**
     * Add OptionBox to display on admin page
     *
     * @param OptionBox $box
     */
    public function add_box(OptionBox $box)
    {
        $box->set_page($this);
    }

}
