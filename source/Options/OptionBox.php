<?php

namespace Options;

use Helpers\Strings;
use Helpers\GlobalStorage;


class OptionBox
{

    const PAGE_GENERAL    = 'general';
    const PAGE_READING    = 'reading';
    const PAGE_WRITING    = 'writing';
    const PAGE_DISCUSSION = 'discussion';
    const PAGE_MEDIA      = 'media';
    const PAGE_PERMALINK  = 'permalink';

    protected $_key   = null;

    protected $_title = null;

    protected $_page  = null;

    /** @var array $_options */
    protected $_options = [];

    /**
     *
     * @param string $key
     * @param string $title
     */
    public function __construct($key, $title)
    {
        $this->_key   = $this->unique($key);
        $this->_title = $title;
        $this->_options = [];

        add_action('admin_init', function () {
            $this->admin_init();
        });

        GlobalStorage::set($key, $this, __CLASS__);
    }

    public static function get($key)
    {
        return GlobalStorage::get($key, __CLASS__);
    }

    private function unique($key)
    {
        $key = sanitize_key($key);
        $keys = (array)GlobalStorage::get('option_box', 'keys');
        if (in_array($key, $keys)) {
            throw new \RuntimeException(sprintf('Option box %s has non unique key',
                $this->_title
            ));
        }

        array_push($keys, $key);
        GlobalStorage::set('option_box', $keys, 'keys');

        return $key;
    }

    /**
     *
     * @return string
     */
    public function get_page()
    {
        return $this->_page;
    }

    /**
     *
     * @param string $page
     */
    public function set_page($page)
    {
        $this->_page = (string)$page;
    }

    /**
     *
     * @return string
     */
    public function get_key()
    {
        return $this->_key;
    }

    /**
     *
     * @param Option $option
     * @return bool|string
     */
    public function add_option(Option $option)
    {
        $key = $option->get_key();
        if (!isset($this->_options[$key])) {
            $this->_options[$key] = $option;
            return $key;
        }

        return false;
    }

    public function get_option($name)
    {
        $key = sprintf('%s_%s', $this->_key, $name);
        foreach($this->_options as $name=>$value) {
            $pattern = sprintf('/^%s$/', preg_quote($key));
            if(preg_match($pattern, $name)) {
                return $value;
            }
        }

        return;
    }

    public function get_value($name)
    {
        $option = $this->get_option($name);
        if($option) {
            return $option->get_value();
        }

        return null;
    }

    public function get_options()
    {
        return $this->_options;
    }

    /**
     *
     * @param string $slug
     */
    public function remove_option($slug)
    {
        if (isset($this->_options[$slug])) {
            unset($this->_options[$slug]);
        }
    }

    public function add($name, $title, array $params = [])
    {
        $key = sprintf('%s_%s', $this->_key, $name);
        $this->add_option(new Option($key, $title, $params));
    }

    protected function admin_init()
    {
        $this->_enqueue_javascript();
        add_settings_section($this->_key, $this->_title, null, $this->_page);

        foreach ($this->_options as $option) {
            register_setting($this->_page, $option->get_key(), [$option, 'filter']);
            add_settings_field($option->get_key(), $option->get_label(), [$option, 'render'], $this->_page, $this->_key);
        }
    }

    protected function _enqueue_javascript()
    {
        if (is_admin() && ($this->_is_default_page() || isset($_REQUEST['page']) && $_REQUEST['page'] == $this->_page)) {
            foreach ($this->_options as $option) {
                $field = $option->get_field();
                if (method_exists($field, 'enqueue_javascript')) {
                    $field->enqueue_javascript();
                }

                if (method_exists($field, 'enqueue_style')) {
                    $field->enqueue_style();
                }
            }
        }
    }

    protected function _is_default_page()
    {
        $reflection = new \ReflectionClass(__CLASS__);
        if (in_array($this->_page, $reflection->getConstants())) {
            $length = mb_strlen($_SERVER['REQUEST_URI'], 'UTF-8');
            if(mb_strpos($_SERVER['REQUEST_URI'], "options-{$this->_page}.php", $length, 'UTF-8') !== false) {
                return true;
            }
        }

        return false;
    }

}
