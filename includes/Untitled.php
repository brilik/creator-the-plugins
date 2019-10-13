<?php

class Untitled {

    protected $pluginName = 'Untitled';
    protected $menuName;
    protected $pluginSlug;
    protected $menuAddPage;

    public function create_menu( string $menuName = 'Untitled' )
    {
        include_once DIR_INCL . 'menu/Page.php';
        include_once DIR_INCL . 'help/Translit.php';

        $this->pluginName = $menuName;
        $this->menuName   = $menuName;
        $this->pluginSlug = Translit::str2url( $this->pluginName );
        $page             = new \Menu\Add\Page();

        $page->create( [
            'in'          => 'menu',
            'page_title'  => 'Plugin general options',
            'plugin_name' => $this->menuName,
            'plugin_slug' => $this->pluginSlug,
        ] );

    }


    /**
     * Добавление опций.
     * Необходимо передать массив, где два поля должны присутствовать обязательно:
     * строку sec_title и массив sec_options
     *
     * @param array $args
     *
     * @throws Exception
     * @example
     * 'sec_title'   => 'Content view test #1',
     * 'sec_options' => array([
     * 'input' => 'checkbox',
     * 'title' => 'Test option',
     * 'label' => 'label for option',
     * ],
     * [
     * 'input' => 'text',
     * 'title' => 'Test title',
     * 'label' => 'label for title',
     * ])
     */
    public function add_option( array $args ) {

        if ( empty( $args['sec_title'] ) ) {
            throw new Exception( 'При создании опции возникла ошибка: необходимо передать массив с ключем sec_title и названием секции' );
        }

        include_once DIR_INCL . 'menu/Options.php';

        $options              = new \Menu\Add\Options();

        foreach ( $args['sec_options'] as $key => $option ) {

            if ( empty( $option['input'] ) || empty( $option['title'] ) ) {
                throw new Exception( 'Error: При создании опции возникла ошибка: необходимо передать массив с ключем sec_options и названием секции' );
            }
        }

        $options->create( [
            'id'   => $this->pluginSlug,
            'page' => 'plugin-options',
            'options' => $args
        ] );
    }
}