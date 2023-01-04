<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}


    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

	    .primary{
	background: #f5564e;
}
.bg_white{
	background: #ffffff;
}
.bg-vso{
	background: #C00033;
}
.bg-footer{
	background: #324B71;
}
.bg-magenta{
	background: #AB1860;
}
.bg_light{
	background: #fafafa;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: #2F4858;
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 3px 15px;
	display: inline-block;
}
.btn.btn-primary{
	border-radius: 3px;
	background: #C00033;
	color: #ffffff;
}
.btn.btn-white{
	border-radius: 3px;
	background: #ffffff;
	color: #000000;
}
.btn.btn-white-outline{
	border-radius: 5px;
	background: transparent;
	border: 1px solid #fff;
	color: #fff;
}

h1,h2,h3,h4,h5,h6{
	font-family: 'Nunito Sans', sans-serif;
	color: #000000;
	margin-top: 0;
}

body{
	font-family: 'Nunito Sans', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.4);
}

a{
	color: #f5564e;
}

table{
}
/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #000;
	font-size: 20px;
	font-weight: 700;
	text-transform: uppercase;
	font-family: 'Nunito Sans', sans-serif;
}

.navigation{
	padding: 0;
}
.navigation li{
	list-style: none;
	display: inline-block;;
	margin-left: 5px;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
}
.navigation li a{
	color: rgba(0,0,0,.6);
}

/*HERO*/
.hero{
	position: relative;
	z-index: 0;
}
.hero .overlay{
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	content: '';
	width: 100%;
	background: #000000;
	z-index: -1;
	opacity: .3;
}
.hero .icon{
}
.hero .icon a{
	display: block;
	width: 60px;
	margin: 0 auto;
}
.hero .text{
	color: rgba(255,255,255,.8);
	padding: 0 4em;
}
.hero .text h2{
	color: #ffffff;
	font-size: 40px;
	margin-bottom: 0;
	line-height: 1.2;
	font-weight: 900;
}


/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
	color: #000000;
	font-size: 24px;
	margin-top: 0;
	line-height: 1.4;
	font-weight: 700;
}
.heading-section .subheading{
	margin-bottom: 20px !important;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(0,0,0,.4);
	position: relative;
}
.heading-section .subheading::after{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -10px;
	content: '';
	width: 100%;
	height: 2px;
	background: #f5564e;
	margin: 0 auto;
}

.heading-section-white{
	color: rgba(255,255,255,.8);
}
.heading-section-white h2{
	font-family:
	line-height: 1;
	padding-bottom: 0;
}
.heading-section-white h2{
	color: #ffffff;
}
.heading-section-white .subheading{
	margin-bottom: 0;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(255,255,255,.4);
}


.icon{
	text-align: center;
}
.icon img{
}


/*SERVICES*/
.services{
	background: rgba(0,0,0,.03);
}
.text-services{
	padding: 10px 10px 0;
	text-align: center;
}
.text-services h3{
	font-size: 16px;
	font-weight: 600;
}

.services-list{
	padding: 0;
	margin: 0 0 10px 0;
	width: 100%;
	float: left;
}

.services-list .text{
	width: 100%;
	float: right;
}
.services-list h3{
	margin-top: 0;
	margin-bottom: 0;
	font-size: 18px;
}
.services-list p{
	margin: 0;
}


/*DESTINATION*/
.text-tour{
	padding-top: 10px;
}
.text-tour h3{
	margin-bottom: 0;
}
.text-tour h3 a{
	color: #000;
}

/*BLOG*/
.text-services .meta{
	text-transform: uppercase;
	font-size: 14px;
}

/*TESTIMONY*/
.text-testimony .name{
	margin: 0;
}
.text-testimony .position{
	color: rgba(0,0,0,.3);

}


/*COUNTER*/
.counter{
	width: 100%;
	position: relative;
	z-index: 0;
}
.counter .overlay{
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	content: '';
	width: 100%;
	background: #000000;
	z-index: -1;
	opacity: .3;
}
.counter-text{
	text-align: center;
}
.counter-text .num{
	display: block;
	color: #ffffff;
	font-size: 34px;
	font-weight: 700;
}
.counter-text .name{
	display: block;
	color: rgba(255,255,255,.9);
	font-size: 13px;
}


ul.social{
	padding: 0;
}
ul.social li{
	display: inline-block;
}

/*FOOTER*/

