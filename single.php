<?php get_header(); ?>

<div class="content">
    <div class="container">
        <?php
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h2><?php the_title(); ?></h2>
                        <div class="post-meta">
                            <span><?php echo get_the_date(); ?></span>
                        </div>
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile;
            else :
                echo '<p>No content found.</p>';
            endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>
