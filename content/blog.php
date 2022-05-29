<!-- TODO: make change route by customizer -->
<?php $image= "https://ivanyz.com/wp-content/uploads/2022/05/background.png"; ?> 

<!-- floating image -->
<img class="floating" src="<?= $image ?>">

<!--  -->
<div class="col bg-main" id="recents">

  <h1 class="row name-brand">Recientes</h1>

  <div class="row service">
    <?php 
    $lastposts = get_posts( array(
      'posts_per_page' => 4
    ));
    foreach ( $lastposts as $post ) : setup_postdata( $post );?>

      <div class="col bg-recent-post">
        <div class="card text-white card-has-bg" style="background-image:url('https://source.unsplash.com/600x900/?tech');">
          <div class="card-img-overlay d-flex flex-column">
            <div class="card-body">
              <small class="card-meta mb-2"><?= the_tags(); ?></small>
              <h4 class="card-title mt-0 "><?php the_title(); ?></h4>
              <small><?php the_excerpt();?></small>
            </div>
            <div class="card-footer">
              <a href="<?php the_permalink(); ?>" class="services-a">Show more <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>

    <?php
    endforeach; 
    ?>
  </div>
</div>

<div>
  <div class="col-lg-4 px-5 blog-post" >
      
      <?php
      $lastposts = get_posts( array(
          'posts_per_page' => 5
      ) );
      //the_content()
      if ( $lastposts ) {
          foreach ( $lastposts as $post ) :
              setup_postdata( $post ); ?>

              <div class="card mb-3">
              <div class="row g-0">
                <div class="col-sm-3 col-lg-3 align-self-center">                  
                  <?php echo '<img src="'.get_the_post_thumbnail_url(get_the_ID(), $size = 'post-thumbnail').'" class="img-fluid rounded-start" alt="...">'; ?>
                </div>
                <div class="col">
                  <div class="card-body">
                    <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p class="card-text"><?php the_excerpt();?></p>
                    <p class="card-text"><small class="text-muted"><?php the_date( 'Y-m' ); ?></small></p>
                  </div>
                </div>
                <div class="col-1 align-self-center">
                  <a href="<?php the_permalink(); ?>"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
              </div>
            </div>

            <hr>
              
          <?php
          endforeach; 
          wp_reset_postdata();
      }
      ?>
    </div>
</div>