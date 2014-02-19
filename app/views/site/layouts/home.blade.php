@extends('site.master')

@section('header')
<div id="header" class="row">
    <div class="row">

        <div class="col-md-4">
            {{ HTML::image('images/Logo.png') }}
        </div>
        <div class="col-md-6">

            <!-- if else statement for users authorization
            * Login Form
            * Logged In division

            -->

        <form class="form-inline" role="form" style="padding-top: 20px;">
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputPassword2">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
            <!-- end if
            else statement


            <div > username </div>

            -->

        </div>
        <!-- end if statment -->



    </div>
    @section('nav')
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">الصفحة الرئيسية</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"> <a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                    <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                            <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                            <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                            <li class="divider"></li>
                            <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                            <li class="divider"></li>
                            <li><a class="navbar-brand" href="#">الصفحة الرئيسية</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    @stop
    @yield('nav')
</div> <!-- end header-->
@stop

@section('slider')
<!-- slider -->

@stop
<!-- end of slider-->


@section('ads')
<!-- Advertisment section-->
<div id="ads-section" class="row">
    <div id="ads-1" class="col-md-6"><img class="img-responsive" src=" http://placehold.it/550x150"/></div>
    <div id="ads-2" class="col-md-6"><img class="img-responsive" src=" http://placehold.it/550x150"/></div>
</div>
<!-- <script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/youtube.xml&up_channel=nationalyou&synd=open&w=320&h=390&title=&border=%23ffffff%7C3px%2C1px+solid+%23999999&output=js"></script>end of Advertisment Section-->
@stop

@section('rightside')
<div class="col-md-8">
          <div id="youtube-1"> 
            
          <script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/youtube.xml&amp;up_channel=nationalyou&amp;synd=open&amp;w=320&amp;h=390&amp;title=&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
            
            </div>

                <div id="side-instagram">
                    <div class="panel panel-default">
                        <div class="panel-heading">انستجرام</div>
                        <div class="panel-body">
<iframe id="instimg-iframe" src="http://imageagram.com/grid.php?q=u&search=Kaizen_co&wt=in&s=180&h=3&w=3&b=no&c=&p=35&ho=fadeOut&sh=no" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:651px; height: 651px" ></iframe>
                        </div>
                    </div>
                </div><br>

            </div>
@stop

@section('leftside')
        <!-- slides section -->
        <div class="col-md-4"> 
            <div id="twitter">
                <div class="panel panel-default">
                    <div class="panel-heading">تويتر</div>
                    <div class="panel-body">
<a class="twitter-timeline" href="https://twitter.com/UsamaIIAhmed" data-widget-id="352804064125415424">Tweets by @UsamaIIAhmed</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


                    </div>
                </div>
            </div><br>
            <div id="side-1">
                <div class="panel panel-default">
                    <div class="panel-heading">العنوان العنوان</div>
                    <div class="panel-body">
                        <ul>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                        </ul>
                    </div>
                </div>
            </div><br>
            <div id="side-1">
                <div class="panel panel-default">
                    <div class="panel-heading">العنوان العنوان</div>
                    <div class="panel-body">
                        <ul>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                        </ul>
                    </div>
                </div>
            </div><br>
            <div id="side-1">
                <div class="panel panel-default">
                    <div class="panel-heading">العنوان العنوان</div>
                    <div class="panel-body">
                        <ul>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                            <li>الموضوع الأول الموضوع الأول</li>
                        </ul>
                    </div>
                </div>
            </div><br>
        </div>
@stop

@section('footer')
 <!--footer start-->
<div id="footer" class="row"><br>
    <div class=""><img class="img-responsive" src="{{asset('images/Footer.png') }}"/></div>
</div><!-- end of footer-->
@stop