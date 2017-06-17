@extends('layouts.landing')
@section('content')
<div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Traffic Roots</h1>
                    <p>Ad Network for Cannabis Lifestyles</p>
                </div>
                <div class="carousel-image wow zoomIn">
                    <img src="img/landing/laptop.png" alt="laptop"/>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank">
                    <h1>Better Visibility Means <br /> Higher Traffic and Fatter Profits!.</h1>
                    <p>Traffic Roots connects the gap between digital display advertising and the cannabis industry.<br /> We empower you to scale your digital advertising efforts by reaching more consumers,<br /> on reputable websites, and with minimum effort. <br />We built the bridge to infinite digital marketing opportunities – and we’re going to help you scale it, too.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
    </div>
    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<section id="features" class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>You’ve already planted the seed. Now take your brand further!<br/> <span class="navy"> </span> </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div>
                <i class="fa fa-globe features-icon"></i>
                <h2>Global Coverage</h2>
                <p>We provide a global solution and monetize traffic from every country, worldwide. Traffic Roots helps you create ads tailored to your audience’s interests, habits, and location, with a 100% fill-rate.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-clock-o features-icon"></i>
                <h2>24/7 Customer Service</h2>
                <p>We’re here for you 24/7, because we’re more than just a service provider – we’re your partner, too. Day or night, we’ve got you covered.</p>
            </div>
        </div>
        <div class="col-md-6 text-center  wow zoomIn">
            <img src="img/landing/perspective.png" alt="dashboard" class="img-responsive">
        </div>
        <div class="col-md-3 text-center wow fadeInRight">
            <div>
                <i class="fa fa-flask features-icon"></i>
                <h2>Multiple Formats</h2>
                <p>We’ve designed a wide variety of web and mobile formats, so that you can find the best options for your business and maximize your ad revenue.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-dashboard features-icon"></i>
                <h2>Real-Time Statistics</h2>
                <p>Life doesn’t pause for data. Neither do we. Traffic Roots offers real-time, comprehensive statistics on your ads. Filter by geographic zone, or see how you’re doing on the whole.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 text-center">
            <div class="navy-line"></div>
            <h1>Tap Into Maximum Impressions!</h1>
        </div>
    </div>
</section>
<section id="team" class="features">
    <div class="row features-block">
        <div class="col-lg-6 features-text text-center wow fadeInLeft">
            <h2>Perfectly designed </h2>
            <p>Gain instant and exclusive access to the largest cannabis and vape-friendly websites from one single platform. Whether you’re looking to publish on the industry heavy-hitters, uniquely niche, both, or anything in between, we have the backstage pass to advertise on your favorite sites.</p>            
            <a href="" class="btn btn-primary">Learn more</a>
        </div>
        <div class="col-lg-6 text-right wow text-center fadeInRight">
            <img src="img/landing/dashboard.png" alt="dashboard" class="img-responsive pull-right">
        </div>
    </div>
</section>
<section id="testimonials" class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Even more great feautres</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-3 features-text wow fadeInLeft">
                <h2>Publishers</h2>
                <p>Traffic Roots provides publishers with the unique opportunity to monetize their website by getting in front of thousands of advertisers, instantly. We cooked up an algorithm that will generate relevant, high quality ads on your website, specifically chosen for your audience. Whether you’re a leader of the masses or the meeting post for the niche, Traffic Roots provides ads that your visitors will find useful (and your wallet won’t mind it, either).
</p>
                <a href="" class="btn btn-primary">Learn more</a>
            </div>
            <div class="col-lg-6 text-right m-t-n-lg wow zoomIn">
                <img src="img/landing/iphone.jpg" class="img-responsive" alt="dashboard">
            </div>
            <div class="col-lg-3 features-text text-right wow fadeInRight">
                <h2>Advertisers</h2>
                <p>Get a first-hand introduction to the largest audience of prospective buyers and clients in the cannabis industry. We meticulously developed our ad software to connect you to sites and consumers with the biggest buying potential for you, earning you more money without ever breaking a sweat. Running a digital ad campaign across a multi-channel network is easy and affordable with Traffic Roots.
</p>
                <a href="" class="btn btn-primary">Learn more</a>
            </div>
        </div>
    </div>

</section>
<section id="traffic" class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Our Traffic</h1>
                <p>Traffic Roots Gets Visitors From Around The Globe. Here's a real-time Breakdown of our Targeted Traffic: </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-6 features-text wow fadeInLeft">
                <h2>U.S. Traffic!</h2>
                <p>Traffic Breakdown: Top 20 Cannabis Friendly States</p>
                {!! $us_display !!}
            </div>
            <div class="col-lg-6 features-text wow fadeInRight">
                <h2>International Traffic!</h2>
                <p>Traffic Breakdown: Top 20 Geos</p>
                {!! $geo_display !!}
            </div>
        </div>
    </div>


</section>	
<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-3 col-lg-offset-3">
                <address>
                    <strong><span class="navy">Traffic Roots, LLC.</span></strong><br/>
                    San Diego, CA<br/>
                    <abbr title="Phone">P:</abbr> (619) 431-1017
                </address>
            </div>
            <div class="col-lg-4">
                <p class="text-color">
                    Consectetur adipisicing elit. Aut eaque, totam corporis laboriosam veritatis quis ad perspiciatis, totam corporis laboriosam veritatis, consectetur adipisicing elit quos non quis ad perspiciatis, totam corporis ea,
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:info@trafficroots.com" class="btn btn-primary">Send us mail</a>
                <p class="m-t-sm">
                    Or follow us on social platform
                </p>
                <ul class="list-inline social-icon">
                    <li><a href="https://twitter.com/TrafficRoots"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li><a href="https://www.facebook.com/trafficrootsmedia/"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li><a href="https://www.linkedin.com/in/traffic-roots-44b648123/"><i class="fa fa-linkedin"></i></a>
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

   <script type="text/javascript">
       jQuery(document).ready(function ($) {
        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();
       
   </script>
@endsection
