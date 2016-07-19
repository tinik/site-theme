<?php

namespace Admin;

use Helpers\GlobalStorage;

abstract class AbstractAdmin
{

    protected $_key = null;

    protected $_title = null;

    protected $_parent = null;

    protected $_menu_icon = null;

    protected $_menu_position = null;

    public function __construct($key, $title, $parent = null)
    {
        $this->_title = $title;
        $this->_key = $this->unique($key);
        $this->_parent = $parent;

        add_filter('admin_init', function() {
            if(method_exists($this, '_register_fields')) {
                $this->_register_fields();
            }
        });

        add_action('admin_menu', function () {
            $this->_add_action_admin_menu();
        });
    }

    protected function unique($key)
    {
        $key  = sanitize_key($key);
        $keys = (array)GlobalStorage::get('admin_page', 'keys');
        if (in_array($key, $keys)) {
            throw new \RuntimeException(sprintf('Admin page "%s" has non unique key',
                $this->_title
            ));
        }

        array_push($keys, $key);
        GlobalStorage::set('admin_page', $keys, 'keys');
        return $key;
    }

    public function __toString()
    {
        return (string)$this->_key;
    }

    /**
     * Get page slug
     *
     * @return string
     */
    public function get_key()
    {
        return $this->_key;
    }

    /**
     * Set position in admin menu
     *
     * @param int $position
     */
    public function set_menu_position($position)
    {
        $this->_menu_position = $position;
    }

    /**
     * Get position in admin menu
     *
     * @return int
     */
    public function get_menu_position()
    {
        return $this->_menu_position;
    }

    /**
     * Set menu item image url, or svg/base64 code, or dashicons name (see https://developer.wordpress.org/resource/dashicons/)
     *
     * @param string $icon
     */
    public function set_menu_icon($icon)
    {
        $this->_menu_icon = $icon;
    }

    /**
     * Get menu item image
     *
     * @return string
     */
    public function get_menu_icon()
    {
        return $this->_menu_icon;
    }

    protected function _add_action_admin_menu()
    {
        $handler = [$this, 'render'];
        if (is_null($this->_parent)) {
            add_menu_page($this->_title, $this->_title, 'manage_options', $this->_key, $handler, $this->_menu_icon, $this->_menu_position);
        } else {
            add_submenu_page($this->_parent, $this->_title, $this->_title, 'manage_options', $this->_key, $handler);
        }
    }

    /**
     * Get page title
     *
     * @return string
     */
    public function get_title()
    {
        return $this->_title;
    }

    /**
     * Get page url
     *
     * @return string
     */
    public function get_page_url()
    {
        $s = strpos(admin_url($this->_parent), '?') ? '&' : '?';
        return admin_url($this->_parent) . $s . 'page=' . $_REQUEST['page'];
    }

    /**
     * Get page content html
     *
     * @return string
     */
    abstract public function render();
}
