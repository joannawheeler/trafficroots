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

    <h1 class="text-center">Publisher Support</h1>
    <!-- Load Advertiser Support page onClick -->
    <p class="text-center"><a href="https://trafficroots.test/advertiserSupport">Switch to Advertiser Support</a><p>
    <div>
      <section class="container">
        <div class="row">
          <div class="col-sm-4">
            <h2 class="topics text-center">Getting Started</h2>
            <ul>
              <li><a href="#">Video: How to Get Started</a></li>

<!--               <li><a id="clickMe" title="Click to do something"
 href="PleaseEnableJavascript.html" onclick="MyFunction();return false;">CLICK ME TO REDIRECT!1</a></li> -->
              <li><a href="#">Tips for Success</a></li>
              <li><a href="#">How to do something</a></li>
              <li><a href="#">Some other information here</a></li>
              <li><a href="#">Some other information here</a></li>
            </ul>
          </div>
          <div class="col-sm-4">
            <h2 class="topics text-center">Campaigns</h2>
            <ul>
              <li><a href="#">Why was my campaign rejected?</a></li>
              <li><a href="#">How long does it take for my campaign to be approved?</a></li>
            </ul>
          </div>
          <div class="col-sm-4">
            <h2 class="topics text-center">Pricing</h2>
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
            <h2 class="topics text-center">Payments</h2>
            <li><a href="#">Video: How to Get Started</a></li>
            <li><a href="#">Tips for Success</a></li>
              <li><a href="#">How much is it to advertise?</a></li>
              <li><a href="#">Do I receive an Invoice?</a></li>
          </div>
          <div class="col-sm-4">
            <h2 class="topics text-center">Something Else</h2>
            <ul>
              <li><a href="#">Why was my campaign rejected?</a></li>
              <li><a href="#">How long does it take for my campaign to be approved?</a></li>
            </ul>
          </div>
          <div class="col-sm-4">
            <h2 class="topics text-center">Something Else</h2>
            <ul>
              <li><a href="#">How much is it to advertise?</a></li>
              <li><a href="#">Do I receive an Invoice?</a></li>
              <li><a href="#">How do I add funds to my acount?</a></li>
            </ul>
          </div>
        </div>
      </section>
      <section>
        <p class="helpForumRedirect text-center">Have a specific question? Check out our <span><a href="#">Help Forum</a></span></p>
      </section>
      <section>
        <p class="articleHelpful text-center">Was this article helpful? <span><a href="#">Yes </a></span>or <span><a href="#">No</a></span></p>
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
