<section>
    <div class="wrap">
        <h2><?= $this->stdArrayOptions['page_title']; ?></h2>
        <form method="post" enctype="multipart/form-data" action="options.php">
            <?php
            settings_fields( $this->stdArrayOptions['menu_slug'] ); // меняем под себя только здесь (название настроек)
            do_settings_sections( 'plugin-options' );
            ?>
            <?php submit_button(); ?>
        </form>
    </div>
</section>