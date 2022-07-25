<?php

include_once('connection.php');


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Soltee Hotel</title>

    <!--  Linking all the links  -->
    <?php require('include/links.php'); ?>

</head>


<body class="bg-light">
    <!-- Linking Nav-bar(Header) here -->
    <?php require('include/header.php'); ?>

    <div class="my-5 px-4">

        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            We want to ensure you have all the details about our property and its amenities prior to your arrival <br> so you can have a wonderful stay from the very start.
        </p>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" height="350px" src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-primary mb-2">
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
                    </a>

                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel:+977-<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-primary">
                        <i class="bi bi-telephone-fill"></i>+977-<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>
                    <?php
                        if ($contact_r['pn2'] != '') {
                            echo <<<data
                                <a href="tel:+977-$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-primary">
                                    <i class="bi bi-telephone-fill"></i>+977-$contact_r[pn2]
                                </a>
                            data;
                        }
                    ?>

                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: <?php echo $contact_r['email'] ?>" class="d-inline-block text-decoration-none text-primary">
                        <i class="bi bi-envelope-plus-fill"></i> <?php echo $contact_r['email'] ?>
                    </a>

                    <h5 class="mt-4">Follow us</h5>
                    <?php
                    if ($contact_r['tw'] != '') {
                        echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block fs-4 me-2">                        
                        data;
                    }
                    ?>
                        <i class="bi bi-twitter me-1"></i>
                    </a>

                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block fs-4 me-2">
                        <i class="bi bi-instagram me-1"></i>
                    </a>

                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block fs-4">
                        <i class="bi bi-facebook me-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-md-6  px-4">
                <div class="bg-white rounded shadow p-4">
                    <form method="POST">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" type="reset" style="font-weight: 500;">Name</label>
                            <input name="name" required type="text" class="form-control shadow-none">
                        </div>

                        <div class="mt-3">
                            <label class="form-label" type="reset" style="font-weight: 500;">Email</label>
                            <input name="email" required type="email" class="form-control shadow-none">
                        </div>

                        <div class="mt-3">
                            <label class="form-label" type="reset" style="font-weight: 500;">Subject</label>
                            <input name="subject" required type="text" class="form-control shadow-none">
                        </div>

                        <div class="mt-3">
                            <label class="form-label" type="reset" style="font-weight: 500;">Message</label>
                            <textarea name="message" required class="form-control shadow-none " rows="5" style="resize:none;"></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-primary mt-3">SEND</button>
                    </form>
                </div>
            </div>

        </div>

    </div>


    <?php   
    
                    
        
        if(isset($_POST['send']))
        {
            $frm_data = filteration($_POST);

            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)";
            $values =  [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

            $res = insert($q, $values, 'ssss');

            if($res ==1 )
            {
                alert('success','Mail Sent !');
            }
            else
            {
                alert('error', 'Server down ! Mail cannot be sent !');
            }
        }

    ?>


    <!-- Linking footer here -->
    <?php require('include/footer.php');  ?>

</body>


</html>