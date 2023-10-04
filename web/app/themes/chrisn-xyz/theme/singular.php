<?php get_header(); ?>
<?php
if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

        <article class="cn-article">
            <div class="cn-article__front-matter">
                <h1 class="t-beetham"><?php the_title(); ?></h1>
                <?php if (is_singular('post')) : ?>
                    <p class="t-wall"><?php the_date(); ?></p>
                <?php endif; ?>
            </div>
            <div class="t-prose cn-article__body">
                <?php the_content(); ?>
            </div>
        </article>

        <?php
    endwhile;
endif;
?>
<?php get_template_part("page-footer") ?>
<?php get_footer();
