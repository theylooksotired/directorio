<!DOCTYPE html>
<html lang="<?php echo Lang::active();?>">
<head>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo $metaDescription;?>"/>
    <meta name="keywords" content="<?php echo $metaKeywords;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php echo Params::param('metainfo-google-webmasters');?>

    <meta property="og:title" content="<?php echo $title;?>" />
    <meta property="og:description" content="<?php echo $metaDescription;?>" />
    <meta property="og:url" content="<?php echo $metaUrl;?>" />
    <?php echo $metaImage;?>

	<meta name="theme-color" content="#FFA12C">
	<meta name="msapplication-navbutton-color" content="#FFA12C">
	<meta name="apple-mobile-web-app-status-bar-style" content="#FFA12C">

    <link rel="shortcut icon" href="<?php echo BASE_URL;?>visual/img/favicon.ico"/>
    <link rel="canonical" href="<?php echo $metaUrl;?>" />

    <title><?php echo $title;?></title>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css' />
    <link href="<?php echo BASE_URL;?>visual/css/stylesheets/public.css?v=14" rel="stylesheet" type="text/css" />

    <?php echo Navigation_Ui::analytics();?>
    <?php echo $header;?>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <?php echo method_exists($control, 'adsenseFullPage') ? $control->adsenseFullPage() : ''; ?>

</head>
<body>

    <?php echo $content;?>

</body>
</html>
