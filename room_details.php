<?php

    include_once('connection.php');

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Soltee Hotel - Room Details</title>

        <!--  Linking all the links  -->
        <?php require('include/links.php'); ?>

        <!--Swiperjs for swiping and changing images CDN link -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    </head>


    <body class="bg-light">
        <!-- Linking Nav-bar(Header) here -->
        <?php require('include/header.php'); ?>
        <?php
            if (!isset($_GET['id'])) {
                redirect('rooms.php');
            }

            $data = filteration($_GET);

            $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

            if (mysqli_num_rows($room_res) == 0) {
                redirect('rooms.php');
            }

            $room_data = mysqli_fetch_assoc($room_res);


        ?>


        <div class="container">
            <div class="row">

                <div class="col-12 my-5 mb-4 px-4">

                    <h2 class="fw-bold "><?php echo $room_data['name'] ?></h2>
                    <div style="font-size: 14px;">
                        <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                        <span class="text-secondary"> > </span>
                        <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>

                    </div>
                </div>

                <div class="col-lg-7 col-md-12 px-4">
                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            <?php
                                $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
                                $img_q = mysqli_query($conn, "SELECT * FROM `room_images` 
                                WHERE `room_id`='$room_data[id]' ");
           
                                if(mysqli_num_rows($img_q)>0)
                                {
                                    $active_class = 'active';
                                    while($img_res = mysqli_fetch_assoc($img_q))
                                    {

                                        echo "
                                        <div class='carousel-item $active_class'>
                                            <img src='".ROOMS_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded' style='height: 420px;'>
                                        </div>
                                        
                                        ";

                                        $active_class = '';
                                    }
                                }
                                else
                                {
                                    echo"
                                    <div class='carousel-item active'>
                                      <img src='$room_img' class='d-block w-100'>
                                    </div>
                                    ";
                                }
                            ?>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 px-4">
                    <div class="card mb-4 border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <?php

                                echo<<<price
                                   <h4> NRP $room_data[price]  per night</h4>
                                price;

                                echo<<<rating
                                    <div class="rating mb-3">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                    </div>
                                rating;



                                $fea_q = mysqli_query($conn,"SELECT f.name FROM `features` f INNER JOIN `room_features` 
                                rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");  
                        
                                $features_data = "";
                                while($fea_row = mysqli_fetch_assoc($fea_q))
                                {
                                    $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fea_row[name]</span>";
                                }

                                 echo<<<features
                                    <div class="features mb-3">
                                        <h6 class="mb-1">Features</h6>
                                        $features_data
                                    </div>

                                features;



                                $fac_q = mysqli_query($conn, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` 
                                rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
        
                                $facilities_data = "";
                                while($fac_row = mysqli_fetch_assoc($fac_q))
                                {
                                    $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>$fac_row[name]</span>";
                                }

                                echo<<<facilities
                                    <div class="features mb-3">
                                        <h6 class="mb-1">Facilities</h6>
                                        $facilities_data
                                    </div>

                                facilities;

                                echo<<<guests
                                    <div class="guests mb-3">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[adult] Adults
                                        </span>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[children] Children
                                        </span>
                                     </div>
 
                                guests;

                                echo<<<area
                                    <div class="mb-3">
                                        <h6 class="mb-1">Area</h6>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1">$room_data[area] Sq.ft.</span>
                                    </div>                                    
                                area;

                                $book_btn = " ";
                                if(!$settings_r['shutdown']){
                                    $book_btn = " <a href='#' class='btn w-100 text-white custom-bg shadow-none mb-2'>Book Now</a>";
                                }

                                echo<<<book
                                    $book_btn
                                book;
                            
        
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Room's Container -->
                <div class="col-12 mt-4 px-4">
                    <div class="mb-5">
                        <h5>Description</h5>
                        <p>
                            <?php echo $room_data['description'] ?>
                        </p>
                    </div>

                    <div>
                        <h5 class="mb-3">
                            Reviews & Ratings
                        </h5>

                        <div>
                            <div class="swiper-slide bg-white p-4">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="images/testimonials/ujwal.jpg" alt="img" width="60px">
                                    <h6 class="m-0 ms-2">Ujwal Thapa</h6>
                                </div>
                                
                                <p> They were extremely accommodating and allowed us to check in early at like 10am. We got to hotel
                                    super early and I didn’t wanna wait.
                                    So this was a big plus. The sevice was exceptional as well. Would definitely send a friend
                                    there.
                                </p>

                                <div class="rating">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



        <!-- Linking footer here -->
        <?php require('include/footer.php');  ?>


        <!-- Swiperjs Script -->
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper images -->
        <script>
            /* Swiper for top display with effect fade */
            var swiper = new Swiper(".swiper-container", {
                spaceBetween: 30,
                effect: "fade",
                loop: true,
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                // },
                autoplay: {
                    delay: 1500,
                    disableOnInteraction: false,
                }

            });
        </script>


    </body>

</html>