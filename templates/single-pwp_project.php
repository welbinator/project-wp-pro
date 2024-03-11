<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php
    while ( have_posts() ) : the_post();

        // Display the title of the project
        the_title('<h1 class="entry-title">', '</h1>');

        // Display a section for associated tasks
        echo '<h2>Tasks</h2>';
        
        // Query for tasks associated with this project
        $associated_tasks = new WP_Query(array(
            'post_type' => 'pwp_task',
            'meta_query' => array(
                array(
                    'key' => '_pwp_project_id', // The meta key used in your project-task association
                    'value' => get_the_ID(),
                    'compare' => '=',
                ),
            ),
        ));

        if ($associated_tasks->have_posts()) {
            echo '<ul>';
            while ($associated_tasks->have_posts()) : $associated_tasks->the_post();
                echo '<li>' . get_the_title() . '</li>';
            endwhile;
            echo '</ul>';
        } else {
            echo '<p>No tasks found for this project.</p>';
        }

        // Reset Post Data
        wp_reset_postdata();

    endwhile; // End of the loop.
    ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
