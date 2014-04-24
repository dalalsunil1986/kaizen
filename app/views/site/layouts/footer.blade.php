@extends('site.layouts.home')
@section('footer')
<!--footer start-->
<div id="footer">
    <div class="col-md-6 " id="socialicons">

        <div class="col-md-1 col-xs-1"><img class="img-responsive" src="{{ asset('images/TwitterIcon.png')}}"/> </div>
        <div class="col-md-1 col-xs-1"><img class="img-responsive" src="{{ asset('images/FacebookIcon.png')}}"/></div>
        <div class="col-md-1 col-xs-1"><a href="http://www.youtube.com/user/KaizenYC"><img class="img-responsive" src="{{ asset('images/YoutubeIcon.png')}}"/> </a></div>
        <div class="col-md-1 col-xs-1"> <img class="img-responsive" src="{{ asset('images/InstagramIcon.png')}}"/> </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 top5 copyright">
                Copyrights <?php echo date('Y'); ?>
            </div>
            <div class="col-md-12 copyright">
                جميع الحقوق محفوظة ـ شركة كايزن للمؤتمرات والمعارض
            </div>
            <div class="col-md-12 copyright">
                Site Developed By <a href="http://ideasowners.net" target="_blank">IdeasOwners.net</a>
            </div>

        </div>
    </div>

</div><!-- end of footer-->
@stop