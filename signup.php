
<?php
include("koneksi.php");
session_start();
    if(isset($_POST['sign'])){
        try
        {
        $username = $_POST['username']; //get "update_id" from index.php page through anchor tag operation and store in "$id" variable
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $select_stmt = $db->prepare('SELECT * FROM akun WHERE username =:id'); //sql select query
        $select_stmt->bindParam(':id',$username);
        $select_stmt->execute(); 

        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($row)) { 
                $errorMsg="Username telah digunakan oleh orang lain.";

            }
            else if ($_POST['username'] =="" || $_POST['password'] == "" || $_POST['email'] == ""){
                $errorMsg="data tidak boleh kosong!";

            }

            else {
                
                $insert_stmt=$db->prepare('INSERT INTO akun VALUES("", :fusername,:fpass,:femail)'); //sql insert query					
                $insert_stmt->bindParam(':fusername',$username);	
                $insert_stmt->bindParam(':fpass',$pass);	  //bind all parameter 
                $insert_stmt->bindParam(':femail',$email);
                if($insert_stmt->execute())
                {
                    
                    $_SESSION['user'] = 2;
                    
                    $_SESSION['username'] = $username;
                    $insertMsg="Akun berhasil dibuat!"; //execute query success message
                    echo	"<script type='text/javascript'>window.location.href = 'index.php' ; </script>";//refresh 3 second and redirect to index.php page
                }
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Assassin's Creed</title>
<!-- 
Journey Template 
http://www.templatemo.com/tm-511-journey
-->
    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">                <!-- Font Awesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" type="text/css" href="css/datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="css/Home.css"/>                             <!-- Templatemo style -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
      </head>

      <body>
      <div class="tm-main-content" id="top">
            <div class="tm-top-bar-bg"></div>    
            <div class="tm-top-bar" id="tm-top-bar">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-expand-lg narbar-light">
                            <a class="navbar-brand mr-auto" href="#">
                                <img src="img/a.png" alt="Site logo">
                                Assassin's Creed
                            </a>
                            <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                                <ul class="navbar-nav ml-auto">
                                  <li class="nav-item">
                                    <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#top">Sign Up</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">About</a>
                                </li>
                            </ul>
                        </div>                            
                    </nav>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- .tm-top-bar -->
        
        <div class="tm-page-wrap mx-auto">
            <section class="tm-banner">
                <div class="tm-container-outer tm-banner-bg">
                    <div class="container">

                        <div class="row tm-banner-row tm-banner-row-header">
                            <div class="col-xs-12">
                                <div class="tm-banner-header">
                                    <h1 class="text-uppercase tm-banner-title">Create Account</h1>
                                    <img src="img/dots-3.png" alt="Dots">
                                    <p class="tm-banner-subtitle">We assist you to get a great gameplay.</p>
                                    <a href="javascript:void(0)" class="tm-down-arrow-link"><i class="fa fa-2x fa-angle-down tm-down-arrow"></i></a>       
                                </div>    
                            </div>  <!-- col-xs-12 -->                      
                        </div> <!-- row -->
                        

                        <div class="row tm-banner-row" id="tm-section-search">
                            <form method="POST" class="tm-search-form tm-section-pad-2">
                            <div class="form-row tm-search-form-row">  <?php
                            if(isset($errorMsg))
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <strong>UPS! <?php echo $errorMsg; ?></strong>
                                </div>
                                <?php
                            }
                            if(isset($insertMsg)){
                            ?>
                                <div class="alert alert-success">
                                    <strong>SUCCESS! <?php echo $insertMsg; ?></strong>
                                </div>
                            <?php
                            }
                            ?> 
                            </div>
                                <div class="form-row tm-search-form-row">                                
                                    <div class="form-group tm-form-group tm-form-group-pad tm-form-group-1">
                                        <label for="inputCity">Username</label>
                                        <input name="username" type="text" class="form-control" placeholder="Type your username...">
                                    </div>
                                    <div class="form-group tm-form-group tm-form-group-pad tm-form-group-1">
                                        <label for="inputCity">Password</label>
                                        <input name="password" type="password" class="form-control" placeholder="Type your password...">
                                    </div>
                                    
                                    <div class="form-group tm-form-group tm-form-group-pad tm-form-group-1">
                                        <label for="inputCity">email</label>
                                        <input name="email" type="text" class="form-control" placeholder="Type your email...">
                                    </div>
                                    <div class="form-group tm-form-group tm-form-group-pad tm-form-group-1">
                                        <button name="sign" type="submit" class="btn btn-primary tm-btn tm-btn-search text-uppercase" value="sign">Sign up</button>
                                    </div>
                                </div>                              
                            </form>                             

                        </div> <!-- row -->
                        <div class="tm-banner-overlay" ></div>
                    </div>  <!-- .container -->                   
                </div>     <!-- .tm-container-outer -->                 
            </section>

            <section class="p-5 tm-container-outer tm-bg-gray" id="about">            
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 mx-auto tm-about-text-wrap text-center" >                        
                            <h2 class="text-uppercase mb-4"> <strong>About</strong> this game</h2>
                            <p class="mb-4">Assassin Creed adalah seri permainan video aksi-petualangan dan penyelinapan yang dibuat oleh Patrice Désilets, Jade Raymond, dan Corey May; dikembangkan dan diterbitkan oleh Ubisoft menggunakan game engine Anvil. Seri permainan ini menggambarkan pertarungan di antara Assassin, yang memperjuangkan perdamaian dengan kehendak bebas, dan Templar, yang menginginkan perdamaian melalui di bawah kekuasaan. Seri permainan ini menampilkan fiksi sejarah, fiksi sains, dan tokoh-tokoh fiktif, yang dipadukan dengan peristiwa dan tokoh-tokoh sejarah. Pemain akan mengontrol tokoh Assassin di masa lampau lebih sering, sementara mereka dapat pula bermain sebagai Desmond Miles atau Assassin Initiate di masa kini, yang memburu target-target Templar.

                                            <br><br>Cerita dari seri permainan video ini terinspirasi dari novel Almaut oleh penulis Slovenia Vladimir Bartol,[1] sementara konsep permainan dibentuk dari seri Prince of Persia.[2] Seri permainan ini dimulai dengan permainan berjudul sama pada tahun 2007, dan telah menghadirkan sebelas permainan utama. Permainan yang dirilis baru-baru ini adalah Assassin's Creed Odyssey pada tahun 2018.

                                            <br><br>Cerita dan periode waktu yang baru diperkenalkan di setiap entri, dan elemen dari cara bermain berkembang dari versi sebelumnya. Terdapat dua kumpulan cerita di dalam seri ini. Untuk lima permainan utama yang pertama, cerita berlatar pada tahun 2012 dan menampilkan tokoh utama Desmond Miles yang menggunakan mesin yang bernama Animus dan menghidupkan kembali memori pendahulunya untuk mencari cara untuk mencegah kemusnahan massal pada tahun 2012. Dalam permainan berikutnya hingga Assassin's Creed Syndicate, pegawan Abstergo dan relawan Assassin menghidupkan kembali rekaman memori genetik menggunakan perangkat lunak Helix, yang membantu para Templar dan Assassin menemukan Piece of Eden yang baru di dunia modern. Pada dua judul permainan terbaru, yakni Assassin's Creed Origins dan Assassin's Creed Odyssey, protagonis untuk masa kini adalah Layla Hassan, seorang mantan pegawai Abstergo yang direkrut ke dalam Ordo Assassin.

                                            <br><br>Permainan utama dari Assassin's Creed berlatar di dunia terbuka dan ditampilkan dari sudut pandang orang ketiga di mana para protagonis menjatuhkan lawan menggunakan keterampilan bertempur dan menyelinap dengan eksploitasi lingkungan. Pemain memiliki kebebasan untuk menjelajahi latar historis sambil menyelesaikan misi utama dan sampingan. Di samping misi pemain tunggal, beberapa permainan juga menyediakan permainan multi-pemain kompetitif dan kooperatif. Sementara permainan utama dibuat untuk platform konsol dan desktop utama, beberapa permainan sampingan juga dirilis bersamaan untuk platform konsol, mobile, dan perangkat genggam.

                                            <br><br>Permainan utama pada seri permainan video Assassin's Creed telah menerima banyak tanggapan positif atas ambisinya dalam mengembangkan visual, desain permainan, dan cerita naratif, dengan kritikan tentang siklus rilis tahunan dan bug yang sering muncul. Permainan spin-off menerima tanggapan sedang hingga positif. Seri permainan video ini telah menerima berbagai penghargaan dan nominasi, termasuk penghargaan Game of the Year. Seri permainan video ini juga sukses secara komersial karena menjual lebih dari 100 juta kopi per bulan September 2016, menjadi seri terlaris yang pernah dibuat oleh Ubisoft dan menjadi salah satu seri permainan video dengan penjualan tertinggi sepanjang masa. Assassin's Creed diadaptasi ke dalam film yang berjudul sama, yang menerima tanggapan negatif. Seri permainan ini juga diterbitkan dalam bentuk buku seni, ensiklopedia, komik, novelisasi, dan novel. Semua media berlatar dalam kontinuitas yang sama dengan seri permainan video utama.
                        </p><a href="#" class="text-uppercase btn-primary tm-btn">Continue explore</a>                              
                        </div>
                    </div>
                </div>            
            </section>
            
    </div> <!-- .main-content -->

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
    <script src="js/popper.min.js"></script>                    <!-- https://popper.js.org/ -->       
    <script src="js/bootstrap.min.js"></script>                 <!-- https://getbootstrap.com/ -->
    <script src="js/datepicker.min.js"></script>                <!-- https://github.com/qodesmith/datepicker -->
    <script src="js/jquery.singlePageNav.min.js"></script>      <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
    <script src="slick/slick.min.js"></script>                  <!-- http://kenwheeler.github.io/slick/ -->
    <script src="js/jquery.scrollTo.min.js"></script>           <!-- https://github.com/flesler/jquery.scrollTo -->
    <script> 
        /* Google Maps
        ------------------------------------------------*/
        var map = '';
        var center;

        function initialize() {
            var mapOptions = {
                zoom: 16,
                center: new google.maps.LatLng(37.769725, -122.462154),
                scrollwheel: false
            };

            map = new google.maps.Map(document.getElementById('google-map'),  mapOptions);

            google.maps.event.addDomListener(map, 'idle', function() {
              calculateCenter();
          });

            google.maps.event.addDomListener(window, 'resize', function() {
              map.setCenter(center);
          });
        }

        function calculateCenter() {
            center = map.getCenter();
        }

        function loadGoogleMap(){
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVWt4rJfibfsEDvcuaChUaZRS5NXey1Cs&v=3.exp&sensor=false&' + 'callback=initialize';
            document.body.appendChild(script);
        } 

        /* DOM is ready
        ------------------------------------------------*/
        $(function(){

            // Change top navbar on scroll
            $(window).on("scroll", function() {
                if($(window).scrollTop() > 100) {
                    $(".tm-top-bar").addClass("active");
                } else {                    
                 $(".tm-top-bar").removeClass("active");
                }
            });

            // Smooth scroll to search form
            $('.tm-down-arrow-link').click(function(){
                $.scrollTo('#tm-section-search', 300, {easing:'linear'});
            });

            // Date Picker in Search form
            var pickerCheckIn = datepicker('#inputCheckIn');
            var pickerCheckOut = datepicker('#inputCheckOut');

            // Update nav links on scroll
            $('#tm-top-bar').singlePageNav({
                currentClass:'active',
                offset: 60
            });

            // Close navbar after clicked
            $('.nav-link').click(function(){
                $('#mainNav').removeClass('show');
            });

            // Slick Carousel
            $('.tm-slideshow').slick({
                infinite: true,
                arrows: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });

            loadGoogleMap();                                       // Google Map                
            $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright           
        });

    </script>             

</body>
</html>
