<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 100%;
			height: auto;
            text-align: left;
            margin: 10px 100px 0px 100px;
            background: #efefef;
            padding:40px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
	<div class="welcome">
<!--       <form id="newsletter" action="http://localhost:8080/en/newsletter/subscribe" method="post">-->
<!---->
<!--                <input type="email" name="email" id="email">-->
<!---->
<!--                <input type="button" value="submit" name="submit">-->
<!--            </form>-->

        {{ Form::open(array('action' => 'NewslettersController@storeNewsletter')) }}
            <ul>
                <li>
                    <label for="email">Email:</label>
                    <input name="email" type="text" id="email">   </li>


                    <input class="btn btn-info" type="submit" value="Submit">		</li>
            </ul>
        {{ Form::close() }}
	</div>
</body>
</html>
