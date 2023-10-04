<?php

function chrisnxyz_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['script', 'style']);
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'chrisnxyz_setup');

function chrisnxyz_enqueue_scripts()
{
    vite_load_asset("chrisnxyz_main", "assets/main.ts");
}
add_action('wp_enqueue_scripts', 'chrisnxyz_enqueue_scripts');
