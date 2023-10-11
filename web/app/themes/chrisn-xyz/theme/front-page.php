<?php get_header(); ?>
  <main>
    <header class="cn-content-box cn-home-info">
      <h1 class="t-arndale">
          <span><?php echo get_bloginfo("name"); ?></span>
          <img src="<?php header_image(); ?>" width="124" height="124" class="cn-home-info__profile" alt="A photograph of Chris Northwood">
      </h1>
      <p class="t-body"><?php echo get_bloginfo("description", "display") ?></p>
    </header>
    <nav class="cn-home-links t-prose"><?php wp_nav_menu(["theme_location" => "front-page"]); ?></nav>
  </main>
<?php get_footer();
