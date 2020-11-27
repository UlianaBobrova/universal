<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/

get_header();
?>
<section class="section-dark">
<div class="container">
<?php the_title( '<h1 class="page-title">', '</h1>', true); ?>
<div class="contacts-wrapper">
<div class="left">
<p class="page-text">Через форму обратной связи №1</p>
<form action="#" class="contacts-form" method="POST">
    <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
    <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
    <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
    <button type="submit" class="button more">Отправить</button>
</form>
<!-- можем вставить форму через шорт-код -->
<!-- echo do_shortcode('[contact-form-7 id="185" title="Контактная форма"]') -->
<!-- Или так -->
<p class="page-text">Через форму обратной связи №2</p>
<?php the_content(); ?>
</div>
<div class="right"></div>
</div>
</div>
</section>
<?php
get_footer();