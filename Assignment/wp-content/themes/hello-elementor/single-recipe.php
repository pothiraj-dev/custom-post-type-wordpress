<?php get_header(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()):
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- <header class="entry-header">
                    <h1 class="entry-title">
                        <?php //the_title(); ?>
                    </h1>
                </header> -->
                <div class="entry-content recipe-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-5">
                                <?php echo get_the_post_thumbnail(); ?>
                            </div>
                            <div class="col-7">
                                <div class="recipe-title">
                                    <h1>
                                        <?php echo get_the_title(); ?>
                                    </h1>
                                </div>
                                <div class="recipe-instructions">
                                    <strong>Instructions :</strong>
                                    <?php the_content(); ?>
                                </div>
                                <div class="recipe-ingredients">
                                    <strong>Ingredients :</strong>
                                    <?php display_ingredients(); ?>
                                </div>
                                <div class="recipe-time">
                                    <strong>Time :</strong>
                                    <?php display_recipe_time(); ?>
                                </div>
                                <div class="recipe-servings">
                                    <strong>Servings :</strong>
                                    <?php display_recipe_servings(); ?>
                                </div>
                                <div class="recipe-nutrition">
                                    <strong>Nutrition :</strong>
                                    <?php display_recipe_nutrition(); ?>
                                </div>
                                <div class="recipe-editor-note">
                                    <strong>Editor’s Note :</strong>
                                    <?php display_recipe_editers_note(); ?>
                                </div>
                                <div class="recipe-type ">
                                    <strong>Type :</strong>
                                    <?php display_recipe_type(); ?>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            </article>
        <?php endwhile; ?>
    </main>
</div>

<?php get_footer(); ?>