extends('site.layouts.home')
@section('footer')
<!--footer start-->
<div id="footer" class="row">
    <div class="col-md-5" id="socialicons">
        <p>تواصل معنا</p>
        <div class="col-md-2"><img class="img-responsive" src="{{ asset('images/TwitterIcon.png')}}"/> </div>
        <div class="col-md-2"><img class="img-responsive" src="{{ asset('images/FacebookIcon.png')}}"/> </div>
        <div class="col-md-2"><img class="img-responsive" src="{{ asset('images/YoutubeIcon.png')}}"/> </div>
        <div class="col-md-2"> <img class="img-responsive" src="{{ asset('images/InstagramIcon.png')}}"/> </div>

    </div>

    <div class="col-md-7"style="padding: 15px; color:white;">
        copyrights 2014 </br>
جميع الحقوق محفوظة ـ شركة كايزن للمؤتمرات والمعارض
    </div>
</div><!-- end of footer-->
@stop