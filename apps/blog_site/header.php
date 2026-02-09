<style>
	
@font-face {font-family: "webfontregular"; src: url(/css/museosansrounded300-webfont.woff2) format("woff2"), 
			url(/css/museosansrounded300-webfont.woff) format("woff"); font-weight: 400; font-style: normal;}

* {margin: 0;padding: 0;}
html { overflow: auto; }
body {font-family: "webfontregular";font-size: 1.1rem;overflow: auto;}

ul li {list-style: none;}

a {text-decoration: none;}

h1,h2,h3,h4,h5,h6 {margin: 0;padding: 0;font-family: webfontregular !important;margin-bottom: 5px;font-weight: 500;}

h1 {font-size: 2rem;}

h2 {font-size: 1.8rem;}

h3 {font-size: 1.6rem;}

h4 {font-size: 1.4rem;}

h5 {font-size: 1.2rem;}

h6 {font-size: 1rem;}

.SearchBox input {width: 100%;}

.font-wgt-500 {font-weight: 500;}

.font-wgt-600 {font-weight: 600;}

.font-wgt-700 {font-weight: 700;
}
.thm-clr {color: <?php echo $general['color'];?>}

.drk-clr {color: #000;}

.gry-clr {color: #696969;}

.p0 {padding: 0;}

.m0 {margin: 0;}

.pt-0 {padding-top: 0;}

.pt-5 {padding-top: 5px;}

.pt-10 {padding-top: 10px;}

.pt-20 {padding-top: 20px !important;}

.pl-0 {padding-left: 0;}

.pl-5 {padding-left: 5px;}

.pl-10 {padding-left: 10px;}

.pl-20 {padding-left: 20px;}

.pr-0 {padding-right: 0;}

.pr-5 {padding-right: 5px;}

.pr-10 {padding-right: 10px;}

.pr-20 {padding-right: 20px;}

.pb-0 {padding-bottom: 0;}

.pb-5 {padding-bottom: 5px;}

.pb-10 {padding-bottom: 10px;}

.pb-20 {padding-bottom: 20px !important;}

.mt-0 {margin-top: 0;}

.mt-5 {margin-top: 5px;}

.mt-10 {margin-top: 10px;}

.mt-20 {margin-top: 20px !important;}

.ml-0 {margin-left: 0;}

.ml-5 {margin-left: 5px;}

.ml-10 {margin-left: 10px;}

.ml-20 {margin-left: 20px;}

.mr-0 {margin-right: 0;}

.mr-5 {margin-right: 5px;}

.mr-10 {margin-right: 10px;}

.mr-20 {margin-right: 20px;}

.mb-0 {margin-bottom: 0;}

.mb-5 {margin-bottom: 5px;}

.mb-10 {margin-bottom: 10px;}

.mb-20 {margin-bottom: 20px;}

.text-left {text-align: left;}

.text-center {text-align: center;}

.text-right {text-align: right;}

.float-left {float: left;}

.float-right {float: right;}

.md-sde:before {content: "";border: 1px solid <?php echo $general['color'];?>;position: absolute;width: 100%;border-radius: 8px 8px 0 0;height: 30px;top: 4px;
left: -1px;border-bottom: 0;}

.container {width: 1024px;margin: 0 auto;}

.wrapper {width: 98%;margin: 0 auto;}

.display-inline {display: inline-block;}

.lft-sde {padding: 0 15px;box-sizing: border-box;margin-top: 3px;position: relative;width: 14.8%;vertical-align: top;border-left: 1px solid <?php echo $general['color'];?>;border-bottom: 1px solid <?php echo $general['color'];?>;border-right: 1px solid <?php echo $general['color'];?>;border-radius: 0 0 8px 8px;}

.md-sde {width: 41.8%;vertical-align: top;padding: 20px;box-sizing: border-box;border-radius: 8px;position: relative;word-wrap: break-word;}

.article span {margin-bottom: 5px;}

.rgt-md-sde {position: relative;margin-top: 3px;width: 21.9%;vertical-align: top;padding: 0 15px;box-sizing: border-box;border-radius: 0 0 8px 8px;
border-left: 1px solid <?php echo $general['color'];?>;border-right: 1px solid <?php echo $general['color'];?>;border-bottom: 1px solid <?php echo $general['color'];?>;}

.rgt-sde {margin-top: 4px;width: 20%;vertical-align: top;padding: 0 15px;box-sizing: border-box;}

.rgt-sde img {display: inline-block;width: 100%;}

p {line-height: 19px;}

form input {width: 90%;box-sizing: border-box;border: 1px solid #bbb;}

nav ul li {padding: 5px 0;}

nav ul li a {color: #000;font-weight: 600;width: 100%;display: inline-block;font-size: 14px;}

nav ul li a:hover {color: <?php echo $general['color'];?>;}

nav ul li a.active {color: <?php echo $general['color'];?>;}

hr {color: #d8d8d8;}

.article {padding-top: 10px;padding-bottom: 10px;}

span.speech {position: relative;width: auto;height: 13px;text-align: center;line-height: 14px;background-color: <?php echo $general['color'];?>;
border: 2px solid <?php echo $general['color'];?>;-webkit-border-radius: 30px;-moz-border-radius: 30px;border-radius: 4px;-webkit-box-shadow: 2px 2px 4px #888;
-moz-box-shadow: 2px 2px 4px #888;box-shadow: 2px 2px 4px <?php echo $general['color'];?>;color: #fff;padding: 3px;display: inline-block;font-size: 12px;right: -15px;cursor: pointer;}

span.speech:after {content: "";position: absolute;display: block;width: 0;z-index: 1;border-style: solid;border-color: <?php echo $general['color'];?> transparent;
border-width: 10px 10px 0;bottom: -10px;left: 5px;margin-left: 0;}

.articleimg {margin-top: 10px;border: 3px solid <?php echo $general['color'];?>;max-width: 250px;max-height: 170px;}
.articleimginner {margin-top: 10px;border: 3px solid <?php echo $general['color'];?>;max-width: 98%;}

.removeBorder {position: absolute;left: -6px;top: -85px;background-color: white;width: 12px;}

.spacer {width: 1px;height: 195px;background: #fff;border:0.1px solid #fff;}

footer {width: 100%;}

.footer-container {width: 47.8%;margin-left: 5px;}

.footer-container ul {width:19.9%;display: inline-block}

.footer-container ul li {width: 100%;display: inline-block;padding: 5px 0;font-weight: 600;}

.footer-container ul li a {color: #696969;}

.pagination li {display: inline-block;border-top: 1px solid #979797;border-bottom: 1px solid #979797;border-right: 1px solid #979797;}

.pagination li a {color: #000;}

.pagination li:first-child {border-left: 1px solid #979797;border-radius: 4px 0 0 4px;}

.pagination li:last-child {border-left: 1px solid #979797;border-radius: 0 4px 4px 0;}

.pagination li.active {color: #fff;background: <?php echo $general['color'];?>;border-top: 1px solid <?php echo $general['color'];?>;border-bottom: 1px solid <?php echo $general['color'];?>;border-right: 1px solid <?php echo $general['color'];?>}

.pagination li.active a {color: #fff;}

.pagination li:hover {color: #fff;background: <?php echo $general['color'];?>;border-top: 1px solid <?php echo $general['color'];?>;border-bottom: 1px solid <?php echo $general['color'];?>;border-right: 1px solid <?php echo $general['color'];?>;}

.pagination li:hover a {color: #fff;}

.pagination li a {width: auto;display: inline-block;padding: 5px 10px;}

.md-sde p:first-child {font-weight: 600;color: <?php echo $general['color'];?>;}

.article p {padding: 10px 0;font-weight: 500;color: #070707;font-size: 1.1rem;line-height: 1.4rem;}

.sub-menu li a {font-weight: 500;}

.comments input {padding: 5px;margin: 2.5px 0;color: #000;border: 1px solid <?php echo $general['color'];?>;width: 100%;}

.comments textarea {padding: 5px;margin: 2.5px 0;color: #000;resize: none;border: 1px solid <?php echo $general['color'];?>;width: 94%;font-family: webfontregular;font-size: 0.8rem;}

.comments input[type="button"] {background: <?php echo $general['color'];?>;color: #fff;border-radius: 5px;cursor: pointer;}

.error_message {background: <?php echo $general['color'];?>;color: #fff;padding: 10px;box-sizing: border-box;font-size: 0.8rem;border-radius: 8px;}

.commentBox { padding-top: 10px;}

.commentBox p {font-size: 1.1rem;padding-top: 5px;line-height: 25px;}

.commentBox span { display: inline-block;}

.comments textarea, .comments input {font-size: 14px;border-radius: 4px;}

footer .left-footer { width: 16.9%; display: inline-block; height: 10px;}

footer .mid-footer {display: inline-block;width: 80%;}

::placeholder {font-family: webfontregular;}

.removeBorderright {position: absolute;
    right: -1px;
    top: -189px;
    background-color: #fff;
    border: 0.1px solid #fff;}

.removeBorderfromright {position: absolute;left: -1.2px;top: -191px;background-color: #fff;border: 0px solid #fff;}

.footer-address {width: 78.9%;display: inline-block;vertical-align: top;text-align: right;font-weight: 600;color: #696969;}

.footer-address p {padding: 5px 0;}

.top-footer > .footer-container{border-top:1px solid #979797;color:#696969;font-size: 1rem;}

nav ul li:last-child{padding-bottom: 15px;}

.add_comments{font-size:15px;}

.text-underline {
    text-decoration: underline;
}

.ArticleText img {
    width: 100%;
}

.ArticleText ul {
	padding-left: 15px !important;
}

.ArticleText ul li {
	list-style: unset !important;
}

@media only screen and (min-device-width : 375px) and (max-device-width : 667px) and (orientation : portrait) { 
	
	.container { width:1084px !important; }
	nav ul li a { font-size:19.2px !important; }
	nav ul li { padding:13px 0 12px  !important;}
	nav ul li:last-child {padding-bottom: 20px !important;}
	body {font-size: 1.3rem !important}
	.article p {font-size: 1.3rem !important}
	.add_comments {  font-size: 19px;padding: 10px 0;display: inline-block;}
	.article a { padding-top: 15px !important; display: inline-block;}
}

@media only screen and (min-device-width : 401px) and (max-device-width : 700px) and (orientation : portrait) { 

	.container { width:1174px !important; }
	nav ul li a { font-size:20.5px !important; }
	nav ul li { padding: 13px 0 12px !important;}
	nav ul li:last-child {padding-bottom: 20px !important;}
	body {font-size: 1.3rem !important}
	.article p {font-size: 1.3rem !important}
	.add_comments {  font-size: 19px;padding: 10px 0;display: inline-block;}
	.article a { padding-top: 15px !important; display: inline-block;}
}

@media only screen and (min-device-width : 320px) and (max-device-width : 800px){ 

	nav ul li a { font-size:19.2px !important; }
	body {font-size: 1.3rem !important}
	.article p {font-size: 1.3rem !important}
	nav ul li { padding: 13px 0 12px  !important; }
	.add_comments {  font-size: 19px;}
	
	
}


</style>

</head>
<body>