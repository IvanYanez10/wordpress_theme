  <div class="principal" id="home">
    <h1 class="">Agencia digital</h1>
    <h4>¡Acelera tu negocio!</h4>
    <button>Ver más</button>
  </div>
</div>

<div class="process">
  <h3>Proceso</h3>

</div>


<!-- services -->
<div class="" id="">
  <div class="row mx-2 service">
    <?php 
    include 'services.php';
    $services_array=array_slice($services_array, 0, 6);
    foreach ( $services_array as $service ) :?>

      <div class="col-4">
        <div class="card">            
          <img src="https://source.unsplash.com/200x200/?tech" alt="Sample photo">
          <div class="text">
            <?= $service['tag'] ?>
            <h3><?= $service['service'] ?></h3>
            <p><?= substr($service['description'], 0, 50) ?></p>
            <a href="<?php $service['serviceUrl'] ?>" class="btn btn-primary btn-block">Here's why</a>
          </div>
        
        </div>
      </div>

    <?php
    endforeach; 
    ?>
  </div>
</div>

<!-- banner -->
<div class="container banner">
<h3>¿No sabes por donde comenzar?</h3>
<button>Ver más</button>
</div>

<!-- portfolio -->
<div class="container" id="portfolio">    

    <h1>Nustro portafolio</h1>

    <div class="row justify-content-around" style="margin-top:50px;">

        <?php 
        $colors=array('blue', 'red', 'green', 'yellow');
        include 'portfolio.php';
        $portfolio_array=array_slice($portfolio_array, 1, 3);
        foreach ( $portfolio_array as $portfolio_item ) : $col_ind = rand(0, count($colors)-1);?>
        
        <article class="col-sm-5 col-md-5 col-lg-3  postcard dark postcard-item <?= $colors[$col_ind] ?>" >
          <a class="postcard__img_link" href="#">
            <img class="postcard__img" src="https://picsum.photos/1000/1000" alt="Image Title" />
          </a>
          <div class="postcard__text">
            <h1 class="postcard__title blue"><a href="#"><?= $portfolio_item['portfolio'] ?></a></h1>
            <div class="postcard__subtitle small">
              <p><i class="fa-solid fa-circle-notch"></i> bussines </p>
            </div>
            <div class="postcard__bar"></div>
            <div class="postcard__preview-txt"><?= substr($portfolio_item['description'], 0, 80) ?></div>
            <ul class="postcard__tagbox">
              <li class="tag__item"><i class="fas fa-tag mr-2"></i> <?= $portfolio_item['tag'] ?></li>
              <li class="tag__item"><i class="fas fa-clock mr-2"></i> 15min</li>
              <li class="tag__item play blue">
                <a href="#"><i class="fas fa-play mr-2"></i> Go</a>
              </li>
            </ul>
          </div>
        </article>          

        <?php
        endforeach; 
        ?>

    </div>

</div>

<!-- portfolio -->
<div class="clients">
        <ul>
          <li>baservi</li>
          <li>Mexicana de carton</li>
          <li>Autotransportes asunsoto</li>
        </ul>
</div>

<!-- portfolio -->
<div class="row blog" >
      
      <?php
      $lastposts = get_posts( array('posts_per_page' => 3) );
      if ( $lastposts ) {
        foreach ( $lastposts as $post ) :
          setup_postdata( $post ); ?>

          <div class="col card mb-3">
            <div class="">
              <div class="align-self-center">                  
                <?php echo '<img src="'.get_the_post_thumbnail_url(get_the_ID(), $size = 'post-thumbnail').'" class="img-fluid rounded-start" alt="...">'; ?>
              </div>
              <div class="">
                <div class="card-body">
                  <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                  <p class="card-text"><?php the_excerpt();?></p>
                </div>
              </div>
              <div class=" align-self-center">
                <a href="<?php the_permalink(); ?>"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>

        <?php
        endforeach; 
        wp_reset_postdata();
      }
      ?>
    </div>