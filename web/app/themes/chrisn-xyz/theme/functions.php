<?php

function chrisnxyz_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['script', 'style']);
    add_theme_support('title-tag');
    add_theme_support('custom-header', ["width" => 248, "height" => 248]);
}
add_action('after_setup_theme', 'chrisnxyz_setup');

function chrisnxyz_enqueue_scripts()
{
    vite_load_asset("chrisnxyz_main", "assets/main.ts");
}
add_action('wp_enqueue_scripts', 'chrisnxyz_enqueue_scripts');

function register_my_menus()
{
    register_nav_menus(["front-page" => "Front page"]);
}
add_action("init", "register_my_menus");
