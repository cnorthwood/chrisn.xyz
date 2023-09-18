<?php

/* Remove archives */
function chrisnxyz_remove_listing_pages()
{
    if (!is_feed() && (
            is_category() ||
            is_tag() ||
            is_date() ||
            is_author() ||
            is_tax()
        )
    ) {
        global $wp_query;
        $wp_query->set_404();
    }
}
add_action('template_redirect', 'chrisnxyz_remove_listing_pages');
