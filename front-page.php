<?php get_header(); ?>

<div class="content">
    <div class="container">
        <section class="blog-archive">
            <h2>Latest Posts</h2>
            <?php
                // Custom loop to get the latest posts
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 5, // Adjust as needed
                );
                $latest_posts = new WP_Query($args);
                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <h3>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="post-meta">
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No posts found.</p>';
                endif;
            ?>
        </section>
    </div>
</div>

<?php get_footer(); ?>
