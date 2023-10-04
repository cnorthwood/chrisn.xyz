<?php get_header(); ?>
<div class="cn-content-box-list">
<?php
if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

    <article class="cn-content-box">
        <h1 class="t-arndale"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="t-prose"><?php the_excerpt(); ?></div>
    </article>

        <?php
    endwhile;
endif;
?>
</div>
  <div class="t-prose"><?php the_posts_pagination(); ?></div>
  <footer class="cn-footer">
    <p class="t-body"><a href="<?php echo home_url(); ?>">Go to homepage</a></p>
  </footer>
<?php get_footer();