.footer{
	color: rgba(255,255,255,.5);

}
.footer .heading{
	color: #ffffff;
	font-size: 20px;
}
.footer ul{
	margin: 0;
	padding: 0;
}
.footer ul li{
	list-style: none;
	margin-bottom: 10px;
}
.footer ul li a{
	color: rgba(255,255,255,1);
}


@media screen and (max-width: 500px) {

	.icon{
		text-align: left;
	}

	.text-services{
		padding-left: 0;
		padding-right: 20px;
		text-align: left;
	}

}


    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
	<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 700px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
      	<tr>
          <td valign="middle" class="bg-vso" style="padding: 0.6em 1.5em">
          	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
          		<tr>

          			<td width="100%" class="logo" style="text-align: center; display:inline-block; vertical-align: middle">
						<center>
						<p>
							<a href="https://validsoftware.ro" target="_blank" style="color:#fff;font-weight:900;font-size:20px;">
							<img src="{{ asset('images/email/logo-vso.png') }}" width="35px" style="vertical-align:middle;" />
								VALIDSOFTWARE.RO
							</a>
						</p>
						</center>
			        </td>

          		</tr>
          	</table>
          </td>
	      </tr><!-- end tr -->
		          <tr>
		            <td class="bg_white email-section" style="width: 100%;">
		            	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
		            		<tr>
                      <td valign="middle" width="100%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td class="text-services" style="text-align: left; padding-left:25px;">
                            	<div class="heading-section">
								              	<h2>Ofertă de servicii IT</h2>
								            	</div>
								            	<div class="services-list">
								            		<div class="text">
								            			<h3>1. Produs 1</h3>
								            			<p>A small river named Duden flows by their place and supplies</p>
														<p><a href="#" class="btn btn-primary">Află mai multe</a></p>
								            		</div>
								            	</div>
								            	<div class="services-list">
								            		<div class="text">
								            			<h3>2. Produs 2</h3>
								            			<p>A small river named Duden flows by their place and supplies</p>
														<p><a href="#" class="btn btn-primary">Află mai multe</a></p>
								            		</div>
								            	</div>
								            	<div class="services-list">
								            		<div class="text">
								            			<h3>3. Produs 3</h3>
								            			<p>A small river named Duden flows by their place and supplies</p>
														<p><a href="#" class="btn btn-primary">Află mai multe</a></p>
								            		</div>
								            	</div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
		            	</table>
		            </td>
		          </tr><!-- end: tr -->
		          <tr>
			          <td valign="middle" class="counter" style="background-image: url({{ asset('images/email/bg-counter.jpg') }}); background-size: cover; padding: 4em 0;">
			          	<div class="overlay"></div>
			            <table>
			            	<tr>
			            		<td valign="middle" width="33.333%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td class="counter-text">
                            	<span class="num">200+</span>
                            	<span class="name">Website-uri realizate</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign="middle" width="33.333%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td class="counter-text">
                            	<span class="num">150+</span>
                            	<span class="name">Clienți</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign="middle" width="33.333%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td class="counter-text">
                            	<span class="num">5/5</span>
                            	<span class="name">Recenzii</span>
                            </td>
                          </tr>
                        </table>
                      </td>
			            	</tr>
			            </table>
			          </td>
				      </tr><!-- end tr -->
					  <tr>
						<td class="bg_light email-section" style="text-align:center;">
							<div class="heading-section">
							<h2>Despre noi</h2>
							<p style="color:black">Suntem o echipă tânără din Focșani, județul Vrancea, ce oferă servicii IT complete precum realizarea de site-uri web și aplicații personalizate, mentenanța site-urilor web, administrarea de platforme universitare, promovare online.</p>
							</div>
						</td>
					  </tr><!-- end: tr -->
		        </table>

		      </td>
		    </tr><!-- end:tr -->
      </table>
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
        	<td valign="middle" class="bg-footer footer email-section" style="text-align:center">
        		<table>
            	<tr>
                <td valign="top" width="33.333%">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="padding-right: 10px;">
						<p style="color:white">
						<a href="tel:0744761451" style="color:white"><b>Telefon:</b> 0744.761.451</a><br>
						<a href="mailto:contact@validsoftware.ro" style="color:white"><b>Email:</b> contact@validsoftware.ro</a><br>
						<a href="https://validsoftware.ro" target="_blank" style="color:white"><b>Website:</b> www.validsoftware.ro</a><br>
						<b>Adresa:</b> Str. Unirea Principatelor nr. 2, Focșani, Vrancea<br><br>
						</p>
						ICONURI SOCIALE
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
        	</td>
        </tr>
      </table>

    </div>
  </center>
</body>
</html>
