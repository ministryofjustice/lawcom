<?php get_template_part('templates/page', 'header'); ?>

<?php
  $wp_query = document_query();
?>
<?php if ( $wp_query->have_posts() ) : ?>
  <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
    <?php $project = get_field('project');  ?>
    <?php
      if (!empty($project->post_name)) {
        // Get the current URL
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Get the WordPress installation directory
        $wp_installation_dir = ABSPATH;

        // Calculate the subdirectory path
        $subdirectory_path = str_replace($wp_installation_dir, '', dirname($current_url));

        // Remove any trailing slashes
        $subdirectory_path = rtrim($subdirectory_path, '/');

        $url = $subdirectory_path ."/project/" . $project->post_name . "/#" . $post->post_name;
      } else {
        $url = get_permalink();
      }
    ?>
    <h3><a class="doc-list" href="<?= $url; ?>">Publication: <?= $post->title; ?></a></h3>
    <?php $date = DateTime::createFromFormat('Y-m-d', get_field('publication_date')); ?>
    <?php if (!empty($date)): ?>
      <p><strong>Publication date:</strong> <?php echo $date->format('j F Y') ?></p>
      <?php if (get_field('response_date')): ?>
        <p><strong>Response date:</strong> <?php the_field('response_date'); ?></p>
      <?php endif; ?>
    <?php endif; ?>
    <hr>
  <?php endwhile; ?>
<?php else: ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no documents were found.', 'roots'); ?>
  </div>
  <p>Please adjust your search and try again.</p>
<?php endif; ?>

<div class="pagination">
<?php echo paginate_links(); ?>
</div>

<?php
if(!empty($temp)) {
  $wp_query = null; $wp_query = $temp;
}
wp_reset_query();
?>
