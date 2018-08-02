@extends('layouts.landing')
@section('title', 'Support')
@section('css')
<!-- @section('content')
 -->
@section('content')
<style>
  ul {
    font-size: 18px;
    padding: 0;
    list-style-type: none;
  }

  li {
    padding-top: 10px;
    padding-bottom: 10px;
  }

  a {
    color: black
  }

  #switchToAdvLink {
    color: lightgrey
  }

  .topics {
    font-weight: bolder;
    font-size: 28px;
  }

  .topicsSection {
    padding-left: 150px;
    padding-right: 150px;
    padding-bottom: 70px;
    padding-top: 70px;
  }

  .switchToAdvText {
    color: lightgrey;
  }

  .footerSection {
    background-color: #DCDCDC;
}

  .alignCenterVertical {
    align-items:center;
    justify-content: center;
    display: flex;
    height: 50%;
  }

  .listPadding {
    padding: 0px
  }

  .topRow {
    padding-bottom: 50px;
  }

  .temporaryNav {
    background-color: rgba(176,196,222,.75);
    height: 10%;
    position: fixed;
    width: 100%
  }

  .imgTitleSection {
    background-image: url('https://www.renmoneyng.com/images/uploads/faqs.png');
    background-size: cover;
    margin-top: 5.25%
  }

  .textDocIcon {
    height: 25px;
    width: 25px;
  }

  .videoIcon {
    height: 25px;
    width: 40px;
  }


    /* Small devices (tablets, 768px and up) */
  @media (min-width: @screen-sm-min) {  }

  /* Medium devices (desktops, 992px and up) */
  @media (min-width: @screen-md-min) {
  }

  /* Large devices (large desktops, 1200px and up) */
  @media (min-width: @screen-lg-min) {
  }

</style>


<div class="container-fluid">
  <section>
    <div class="row temporaryNav">
    </div>
  </section>

  <section>
    <div class="row imgTitleSection alignCenterVertical" style="">
      <div class="col-12-sm">
        <h1 style="font-weight: bolder; font-size: 60px; color: white;">Publisher Support</h1>
        <p class="text-center switchToAdvText">Switch to<a id="switchToAdvLink" href="https://trafficroots.test/advertiserSupport"> Advertiser Support</a></p>
      </div>
    </div>
  </section>

  <section class="topicsSection">
    <div class="row topRow">
      <div class="col-sm-4">
        <h2 class="topics"> Getting Started</h2>
        <ul>
          <li><img class="videoIcon" src="https://banner2.kisspng.com/20180405/tyq/kisspng-youtube-computer-icons-font-awesome-logo-clip-art-video-icon-5ac5bcbf5e7a50.846113781522908351387.jpg"><a href="#">&nbsp&nbspVideo: How to Get Started</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspAm I a publisher or am I an advertiser?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspTips for Success</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?
            </a>
          </li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Campaigns</h2>
      <ul>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspWhy was my campaign rejected?</a></li>
          <li><img class="videoIcon" src="https://banner2.kisspng.com/20180405/tyq/kisspng-youtube-computer-icons-font-awesome-logo-clip-art-video-icon-5ac5bcbf5e7a50.846113781522908351387.jpg"><a href="#">&nbsp&nbspVideo: How long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspDo I receive an Invoice?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Pricing</h2>
        <ul>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow much is it to advertise?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspWhat payment options do you accept?</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <h2 class="topics">Payments</h2>
        <ul id="Payments">
          <li><img class="videoIcon" src="https://banner2.kisspng.com/20180405/tyq/kisspng-youtube-computer-icons-font-awesome-logo-clip-art-video-icon-5ac5bcbf5e7a50.846113781522908351387.jpg"><a href="#">&nbsp&nbspVideo: How to Get Started</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspTips for Success</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Something Else</h2>
        <ul>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspWhy was my campaign rejected?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Something Else</h2>
        <ul>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow much is it to advertise?</a></li>
          <li><img class="videoIcon" src="https://banner2.kisspng.com/20180405/tyq/kisspng-youtube-computer-icons-font-awesome-logo-clip-art-video-icon-5ac5bcbf5e7a50.846113781522908351387.jpg"><a href="#">&nbsp&nbspVideo: How long does it take for my campaign to be approved?</a></li>
          <li>&nbsp&nbsp<img class="textDocIcon" src="http://www.anasfim.com/p/2018/03/text-document-icons-free-download-for-document-template-icon-600x600.jpg"><a href="#">&nbsp&nbspHow long does it take for my campaign to be approved?</a></li>
        </ul>
      </div>
    </div>
  </section>


  <section id="contact" class="gray-section contact" style="margin-top: 0px">
    <div class="container-fluid">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <address>
                    <strong><span class="navy">Traffic Roots, LLC.</span></strong><br/>

                    San Diego, CA 92121<br/>

                </address>
            </div>
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:info@trafficroots.com" class="btn btn-primary">Send us mail</a>
                <p class="m-t-sm">
                    Or follow us on social platform
                </p>
                <ul class="list-inline social-icon">
                    <li><a href="https://twitter.com/TrafficRoots" target="_blank"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li><a href="https://www.facebook.com/trafficrootsmedia/" target="_blank"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li><a href="https://www.linkedin.com/in/traffic-roots-44b648123/" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </li>
                    <li><a href="https://instagram.com/traffic_roots" target="_blank"><i class="fa fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>&copy; <?php echo date('Y'); ?> Traffic Roots, LLC</strong></p>
            </div>
        </div>
    </div>
  </section>
</div>


@endsection



<!--
@endsection


