<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WeContr自媒体内容管理系统 - WxCMS</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
        
    </head>
    <body>
		<section class="container" style="padding-top:50px;" >
			<h3 class="title">WeContr</h3>
			<p class="description">小程序代码提交成功，请扫描下方二维码进行体验。</p>
			


			<p> 体验小程序 <br> <img style="width:180px;" src="{{qrcode}}" /> </p>

			
			<a class="button" href="/admin" >提交审核</a>
			<p class="description">提交审核后，由微信官方团队进行审核，审核通过后可进行发布。</p>

			<p>
				如有疑问，请咨询客服QQ：121258121(在线时间9:00~23:00)
			</p>
		</section>
    </body>
</html>