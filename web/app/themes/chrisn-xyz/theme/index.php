<?php get_header(); ?>
<?php
if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

    <article class="content-box">
        <h1 class="t-arndale"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="t-prose"><?php the_excerpt(); ?></div>
    </article>

        <?php
    endwhile;
endif;
?>
  <div class="t-prose"><?php the_posts_pagination(); ?></div>
<?php get_footer();
