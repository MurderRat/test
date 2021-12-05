<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WL_Test_Theme
 */

get_header();
$id = get_the_ID();
$models = get_the_terms( $id, 'models' );
$countries = get_the_terms( $id, 'countries' );
$color = get_post_meta($id, 'carcolor', true);
$fuel = get_post_meta($id, 'car_fuel', true);
$power = get_post_meta($id, 'power', true);
$price = get_post_meta($id, 'price', true);
?>

	<main id="primary" class="site-main">

		<h1>
            <?php the_title(); ?>
        </h1>

        <div class="description">
            <?php the_content(); ?>
        </div>

        <?php 
            if (get_the_post_thumbnail($id)) {
                echo(get_the_post_thumbnail($id));
            } else {

            }
            if ($models) {
                echo('<h3>Model</h3>');
                foreach($models as $model) {
                    echo('<span>'.$model->name.'</span>');
                    break;
                }
            }

            
            if ($countries) {
                echo('<h3>Country</h3>');
                foreach($countries as $country) {
                    echo('<span>'.$country->name.'</span>');
                    break;
                }
            }

            if ($color) { ?>
                <h3>Color</h3>
                <div style="width: 20px; height: 20px; background-color: <?php echo($color); ?>"></div>
            <?php }

            if ($fuel && $fuel != 'none') { 
                echo('<h3>Fuel</h3><span>'.$fuel.'</span>');
            }

            if ($power) { 
                echo('<h3>Power</h3><span>'.$power.'</span>');
            }

            if ($price) { 
                echo('<h3>Price</h3><span>'.$price.'</span>');
            }

        ?>
       

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
