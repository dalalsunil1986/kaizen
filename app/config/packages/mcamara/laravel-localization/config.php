<?php

	return array(

		// List of all locales supported by your site.
		// Add any supported to the supportedLocales array.
		// A list of many locales has been added to the bottom of this file for your convenience.
		'supportedLocales' => array(
            "ar" => array("name" => "Arabic",			"script" => "Arabic",		"dir" => "rtl",		"native" =>	"العربية"),
            "en" => array("name" => "English",		"script" => "Latin",		"dir" => "ltr",		"native" => "English"),
		),

		// Negotiate for the user locale using the Accept-Language header if it's not defined in the URL?
		// If false, system will take app.php locale attribute
		'useAcceptLanguageHeader' => true,

		// Should application use the locale stored in a session
		// if the locale is not defined in the url?
		// If false and locale not defined in the url, the system will
		// take the default locale (defined in config/app.php) or
		// the browser preferred language (if useAcceptLanguageHeader is true) or
		// the cookie locale (if useCookieLocale is true)
		'useSessionLocale' => true,

		// Should application use and store the locale stored in a cookie
		// if the locale is not defined in the url or the session?
		// If true and locale not defined in the url or the session,
		// system will take the default locale (defined in config/app.php)
		// or the browser preferred locale (if useAcceptLanguageHeader is true)
		'useCookieLocale' => true,

		// If LaravelLocalizationRedirectFilter is active and hideDefaultLocaleInURL
		// is true, the url would not have the default application language
		'hideDefaultLocaleInURL' => true,

	);
