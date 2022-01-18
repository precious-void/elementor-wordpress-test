<?php
$title = $post->post_title;
$tag = 'h4';
if (is_single()) $tag = 'h1';

echo '<' . $tag . ' class="product__title">' . $title . '</' . $tag . '>';
