<?php
/**
 * The template for displaying archive pages.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();
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
    .grid-container {
        margin-bottom:40px;
        display: grid;
        grid-template-columns: 200px 1fr;
        /*grid-template-rows: min-content;*/
        grid-auto-rows:min-content;
        gap: 40px 40px;
        grid-template-areas: "the_img the_content";



        color:black;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }
    @media only screen and (max-width: 800px) {
        .grid-container {
            grid-template-columns: 1fr;
            grid-template-areas: "the_img" "the_content";
            gap:0 0;
            
        }
        .the_img{
            /*min-height:250px;*/
            min-height:250px;
        }
    }

    a.grid-container:hover{
        color:black;
        background:#f8f8f8;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }
    .bg_img{
        background-size:cover;
        background-repeat:no-repeat;
        background-position:center center;
    }

    .the_img { grid-area: the_img; }

    .the_content {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: min-content min-content 60px;
        gap: 20px 1px;
        grid-template-areas: "the_title" "the_excerpt" "the_cta";
        grid-area: the_content;

    }
    .the_content p{
        font-size: 17px;
        line-height: 1.8em;
        color: #7A7A7A;
        font-family: "Roboto", Sans-serif;
        font-weight: 300;
    }

    .the_title { grid-area: the_title; display:flex;align-items:center;}

    .the_excerpt { grid-area: the_excerpt; }

    .the_cta { grid-area: the_cta; }
    .the_header{
        padding-top:20px;
        display:block;
        padding-bottom:20px;
        background-color:#EEF1F4;
        text-align:center;
        margin-bottom:50px;
    }
    .the_title h2{
        margin:0;padding:0;
        color: #444444;
        font-size: 30px;
        font-weight: 400;
        font-family: "Roboto", Sans-serif;
        padding: 0;
        margin: 0;
        line-height: 1;
        margin-bottom:0px;
        margin-top:30px;
    }
</style>

<div class="the_header">
    <h1>Our Work</h1>
</div>

<main style="margin-bottom:40px;" id="main" class="site-main" role="main">

    <div class="page-content">
        <?php
        $args = array(
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'our_work',
            'posts_per_page' => 12,
//            'paged' => $paged
        );
        $the_query = new WP_Query($args);
        while ($the_query->have_posts()) : $the_query->the_post();

            $the_permalink = get_the_permalink();
            $the_title = get_the_title();
            $the_excerpt = get_the_excerpt();
            $global_header = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'large'));



            echo '<a href="' . $the_permalink . '" class="grid-container">
                    <div class="the_img bg_img" style="background-image:url(' . $global_header . ');"></div>
                    <div class="the_content">
                      <div class="the_title">
                        <h2>' . $the_title . '</h2>
                        </div>
                        <div class="the_excerpt">
                            ' . $the_excerpt . '
                        </div>
                        <div class="the_cta">
                            <p><strong>Read More...</strong></p>
                        </div>
                    </div>
                  </a>';

//            printf('<h2><a href="%s">%s</a></h2>', esc_url(get_permalink()), get_the_title());
//            the_post_thumbnail();
//            the_excerpt();
        endwhile;
        ?>



        <?php
//        while (have_posts()) : the_post();
//            printf('<h2><a href="%s">%s</a></h2>', esc_url(get_permalink()), get_the_title());
//            the_post_thumbnail();
//            the_excerpt();
//        endwhile;
        ?>
    </div>
</main>
<?php
get_footer();
