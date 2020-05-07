<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 */
get_header();
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php
while (have_posts()) : the_post();
    $get_post_thumbnail = get_post(get_post_thumbnail_id())->post_title;
    $global_header = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'large'));

    $file_download = get_field('mi_file_download');
    ?>
    <style>
        h1{
            color: #444444;
            font-size: 40px;
            font-weight: 400;
            font-family: "Roboto", Sans-serif;
            padding: 0;
            margin: 0;
            line-height: 1;
            margin-bottom:0px;
        }
        .bg_img{
            background-size:cover;
            background-repeat:no-repeat;
            background-position:center center;
        }
        a.cta{
            fill: #ffffff;
            color: #ffffff;
            background-color: #1e202d;
            border-style: solid;
            border-width: 2px 2px 2px 2px;
            border-color: #000000;
            border-radius: 0px 0px 0px 0px;
            padding: 15px 50px 15px 050px;
            margin-top:20px;margin-bottom:20px;
            display:inline-block;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
        a.cta:hover{
            color: #1e202d;
            background-color: #ffffff;
            border-color: #1e202d;
            border-style: solid;
            border-width: 2px 2px 2px 2px;
            border-radius: 0px 0px 0px 0px;
            padding: 15px 50px 15px 050px;
            margin-top:20px;margin-bottom:20px;
            display:inline-block;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 0.7fr 1.3fr;
            grid-template-rows: 1.2fr 0.8fr;
            gap: 30px 30px;
            grid-template-areas: "the_img the_content" ". the_content";
        }
        .the_content p{
            font-size: 17px;
            line-height: 1.8em;
            color: #7A7A7A;
            font-family: "Roboto", Sans-serif;
            font-weight: 300;
        }

        .the_img {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 300px 300px;
            gap: 30px 30px;
            grid-template-areas: "the_image" "the_side_content";
            grid-area: the_img;
        }

        .the_image { grid-area: the_image; }

        .the_side_content { grid-area: the_side_content; }

        .the_content { grid-area: the_content; }
        
        .the_header{
            padding-top:20px;
            display:block;
            padding-bottom:20px;
            background-color:#EEF1F4;
            text-align:center;
            margin-bottom:50px;
        }
    </style>
    <div class="the_header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?> 
    </div>
    <main style="margin-bottom:30px;" id="main" <?php post_class('site-main'); ?> role="main">
        <div class="page-content">
            <div class="grid-container">
                <div class="the_img">
                    <div class="the_image bg_img"  style="background-image:url(<?php echo $global_header; ?>);" alt="<?php echo $get_post_thumbnail; ?>"></div>
                    <div class="the_side_content">
                        <p><strong>Date Posted: </strong><?php echo the_date(); ?></p>
                        <?php
                        if ($file_download):
                            echo '<a class="cta" href="' . $file_download['url'] . '" target="_blank">Download Now</a>';

                        endif;
                        ?>
                    </div>
                </div>
                <div class="the_content">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>
    </main>
    <?php
endwhile;
?>
<?php
get_footer();
