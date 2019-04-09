<?php
    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
        }
    } 

    include $_SERVER['DOCUMENT_ROOT'] . '/elements/php_session_check.php';

    
    $cmd = filter_input(INPUT_GET, 'cmd');
    $val_a = filter_input(INPUT_GET, 'val_a');
    
    $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);

    $item = $database->selectSingleClass('tblItems', 'MItem', array('accessId' => $val_a));
    
?>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width">
<title>Profondo - <?php echo $item->title; ?></title>
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Open+Sans:400italic,600italic,700italic,400,300,600,700|Roboto:400,300,100,500,700|Raleway:400,300&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Cardo:400,400italic,700" rel="stylesheet" type="text/css">
<link href="https://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style type="text/css">.animated{-webkit-animation-duration:1s;-moz-animation-duration:1s;-o-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;-moz-animation-fill-mode:both;-o-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInRight{0%{opacity:0;-webkit-transform:translateX(10px)}100%{opacity:1;-webkit-transform:translateX(0)}}@-moz-keyframes fadeInRight{0%{opacity:0;-moz-transform:translateX(10px)}100%{opacity:1;-moz-transform:translateX(0)}}@-o-keyframes fadeInRight{0%{opacity:0;-o-transform:translateX(10px)}100%{opacity:1;-o-transform:translateX(0)}}@keyframes fadeInRight{0%{opacity:0;transform:translateX(10px)}100%{opacity:1;transform:translateX(0)}}.fadeInRight{-webkit-animation-name:fadeInRight;-moz-animation-name:fadeInRight;-o-animation-name:fadeInRight;animation-name:fadeInRight}.tabcontent ol,.tabcontent ul{padding-left:20px;margin:0;line-height:1.5}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}#wrapper{max-width:1390px;padding-left:10px;padding-right:10px;position:relative;margin:0 auto}.clearer{clear:both}#gallery{width:45%;float:left;margin-bottom:40px}#bigPic{min-height:400px;text-align:center;border:1px solid #ddd;background-color:#fff;}#bigPic img{max-width:100%}.galleryThumbPadding{display:inline-block;width:23.5%}.galleryThumb:hover{cursor:pointer;/*opacity:.7;-ms-transition:.2s;-moz-transition:.2s;-webkit-transition:.2s;transition:.2s*/}.galleryThumb{padding:0 5px 0 5px;-ms-transition:.2s;-moz-transition:.2s;-webkit-transition:.2s;transition:.2s}.galleryThumb img{max-width:100%;border:1px solid #ddd}#galleryNav{padding-top:15px;text-align:center}#header{padding-top:30px;margin-bottom:40px;text-align:center;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#header h1{font-family:'montserrat',sans-serif;font-weight:300;font-size:54px;margin-bottom:15px;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#header h1:hover{color:#bf392b;cursor:default}#header a,#header a:visited{text-decoration:none;color:inherit}#navigation{height:50px;margin-bottom:50px;border-top:1px solid #dddddd;border-bottom:1px solid #dddddd; background-color:#fafafa;}.navList{margin:0}#navigation li{display:inline-block;line-height:50px;margin:0 60px 0 0;font-family:'montserrat',sans-serif;font-size:14px;color:#333;font-weight:400;text-transform:uppercase}#navigation li:hover,#navigation li a:hover{text-decoration:underline}#navigation a,#navigation a:visited{text-decoration:none}#upperBody{margin-left:45%;padding-top:1px;padding-left:25px;margin-bottom:50px}#upperBody h1,#upperBody h3{margin-top:10px;margin-bottom:0;font-family:'montserrat',sans-serif;font-size:30px;font-weight:400;color:#1f1f1f;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#upperBody h2{font-family:'cardo',sans-serif;font-size:16px;font-weight:300;color:#999;margin-top:7px}#upperBody p{font-family:'open sans',sans-serif;font-size:15px;font-weight:400;color:#555}#variationContainer{font-family:'montserrat',sans-serif;width:345px;margin:20px 0 0 0;padding-bottom:45px;padding-left:25px;border-top:1px solid #ddd}#variationContainer h4{font-size:14px;margin-top:25px;margin-bottom:10px;font-weight:400}.varList1{list-style:none;padding:0;margin:0}.varList1 li{display:inline-block;background-color:fff;color:#333;border:1px solid #333;padding:5px 10px;font-size:12px;margin-right:5px}.varList1 li:hover{cursor:default;background-color:#000;color:#fff}.varList2{list-style:none;padding:0;margin:0}.varList2 li{display:inline-block;border:1px solid #333;color:#333;padding:5px 10px;font-size:12px;margin-right:5px}.varList2 li:hover{cursor:default;background-color:#000;color:#fff}#priceContainer{width:275px;height:100px;margin:0 0 35px 0;padding-top:25px;padding-left:25px;background-color:#eee}#priceContainer h3{text-align: center;font-family:'lato',sans-serif;font-size:32px;color:#333;display:inline-block}#priceContainer h4{display:inline;position:relative;font-family:'lato',sans-serif;top:15px;left:-25px;font-size:12px;font-weight:400;color:#333}sup{font-family:'lato',sans-serif;font-size:24px;color:#333}#buyItNowButton{width:125px;height:45px;margin-left:30px;padding:0 5px;line-height:45px;background-color:#fff;border:2px solid #000;display:inline-block;text-align:center;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#buyItNowButton a,#buyItNowButton a:hover,#buyItNowButton a:visited{text-decoration:none;color:inherit}#buyItNowButton:hover{background-color:#333;cursor:pointer;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#buyItNowButton:hover h3{color:#fff;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#buyItNowButton h3{font-family:'montserrat',sans-serif;font-size:16px;color:#333;padding:0;margin:0;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#feedbackContainer{width:490px;padding:0 20px 20px 0;margin-left:20px;display:inline-block}.underline{width:20px;height:3px;background-color:#000;margin:13px 0}#feedbackContainer h3{font-family:'cardo',sans-serif;font-size:21px;color:#444}.feedback{font-family:'lato',sans-serif}#upperBody .feedback p{font-size:14px;color:#333;padding:10px 10px}.feedback i{font-size:12px;font-style:italic;position:relative;left:-40px;top:20px;padding-top:5px}.feedback span{position:relative;left:25px;top:5px;font-style:italic;font-size:12px}#picsNavContainer{display:inline-block}#shortdescription{max-width:670px;padding-right:15px;overflow:hidden;line-height:1.6}#tab2,#tab3,#tab4,#tab5{display:none}.tablinks{left:0!important;min-width:960px;width:100%;height:40px;margin-bottom:0;padding:0;list-style:none}.tablinks li{float:left;width:150px;height:30px;background-color:#eff0eb;display:inline-block;text-align:center;font-size:16px;font-family:'Lato',sans-serif;color:#666;padding-top:10px;margin-right:10px;-webkit-transition:all .1s ease-in-out;-moz-transition:all .1s ease-in-out;-o-transition:all .1s ease-in-out;transition:all .1s ease-in-out;text-transform:uppercase}.tablinks li:hover{color:#fff;background-color:#bf392b;cursor:pointer;-webkit-transition:all .1s ease-in-out;-moz-transition:all .1s ease-in-out;-o-transition:all .1s ease-in-out;transition:all .1s ease-in-out;text-decoration:none;text-transform:uppercase}.tablinks li span{width:150px;height:30px;background-color:#fff;display:inline-block;text-align:center;font-size:16px;font-family:'Lato',sans-serif;color:#000;padding-top:9px;border:1px solid #d6d6d6;border-bottom:1px solid #fff;z-index:2;text-transform:uppercase;position:relative}.eBayFeatureList{list-style:none;padding:0 0 0 20px;text-align:left;max-width:380px;margin:0 auto!important}.eBayFeatureList li{margin-bottom:10px}.eBayFeatureList i{margin-right:8px}#descriptionFeatures{text-align:center;margin:50px 0 70px 0;background-color:#f0f0f0;padding:30px 0 60px 0;font-size:18px}#descriptionFeatures h1{font-size:40px}.tabcontent h1,.tabContainer h1{font-size:28px;font-weight:300;font-family:'montserrat',sans-serif;color:#333}.tabtitle{padding:15 5 5 5;border-bottom:0;font-size:12px;text-transform:uppercase}.tabContainer{clear:both;padding-bottom:20px;font:15px Lato}.tabcontent{margin:0;padding:25px 50px 55px 50px;overflow:hidden;font:16px Lato;color:#555;text-align:left;line-height:1.5}.tabcontent a{color:#bf392b}.tabcontent a:hover,.tabcontent a:visited{color:#c0392b}.tabcontent img{max-width:100%;height:auto;margin:5px}.contentBorder{border:1px solid #d6d6d6}.contentImgLeft{float:left;width:50%;margin-top:0;margin-right:30px;margin-bottom:20px;margin-left:0}.contentImgRight{float:right;width:50%;margin-top:0;margin-right:0;margin-bottom:20px;margin-left:30px}.contentImgLeft img,.contentImgRight img{width:100%}.contentImgInline{display:inline-block;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:15px}.bsItem,.bsItem1,.bsItem2,.bsItem3{width:30%;font-family:'cardo',open sans;font-weight:300;text-align:center;padding:10px;border:1px solid #fff;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.bsItem img,.bsItem1 img,.bsItem2 img,.bsItem3 img{max-width:100%;height:auto;max-height:100%;width:auto;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.bsItem h2,.bsItem1 h2,.bsItem2 h2,.bsItem3 h2{font-weight:400;font-size:22px;margin-bottom:7px;color:#333}.bsItem h3,.bsItem1 h3,.bsItem2 h3,.bsItem3 h3{font-weight:400;color:#bf392b;font-size:18px;font-family:'lato';margin-top:0}.bsItem a,.bsItem a:hover,.bsItem a:visited,.bsItem1 a,.bsItem1 a:hover,.bsItem1 a:visited,.bsItem2 a,.bsItem2 a:hover,.bsItem2 a:visited,.bsItem3 a,.bsItem3 a:hover,.bsItem3 a:visited{text-decoration:none;color:inherit}.bsItem sup,.bsItem1 sup,.bsItem2 sup,.bsItem3 sup{font-size:13px;color:#bf392b}.bsItem:hover img,.bsItem1:hover img,.bsItem2:hover img,.bsItem3:hover img{opacity:.7;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.bsItem:hover,.bsItem1:hover,.bsItem2:hover,.bsItem3:hover{cursor:pointer;border:1px solid #bf392b;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}#bsItemContainerHeading h1{margin:0 20px;position:relative;overflow:hidden;font-family:'cardo',"open sans";font-size:24px;font-weight:400;padding-top:10px}#bsItemContainerHeading h1:after,#bsItemContainer h1:before{content:'';margin-top:.5em;height:0;border-top:groove 1px #000;width:100%;position:absolute;margin-right:-100%;margin-left:1%}#bsItemContainerHeading h1:before{margin-left:-101%}#bsItemContainerHeading{margin-bottom:35px}#bsItemContainer{margin-top:10px;text-align:center;overflow:hidden}.bsItem1{float:left;margin-left:10px}.bsItem2{margin:0 auto}.bsItem3{float:right;margin-right:10px}#footerContainer{font-family:'Lato',sans-serif;background-color:#222;width:100%;height:190px;margin:0;padding:20px 0 0 0}#footerContainer h1{font-family:'Montserrat',sans-serif;font-size:18px;color:#fff;margin:0 0 26px 0;font-weight:300;padding:0}#footerContainer i{color:#fff;font-size:22px;float:left;line-height:30px}#footerContainer a{color:#d6d6d6;text-decoration:none}#footerColumn1{float:left;width:220px;height:180px;margin-left:60px}#footerColumn2,#footerColumn3{float:left;width:205px;height:180px;margin-left:35px}.footerRow{height:30px;margin-bottom:20px}#footerColumn1 p{font-size:12px;color:#d6d6d6;margin:0 0 0 40px;margin-bottom:0;padding:0}#footerColumn2 p{font-size:12px;color:#d6d6d6;margin:5px 0 0 15px;display:block;font-weight:400;float:left}#footerColumn3 p{font-size:12px;color:#d6d6d6;font-weight:400;clear:both}#footerColumn3 span{font-weight:400;margin-top:5px}#copyright{float:left;color:#d6d6d6;font-size:9px;margin:10px 0 0 0}#copyright a{color:#fff;text-decoration:none}@media only screen and (max-width:820px),only screen and (max-width:820px) and (-moz-min-device-pixel-ratio:3),only screen and (max-width:820px) and (-o-min-device-pixel-ratio:3/2),only screen and (max-width:820px) and (-webkit-min-device-pixel-ratio:3),only screen and (max-width:820px) and (min-device-pixel-ratio:3),only screen and (max-width:820px) and (-moz-min-device-pixel-ratio:2),only screen and (max-width:820px) and (-o-min-device-pixel-ratio:2/1),only screen and (max-width:820px) and (-webkit-min-device-pixel-ratio:2),only screen and (max-width:820px) and (min-device-pixel-ratio:2),only screen and (max-width:800px) and (-moz-min-device-pixel-ratio:3),only screen and (max-width:820px) and (-o-min-device-pixel-ratio:3),only screen and (max-width:820px) and (-webkit-min-device-pixel-ratio:3),only screen and (max-width:820px) and (min-device-pixel-ratio:3),only screen and (max-width:820px) and (device-aspect-ratio:9/16),only screen and (device-width:820px) and (device-height:820px) and (-webkit-device-pixel-ratio:3),only screen and (max-width:820px) and (-webkit-min-device-pixel-ratio:1.5){#header img{max-width:100%}#navigation{height:auto}.navList{padding-left:0}#navigation li{display:block;padding:0;border-top:1px solid #ddd;width:100%}#navigation li:first-child{border-top:0}#gallery{width:100%;clear:both;margin-bottom:30px}.galleryThumbPadding{display:inline-block;width:23%}#upperBody{clear:both;margin-left:0;padding:0;margin-bottom:50px;text-align:center}#shortdescription{max-width:820px;padding-right:0}#variationContainer{margin-right:auto;margin-left:auto;padding-left:0}#priceContainer{margin:0 auto;width:auto;height:auto;margin-bottom:40px;padding:10px 10px 40px 10px}#buyItNowButton{margin-top:30px;position:relative;right:15px}#feedbackContainer{margin-right:auto;margin-left:auto;max-width:360px;display:block}#feedbackContainer h3{text-align:center}.underline{margin-right:auto;margin-left:auto}.tablinks{display:none}#tab1,#tab2,#tab3,#tab4,#tab5{display:block;margin-top:50px}.tabcontent{padding:15px}.tabcontent img{max-width:100%;width:auto;max-height:auto;height:auto;margin:0}.contentImgLeft,.contentImgRight{margin:0 auto;text-align:center;float:none;clear:both;width:auto;max-width:100%}.contentImgLeft img,.contentImgRight img{margin-bottom:10px}.eBayFeatureList{padding-right:10px;padding-left:10px}.bsItem1,.bsItem2,.bsItem3{float:none;clear:both;margin:0 auto;width:90%}#footerColumn1,#footerColumn2,#footerColumn3{float:none;display:block;clear:both;margin:0 auto;margin-bottom:40px;text-align:left;padding:0;width:55%}#footerColumn1 p{font-size:12px;color:#d6d6d6;margin:0 0 0 50px;margin-bottom:0;padding:0}#footerContainer{height:700px}}/* colors and borders */.pic_gallery { border:0px solid #888; } /* gallery border color */.pic_gallery .pic_sm div { } /* thumbnail cell border */.pic_gallery .pic_lg div { } /* main photo cell border */.pic_gallery .pic_sm img { } /* thumbnail border */.pic_gallery .pic_lg img { } /* main photo border */.pic_gallery .pic_set:hover .pic_sm div { color: red; } /* thumbnail border hover color */.pic_gallery { background-color:#FFFFFF; } /* gallery background color */.pic_gallery .pic_sm div, .pic_gallery .pic_lg div { background-color:#fff; } /* cell background color *//* shadows and corners */.pic_gallery .pic_sm { }.pic_gallery .pic_lg { }.pic_gallery .pic_sm div { } /* cell corners and shadows */.pic_gallery .pic_lg div { } /* cell corners and shadows */.pic_gallery .pic_sm img { }/* image corners and shadows */.pic_gallery .pic_lg img { }/* image corners and shadows *//* sizing, matting, and margins (all values interact and vary by aspect ratio and image count) */.pic_gallery { width:100% !important; max-width:none; } /* change this % for media queries */@media all and (min-width: 600px) {.pic_gallery { width: 100%!important; }}@media all and (min-width: 800px) {.pic_gallery { margin: 0 0 10px 15px; }}@media all and (min-width: 1100px) {.pic_gallery { width: 80%!important; }}.pic_gallery .pic_gal_5x1 { width:100%; padding-top:119.39%; }.pic_gallery .pic_gal_5x1 .pic_gal_cells { width:96.96%; height:97.46%; } /* sets padding around entire gallery */.pic_gallery .pic_gal_5x1 .pic_sm { width:18.75%; height:15.62%; margin:0.62%; }.pic_gallery .pic_gal_5x1 .pic_lg { width:98.75%; height:82.29%; margin:0.62%; }.pic_gallery .pic_gal_5x1 .pic_sm img { max-width:83.33%; max-height:83.33%; } /* sets margin around thumbnail */.pic_gallery .pic_gal_5x1 .pic_lg img { max-width:96.83%; max-height:96.83%; } /* sets margin around large photo *//* structural */.pic_gallery, .pic_gallery .gal { position:relative; margin:auto; }.pic_gallery .pic_gal_cells { position:absolute; left:0; top:0; bottom:0; right:0; margin:auto; }.pic_gallery img { position:absolute; width:auto; height:auto; left:0; top:0; bottom:0; right:0; margin:auto; }.pic_gallery .pic_sm { position:relative; overflow:hidden; float:left; display:block; }.pic_gallery .pic_lg { position:absolute; overflow:hidden; display:none; left:0%; top:0%; z-index:1; }.pic_gallery .pic_sm div, .pic_gallery .pic_lg div { position:absolute; left:0%; top:0%; right:0%; bottom:0%; }.pic_gallery .pic_lg { display:none; }.pic_gallery .pic_lg.pic_main { position:relative; display:block; float:left; z-index:0; } /* turn on default large photo */.pic_gallery .pic_set:hover .pic_sm div { /* opacity:.5; */ border:1px solid; }.pic_gallery .pic_set:hover .pic_lg { display:block; left:0%; top:0%; }</style>
<style>/*----- Tab Box -----*/div.tabbox { margin: 20px 2px; }div.tabcontent1 {display: none;margin:0;padding: 11px 13px 1px 13px;overflow:hidden;font:16px Lato;color:#555;background-color: #fff;line-height: 1.5;border:1px solid #d6d6d6;}div.tabcontent1 h3 {margin-bottom: 18px;font-size:28px;font-weight:300;font-family:'montserrat',sans-serif;color:#333;}div.tabcontent1 p { margin: 15px 0; }div.tabcontent1 li { margin: 5px 0 5px 20px; }div.tabcontent1 ul, div.tabcontent1 ol { margin: 15px 0; padding: 0 0 0 20px; }div.tabcontent1 ul li, div.tabcontent1 ol li { margin: 5px 0; }div.tabcontent1 a { color: #111111!important; text-decoration: underline!important; }div.tabcontent1 a:hover { color: #777777!important; text-decoration: none!important; }input.tabbtn { display: none; }label.tabslabel {display: inline-block;margin-right: -3px!important;padding: 0 6px!important;text-align: center;color: #666;font-size: 14px;text-transform: capitalize;height: 36px;line-height: 36px;background-color: #eff0eb;}label.tabslabel:hover, input.tabbtn:checked + label.tabslabel {cursor: pointer;background-color: #bf392b;color: #fff!important;}#tabs1:checked ~ #content1,#tabs2:checked ~ #content2,#tabs3:checked ~ #content3,#tabs4:checked ~ #content4 { display: block; }@media all and (min-width: 400px) {label.tabslabel { padding: 0 11px!important; }}@media all and (min-width: 500px) {label.tabslabel { padding: 0 20px!important; }}@media all and (min-width: 600px) {label.tabslabel { padding: 0 25px!important; }}@media all and (min-width: 800px) {div.tabbox { margin: 20px 2px 20px 0px; }div.tabcontent1 { height: 200px; overflow: auto; }label.tabslabel { margin-right: 3px!important;font-size: 16px; }}@media all and (min-width: 1100px) {div.tabcontent1 { padding:25px 50px 55px 50px }} </style>
<!--[if lt ie 8]>
<style>
/* lower browser version can not display gallery */
.pic_gallery .pic_set {display:none}
.pic_gallery .pic_gal { padding:0; }
.pic_gallery .pic_gal_cells { position:relative; width:100%;}
.pic_gallery .pic_gal .pic_lg,
.pic_gallery .pic_gal .pic_lg img { position:relative; width:100%; padding:0; margin:1px; }
</style>
<![endif]-->
<div id="wrapper">
<div id="header">
<h1><a href="http://www.ebay.co.uk/usr/profondo_uk" target="_blank">profondo</a></h1>
<div id="navigation">
<ul class="navList">
<li><a href="http://www.ebay.co.uk/usr/profondo_uk" target="_blank" title="About Us">ABOUT US</a></li>
<li><a href="http://feedback.ebay.co.uk/ws/eBayISAPI.dll?ViewFeedback2&userid=profondo_uk" target="_blank" title="Feedback">FEEDBACK</a></li>
<li><a href="http://my.ebay.co.uk/ws/eBayISAPI.dll?AcceptSavedSeller&sellerid=profondo_uk" target="_blank" title="Add Us">ADD US</a></li>
<li><a href="http://my.ebay.co.uk/ws/eBayISAPI.dll?AcceptSavedSeller&sellerid=profondo_uk" target="_blank" title="Newsletter">NEWSLETTER</a></li>
<li><a href="http://contact.ebay.co.uk/ws/eBayISAPI.dll?ShowSellerFAQ&iid=profondo_uk" target="_blank" title="Contact Us">CONTACT</a></li>
</ul>
</div>
</div>
<div id="gallery">
<div id="bigPic">
<br style="display:none">
<div class="pic_gallery">
<div class="pic_gal pic_gal_5x1">
<div class="pic_gal_cells">
<!---------- Replace your Product Image urls below here ------------>
<div class="pic_lg pic_main"><div>
<!--- BIG IMAGE --->
<img src="<?php echo 'http://phoenixrl.com/assets/pictures/' . $item->sku . '/1.jpg'; ?>" >
</div></div>
<!-- thumbnails (5 max) -->

<?php

    $pictures = array_diff(scandir($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/'), array('..', '.'));
    $i = 0;
    foreach($pictures as $row){
        if($i < 5){
?>
    
<span class="pic_set"><div class="pic_sm"><div>
<!--- THUMBNAIL IMAGE (SMALL IMAGE) <?php echo $i+1; ?> --->
<img src="<?php echo 'http://phoenixrl.com/assets/pictures/' . $item->sku . '/' . $row; ?>" >
</div></div><div class="pic_lg"><div>
<!--- THUMBNAIL IMAGE (SMALL IMAGE) <?php echo $i+1; ?> --->
<img src="<?php echo 'http://phoenixrl.com/assets/pictures/' . $item->sku . '/' . $row; ?>" >
</div></div></span>

<?php
        }
        $i++;
    }
?>





</div>
</div>
</div>
</div>
</div>
<div id="upperBody">
<div id="shortdescription">
<!-- Replace the product title below here -->
<h1><?php echo $item->title; ?></h1>
<h2><?php echo $item->subtitle; ?></h2>
</div>
<br>
<div id="priceContainer">
<h3>
<!-- Replace price below here -->
<sup>&pound;</sup>
<?php echo $item->RRP; ?>
</h3> + FREE Postage
</div>
</div>
<div class="tabContainer">
<div class="tabbox">
<input id="tabs1" type="radio" name="tabs" class="tabbtn" checked>
<label for="tabs1" class="tabslabel">Description</label>
<input id="tabs2" type="radio" name="tabs" class="tabbtn">
<label for="tabs2" class="tabslabel">Payment</label>
<input id="tabs3" type="radio" name="tabs" class="tabbtn">
<label for="tabs3" class="tabslabel">Delivery</label>
<input id="tabs4" type="radio" name="tabs" class="tabbtn">
<label for="tabs4" class="tabslabel">Returns</label>
<div class="tabcontent1" id="content1">
<h3>Item Description</h3>
<!----- START ----- Insert Description here, p represents each paragraph, li is list(must be used in ul) ------------------->
<?php echo $item->fullDescription; ?>
<!----- END ----- Insert Description here, p represents each paragraph, li is list(must be used in ul) ------------------->
</div>
<div class="tabcontent1" id="content2">
<h3>Methods of Payment</h3>
<!-- PAYMENT ---- Insert content below here, p represents each paragraph ---->
<p>We accept payment by any of the following methods:</p>
<p>PayPal</p>
<p>Please pay as soon as possible after winning an auction, as that will allow us to post your item to you sooner!</p>
</div>
<div class="tabcontent1" id="content3">
<h3>Delivery Information</h3>
<!-- DELIVERY INFORMATION ---- Insert content below here, p represents each paragraph ---->
<p>We offer FREE shipping on all orders!</p>
<p>Your order will be dispatched within 2 working day of receiving payment (Monday-Friday) and you should expect to receive it two or three days after dispatch (orders sent RM 2nd Class).</p>
<p>In the very unlikely event that your item is lost or damaged during post, then WE are responsible and will issue either a full refund or replacement.</p>
</div>
<div class="tabcontent1" id="content4">
<h3>Returns</h3>
<!-- RETURNS ---- Insert content below here, p represents each paragraph ---->
<p>If you are not 100% satisfied with your purchase, you can return the product and get a full refund or exchange the product for another one, be it similar or not.</p>
<p>You can return a product for up to 14 days from the date you purchased it.</p>
<p>Any product you return must be in the same condition you received it and in the original packaging. Please keep the receipt.</p>
</div>
</div>
</div>

<!-- /footerContainer -->
<!-- /wrapper -->