<?php

namespace Menu\Add;

class Page {

    protected $stdArrayOptions;

    /**
     * Создание пункта меню и страницы.
     * Объединяем шаблон массива с переданный в аргументе.
     * Создание страницы.
     *
     * @param array $args
     */
    public function create( array $args = [] ) {
        if ( empty( $args['in'] ) || $args['in'] === 'menu' ) {
            add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
            unset( $args['in'] );
        } elseif ( $args['in'] === 'settings' ) {
            add_action( 'admin_menu', array( $this, 'add_options_page' ) );
        }

        add_filter( 'plugin_action_links', array( $this, 'msp_helloworld_settings_link' ), 2, 2 );

        $this->stdArrayOptions = $args;
        $this->stdArrayOptions = array_merge( $this->get_options(), $args );
    }

    public function msp_helloworld_settings_link( $actions, $file )
    {
        if ( false !== strpos( $file, 'untitled' ) ) {
            $actions['settings'] = '<a href="admin.php?page='.$this->stdArrayOptions['plugin_slug'].'">Settings</a>';
        }

        return $actions;
    }


    /**
     * Стандартный шаблон массива.
     *
     * @return array
     */
    protected function get_options() {
        $args = array(
            'admin_menu'     => true,
            'admin_sub_menu' => array(),
            'plugin_name'    => $this->stdArrayOptions['plugin_name'],
            'plugin_slug'    => $this->stdArrayOptions['plugin_slug'],
            'page_title'     => $this->stdArrayOptions['plugin_name'],
            'menu_title'     => $this->stdArrayOptions['plugin_name'],
            'menu_slug'      => $this->stdArrayOptions['plugin_slug'],
            'capability'     => 'edit_others_posts',
        );

        return $args;
    }

    public function add_options_page() {
        $pageTitle  = $this->stdArrayOptions['page_title'];
        $menuTitle  = $this->stdArrayOptions['menu_title'];
        $capability = $this->stdArrayOptions['capability'];
        $menuSlug   = $this->stdArrayOptions['menu_slug'];

        add_options_page( $pageTitle, $menuTitle, $capability, $menuSlug, array(
            $this,
            'plugin_page_functions'
        ) );
    }

    public function plugin_page_settings() {
        ?>
        <div class="wrap">
        <h2>Дополнительные параметры сайта<?= $this->stdArrayOptions['menu_slug']; ?></h2>
        <form method="post" enctype="multipart/form-data" action="options.php">
            <?php
            settings_fields( 'true_options' ); // меняем под себя только здесь (название настроек)
            do_settings_sections( 'my-test' );
            ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>"/>
            </p>
        </form>
        </div><?php
    }

    public function add_menu_page() {
        $pageTitle  = $this->stdArrayOptions['page_title'];
        $menuTitle  = $this->stdArrayOptions['menu_title'];
        $capability = $this->stdArrayOptions['capability'];
        $menuSlug   = $this->stdArrayOptions['menu_slug'];

        add_menu_page( $pageTitle, $menuTitle, $capability, $menuSlug, array(
            $this,
            'plugin_page_functions'
        ), 'dashicons-admin-settings', 99 );
    }

    public function plugin_page_functions() {

//        add_action( 'admin_init', array( $this, 'register_my_setting' ) );

        include_once DIR_VIEW . 'functions.php';
        include DIR_VIEW . 'index.php';

    }
}