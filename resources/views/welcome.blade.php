<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Sidang Tugas Akhir</title>
      <meta name="keywords" content="Sidang PKL, Seminar Proposal, Tugas Akhir">
      <meta name="description" content="Platform untuk bimbingan dan persiapan Sidang PKL, Seminar Proposal, dan Tugas Akhir">
      <meta name="author" content="Nama Anda">
      <!-- owl carousel style -->
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.2.4/assets/owl.carousel.min.css" />
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{asset('/landing_page/css/bootstrap.min.css')}}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{asset('/landing_page/css/style.css')}}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{asset('/landing_page/css/responsive.css')}}">
      <!-- fevicon -->
      <link rel="icon" href="{{asset('/landing_page/images/fevicon.png')}}" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{asset('/landing_page/css/jquery.mCustomScrollbar.min.css')}}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets -->
      <link rel="stylesheet" href="{{asset('/landing_page/css/owl.carousel.min.css')}}">
      <link rel="stylesheet" href="{{asset('/landing_page/css/owl.theme.default.min.css')}}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>

   <body>
      <!--header section start -->
      <div class="header_section">
        <div class="container">
           <nav class="navbar navbar-dark bg-dark">
              <a class="" href="index.html"><img src="{{asset('/landing_page/images/logoti.png')}}" style="height: 100px"></a>
              <!-- Tombol Login di Navbar Kanan -->
              <div class="ml-auto" style="">
                 <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
              </div>
           </nav>
        </div>
         <!--banner section start -->
         <div class="banner_section layout_padding">
            <div id="my_slider" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="taital_main">
                                 <h4 class="banner_taital">Sidang Tugas Akhir</h4>
                                 <p class="banner_text">Platform terbaik untuk mempersiapkan Sidang PKL, Seminar Proposal, dan Tugas Akhir. Dapatkan bimbingan ahli dan sumber daya yang Anda butuhkan untuk sukses.</p>
                                 <div class="read_bt"><a href="#">Mulai Sekarang</a></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div><img src="{{asset('/landing_page/images/img-1.png')}}" class="image_1"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
         <!--banner section end -->
      </div>
      <!--header section end -->
      <!--about section start -->
      <div class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="image_2"><img src="{{asset('/landing_page/images/img-2.png')}}"></div>
               </div>
               <div class="col-md-6">
                  <h1 class="about_taital">Tentang <span class="us_text">Kami</span></h1>
                  <p class="about_text">Kami adalah platform yang menyediakan bimbingan dan sumber daya untuk membantu mahasiswa dalam mempersiapkan Sidang PKL, Seminar Proposal, dan Tugas Akhir. Dengan tim ahli dan materi terstruktur, kami siap membantu Anda meraih kesuksesan akademik.</p>
                  <div class="read_bt_1"><a href="#">Pelajari Lebih Lanjut</a></div>
               </div>
            </div>
         </div>
      </div>
      <!--about section end -->
      <!--services section start -->
      <div class="services_section layout_padding">
         <div class="container">
            <h1 class="service_taital"><span class="our_text">Layanan</span> Kami</h1>
            <p class="service_text">Kami menyediakan berbagai layanan untuk mendukung perjalanan akademik Anda.</p>
            <div class="services_section_2">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="icon_1"><img src="{{asset('/landing_page/images/pkl.png')}}"></div>
                     <h4 class="design_text">Sidang PKL</h4>
                     <p class="lorem_text">Bimbingan lengkap untuk mempersiapkan Sidang PKL, mulai dari penyusunan laporan hingga presentasi.</p>
                  </div>
                  <div class="col-sm-4">
                     <div class="icon_1"><img src="{{asset('/landing_page/images/sempro.png')}}"></div>
                     <h4 class="design_text">Seminar Proposal</h4>
                     <p class="lorem_text">Persiapan terstruktur untuk Seminar Proposal, termasuk penyusunan proposal dan teknik presentasi.</p>
                     <div class="read_bt_2"><a href="#">Selengkapnya</a></div>
                  </div>
                  <div class="col-sm-4">
                     <div class="icon_1"><img src="{{asset('/landing_page/images/wisuda.png')}}" style="height: 220px"></div>
                     <h4 class="design_text">Tugas Akhir</h4>
                     <p class="lorem_text">Bimbingan intensif untuk penyusunan dan Sidang Tugas Akhir, termasuk revisi dan konsultasi.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--services section end -->
      <!--blog section start -->
      <div class="blog_section layout_padding">
         <div class="container">
            <h1 class="blog_taital"><span class="our_text">Artikel</span> Terbaru</h1>
            <p class="blog_text">Temukan artikel dan tips terbaru untuk membantu Anda dalam persiapan Sidang PKL, Seminar Proposal, dan Tugas Akhir.</p>
            <div class="services_section_2 layout_padding">
               <div class="row">
                  <div class="col-md-4">
                     <div class="box_main">
                        <div class="student_bg"><img src="{{asset('/landing_page/images/img-3.png')}}" class="student_bg"></div>
                        <div class="image_15">19<br>Feb</div>
                        <h4 class="hannery_text">Tips Sukses Sidang PKL</h4>
                        <p class="fact_text">Pelajari langkah-langkah untuk mempersiapkan Sidang PKL dengan baik dan meraih hasil maksimal.</p>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="box_main">
                        <div class="student_bg"><img src="{{asset('/landing_page/images/img-4.png')}}" class="student_bg"></div>
                        <div class="image_15">20<br>Feb</div>
                        <h4 class="hannery_text">Cara Menyusun Proposal yang Baik</h4>
                        <p class="fact_text">Temukan strategi untuk menyusun proposal yang jelas, terstruktur, dan mudah dipahami.</p>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="box_main">
                        <div><img src="{{asset('/landing_page/images/img-5.png')}}" class="student_bg"></div>
                        <div class="image_15">21<br>Feb</div>
                        <h4 class="hannery_text">Persiapan Sidang Tugas Akhir</h4>
                        <p class="fact_text">Persiapkan diri Anda untuk Sidang Tugas Akhir dengan tips dan trik dari para ahli.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--blog section end -->
      <!--footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="address_main">
               <div class="address_text"><a href="#"><img src="{{asset('/landing_page/images/map-icon.png')}}"><span class="padding_left_15">Kampus Politeknik Negeri Padang</span></a></div>
               <div class="address_text"><a href="#"><img src="{{asset('/landing_page/images/call-icon.png')}}"><span class="padding_left_15">+62 123 4567 890</span></a></div>
               <div class="address_text"><a href="#"><img src="{{asset('/landing_page/images/mail-icon.png')}}"><span class="padding_left_15">info@sidangta.com</span></a></div>
            </div>
            <div class="footer_section_2">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <h4 class="link_text">Tautan Berguna</h4>
                     <div class="footer_menu">
                        <ul>
                           <li><a href="https://www.pnp.ac.id/">Politeknik Negeri Padang</a></li>
                           <li><a href="https://www.kemdikbud.go.id/">Kemdikbud</a></li>
                           <li><a href="https://pddikti.kemdiktisaintek.go.id/">pddikti</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h4 class="link_text">Layanan Kami</h4>
                     <p class="footer_text">Kami menyediakan bimbingan untuk Sidang PKL, Seminar Proposal, dan Tugas Akhir.</p>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h4 class="link_text">Media Sosial</h4>
                     <div class="social_icon">
                        <ul>
                           <li><a href="#"><img src="{{asset('/landing_page/images/fb-icon.png')}}"></a></li>
                           <li><a href="#"><img src="{{asset('/landing_page/images/twitter-icon.png')}}"></a></li>
                           <li><a href="#"><img src="{{asset('/landing_page/images/linkedin-icon.png')}}"></a></li>
                           <li><a href="#"><img src="{{asset('/landing_page/images/youtub-icon.png')}}"></a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h4 class="link_text">Sekilas Kami</h4>
                     <p class="footer_text_1">Politeknik Negeri Padang (PNP) didirikan sejak tahun 1987. Di tahun 2024 ini, PNP telah memiliki 7 jurusan dan 33 Program Studi yang meliputi Diploma 3, Sarjana Terapan dan Magister Terapan. PNP memiliki 476 orang Dosen yang berlatar pendidikan S2/S3 baik dari dalam maupun luar negeri.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--footer section end -->
      <!--copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">Copyright 2023 Sidang Tugas Akhir. Seluruh hak cipta dilindungi.</p>
         </div>
      </div>
      <!--copyright section end -->
      <!-- Javascript files-->
      <script src="{{asset('/landing_page/js/jquery.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/popper.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/jquery-3.0.0.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/plugin.js')}}"></script>
      <!-- sidebar -->
      <script src="{{asset('/landing_page/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/custom.js')}}"></script>
      <!-- javascript -->
      <script src="{{asset('/landing_page/js/owl.carousel.js')}}"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script type="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2//2.0.0-beta.2.4/owl.carousel.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
      <script src="{{asset('/landing_page/js/vendor/popper.min.js')}}"></script>
      <script src="{{asset('/landing_page/js/bootstrap.min.js')}}"></script>
   </body>
</html>
