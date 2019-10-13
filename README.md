<h1> Creator the plugins </h1>
<p>Реализованный готовый код поможет создать Ваш плагин.
   Готовый функционал очень гибкий.</p>
<h4>Инструкция:</h4>
<span>В экземпляре класса, присутствуют такие методы, как</span>
<ol>

<li>
 <b> create_menu( string $plugin_name ) </b>
 - создаёт пункт меню с названием переданным в аргументе;
</li>

<li>
 <b>add_option( array $section_options )</b>
 
 - создаёт опции упираясь на переданный массив;
 В массиве обязательно должны присутсвовать параметры, т.к. 
  
  'sec_title'   => имя секции 
 
 'sec_options' => массив элементов формы 
  
<h6>EXAMPLE</h6>
   
 array( 
 
 'input' => 'checkbox / text / select' <b>(* require)</b>,
  
 'title' => 'title for input'  <b>(* require)</b>,
 
 'label' => 'lable for checkbox'
 
 )
</li>

<li>...</li>

</ol>