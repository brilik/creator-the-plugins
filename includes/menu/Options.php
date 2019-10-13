<?php


namespace Menu\Add;


class Options {

    protected $argOptions;

    public function create( array $args ) {
        $this->argOptions = $args;
        add_action( 'admin_init', array( $this, 'settings_api_init' ) );
    }

    private function add_field_select($key, $secID) {
        // Создадим выпадающий список
        $true_field_params = array(
            'type' => 'select',
            'id'   => 'my_select',
            'desc' => 'Пример выпадающего списка.',
            'vals' => array( 'val1' => 'Все могут быть популярные', 'val2' => 'Только выбранные посты могут быть популярными' )
        );
        add_settings_field(
            $this->argOptions['id'] . '_setting_'. $key,
            'Посты набирающие популярность',
            array( $this, 'true_option_display_settings' ),
            $this->argOptions['page'],
            $secID,
            $true_field_params
        );
    }

    private function add_field_checkbox($key, $secID, $option) {
        // Создадим чекбокс
        $true_field_params = array(
            'type' => 'checkbox',
            'id'   => 'my_checkbox',
            'desc' => $option['label']
        );
        add_settings_field(
            $this->argOptions['id'] . '_setting_' . $key,
            $option['title'],
            array( $this, 'true_option_display_settings' ),
            $this->argOptions['page'], // страница
            $secID,
            $true_field_params
        );
    }

    private function add_field_text($key, $secID, $args) {
        add_settings_field(
            $this->argOptions['id'] . '_setting_'.$key,
            $args['title'],
            array( $this, 'eg_setting_callback_function2' ),
            $this->argOptions['page'], // страница
            $secID
        );
    }

    public function settings_api_init() {

        register_setting( $this->argOptions['page'], $this->argOptions['id'] . '_setting' );
        $id = $this->argOptions['id'] . '_setting';
        add_settings_section(
            $id.'', // секция
            $this->argOptions['options']['sec_title'].'',
            array( $this, 'eg_setting_section_callback_function' ),
            $this->argOptions['page'].'' // страница
        );

        foreach ( $this->argOptions['options']['sec_options'] as $key => $option ) {
//            print '<pre style="margin: 150px;">';
//            print_r($option);
//            print '</pre>';
            if( $option['input'] === 'select' )
                $this->add_field_select($key, $id, $option);
            elseif( $option['input'] === 'checkbox' )
                $this->add_field_checkbox($key, $id, $option);
            elseif ( $option['input'] === 'text' )
                $this->add_field_text($key, $id, $option);
        }
    }

    public function eg_setting_section_callback_function() {
        echo '<p>Текст описывающий блок настроек</p>';
    }

    public function eg_setting_callback_function() {
        echo '<input 
		name="eg_setting_name" 
		type="checkbox" 
		' . checked( 1, get_option( 'eg_setting_name' ), false ) . ' 
		value="1" 
		class="code" 
	/>';
    }

    public function eg_setting_callback_function2() {
        echo '<input 
		name="eg_setting_name2"  
		type="text" 
		value="' . get_option( 'eg_setting_name2' ) . '" 
		class="code2"
	 />';
    }


    /*
 * Функция отображения полей ввода
 * Здесь задаётся HTML и PHP, выводящий поля
 */
    function true_option_display_settings( $args ) {
        extract( $args );

        $option_name = 'true_options';

        $o = get_option( $option_name );

        switch ( $type ) {
            case 'text':
                $o[ $id ] = esc_attr( stripslashes( $o[ $id ] ) );
                echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";
                echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";
                break;
            case 'textarea':
                $o[ $id ] = esc_attr( stripslashes( $o[ $id ] ) );
                echo "<textarea class='code large-text' cols='50' rows='10' type='text' id='$id' name='" . $option_name . "[$id]'>$o[$id]</textarea>";
                echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";
                break;
            case 'checkbox':
                $checked = ( $o[ $id ] == 'on' ) ? " checked='checked'" : '';
                echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";
                echo ( $desc != '' ) ? $desc : "";
                echo "</label>";
                break;
            case 'select':
                echo "<select id='$id' name='" . $option_name . "[$id]'>";
                foreach ( $vals as $v => $l ) {
                    $selected = ( $o[ $id ] == $v ) ? "selected='selected'" : '';
                    echo "<option value='$v' $selected>$l</option>";
                }
                echo ( $desc != '' ) ? $desc : "";
                echo "</select>";
                break;
            case 'radio':
                echo "<fieldset>";
                foreach ( $vals as $v => $l ) {
                    $checked = ( $o[ $id ] == $v ) ? "checked='checked'" : '';
                    echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
                }
                echo "</fieldset>";
                break;
        }
    }
}