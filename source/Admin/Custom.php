<?php

namespace Admin;

abstract class Custom extends AbstractPage
{

    public function __construct($key, $title, $parent = null)
    {
        parent::__construct($key, $title, $parent);

        add_action('wp_ajax_' . $this->get_ajax_action(), function () {
            $this->_ajax_action();
        });

        if (is_admin() && isset($_REQUEST['page']) && $_REQUEST['page'] == $this->_key && isset($_POST) && ! empty($_POST)) {
            add_action('init', function () {
                $this->_post_action();
            });
        }
    }

    /**
     *
     * Action executed on POST request
     */
    abstract protected function _post_action();

    /**
     *
     * Action executed on ajax request
     */
    abstract protected function _ajax_action();

    /**
     * Get custom admin page ajax action
     *
     * @return string
     */
    public function get_ajax_action()
    {
        return 'custom_page_' . $this->_key;
    }

    /**
     * Get custom admin page ajax url
     *
     * @return string
     */
    public function get_ajax_url()
    {
        return admin_url('admin-ajax.php') . '?action=' . $this->get_ajax_action();
    }

}