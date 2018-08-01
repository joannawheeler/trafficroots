@extends('layouts.landing')
@section('title', 'Support')
@section('css')
<!-- <style>

</style> -->
@endsection
<!-- @section('js')
---EXAMPLE
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
---END EXAMPLE
@endsectionß
@section('content')
 -->

<!-- TODO: remove .html formatting and change format to php, uncomment php -->
<!-- HTML formatting is for testing only. Once development environment is configured, will convert to php format -->

<!-- <!DOCTYPE html>
<html lang="en">
  <head>
    <title>Advertiser Support</title>
    <meta charset="ut-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="support.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body> -->
    <!-- <p> $output </p> -->

@section('content')
<style>
  ul {
    font-size: 18px;
    padding: 0;
    list-style-type: none;
  }

  a {
    /*color: #1ab394*/
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
    padding: 50px 50px 120px 120px;
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

  .topicHeadAndList {

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
    <div class="row" style="background-color: rgba(176,196,222,.75); height: 8.5%; position: fixed; width: 100%">
    </div>
  </section>

  <section>
    <div class="row alignCenterVertical" style="background-image: url('https://www.renmoneyng.com/images/uploads/faqs.png'); background-size: cover; margin-top: 4.5%">
      <div class="col-12-sm" style="">
        <h1 class="title" style="font-weight: bolder; font-size: 60px; color: white; ">Publisher Support</h1>
        <p class="text-center switchToAdvText"; ">Switch to<a id="switchToAdvLink" href="https://trafficroots.test/advertiserSupport"> Advertiser Support</a></p>
      </div>
    </div>
  </section>

  <section>
    <div class="row">
      <div class="col-sm-4">
        <h2 class="topics">Getting Started</h2>
        <ul>
          <li><a href="#">Video: How to Get Started</a></li>
          <li><a href="#">Am I a publisher or am I an advertiser?</a></li><li><a href="#">Tips for Success</a></li>
          <li><a href="#">How long does it take for my campaign to be approved?
            </a>
          </li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Campaigns</h2>
      <ul>
          <li><a href="#">Why was my campaign rejected?</a></li>
          <li><a href="#">How long does it take for my campaign to be approved?</a></li>
          <li><a href="#">Do I receive an Invoice?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Pricing</h2>
        <ul>
          <li><a href="#">How much is it to advertise?</a></li>
          <li><a href="#">Do I receive an Invoice?</a></li>
          <li><a href="#">How do I add funds to my acount?</a></li>
          <li><a href="#">What payment options do you accept?</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <h2 class="topics">Payments</h2>
        <ul>
        <li><a href="#">Video: How to Get Started</a></li>
        <li><a href="#">Tips for Success</a></li>
          <li><a href="#">How much is it to advertise?</a></li>
          <li><a href="#">Do I receive an Invoice?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Something Else</h2>
        <ul>
          <li><a href="#">Why was my campaign rejected?</a></li>
          <li><a href="#">How long does it take for my campaign to be approved?</a></li>
          <li><a href="#">How long does it take for my campaign to be approved?</a></li>
        </ul>
      </div>
      <div class="col-sm-4">
        <h2 class="topics">Something Else</h2>
        <ul>
          <li><a href="#">How much is it to advertise?</a></li>
          <li><a href="#">Do I receive an Invoice?</a></li>
          <li><a href="#">How do I add funds to my acount?</a></li>
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
<!--   </body>
</html> -->
<!-- <script>
  <a id="some_id" class="optional_has_click">Click Me</a>

<script type="text/javascript">
  $(document).ready(function(){

    $("#some_id").click(function(){

      // do something
      alert( $(this).attr("id") );

    });

  });
</script> -->

<!-- var linkList = {
  topic1 : [subtopic1, subtopic2, subtopic3],
  topic2 : [subtopic1, subtopic2],
  topic3 : [subtopic1, subtopic2, subtopic3, subtopic4]
}

$(linkList).each(function(i, item) {
  $("<li/>".html($()))
}) -->


<!--
@endsection
@section('js')

@endsection
