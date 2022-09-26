<?php

    //front-end purpose
    define('SITE_URL','http://127.0.0.1/hotel/');
    define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
    define('CAROUSEL_IMG_PATH',SITE_URL.'images/room_details/');
    define('BANNER_IMG_PATH',SITE_URL.'images/banner/');
    define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
    define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
    define('USERS_IMG_PATH',SITE_URL.'images/users/');




    //back-end Upload process 
    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/hotel/images/');
    define('ABOUT_FOLDER','about/');
    define('CAROUSEL_FOLDER','room_details/');
    define('BANNER_FOLDER','banner/');
    define('FACILITIES_FOLDER','facilities/');
    define('ROOMS_FOLDER','rooms/');
    define('USERS_FOLDER','users/');


    //SendGrid API Key
    define('SENDGRID_API_KEY',"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");
    define('SENDGRID_EMAIL',"bishal.thapa9948@gmail.com");
    define('SENDGRID_NAME',"Bishal Thapa");




    function adminLogin()
    {
        session_start();
        if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)) {
            echo"
            <script>
                window.location.href='index.php';
            </script>";
            exit;
        }
        //session_regenerate_id(true); //this generates new ID for sessions everytime the page is refreshed to give an extra layer of protection from sessioon hijacking
    }

    function redirect($url)
    {
        echo"
        <script>
            window.location.href='$url';
        </script>";
        exit;
    }


    function alert($type, $msg){
        $bs_class =  ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert custom-trans" role="alert">
            <strong class="me-3">$msg</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
    }
    

    function uploadImage($image, $folder)
    {

        $valid_mime = ['image/jpeg','image/png','image/webp','image/jfif','image/JPG'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime))
        {
            return 'inv_img'; //invalid image format
        }
        else if (($image['size']/(1024*1024))>8)
        {

            return 'inv_size';  //setting size to 8 mb
        }

        else
        {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111 , 99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path))
            {
                return $rname;
            }
            else
            {
                return 'upd_failed';
            }
        }

    }

    
    function deleteImage($image, $folder)
    {
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function uploadSVGImage($image, $folder)
    {

        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime))
        {
            return 'inv_img'; //invalid image format
        }
        else if (($image['size']/(1024*1024))>1)
        {

            return 'inv_size';  //setting size to 8 mb
        }

        else
        {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111 , 99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path))
            {
                return $rname;
            }
            else
            {
                return 'upd_failed';
            }
        }

    }


    function uploadUserImage($image)
    {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime))
        {
            return 'inv_img'; //invalid image format
        }

        else
        {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111 , 99999).".jpeg";

            $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

            if($ext =='png' || $ext == 'PNG')
            {
                $img = imagecreatefrompng($image['tmp_name']);
            }
 
            else if ($ext =='webp' || $ext == 'WEBP') {
                $img = imagecreatefromwebp($image['tmp_name']);
            } 

            else
            {
                $img = imagecreatefromjpeg($image['tmp_name']);
            }


            if(imagejpeg($img, $img_path, 75))
            {
                return $rname;
            }
            else
            {
                return 'upd_failed';
            }
        }

    }

?>