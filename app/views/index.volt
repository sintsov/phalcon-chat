<!DOCTYPE html>
<html class="no-js loading" lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=IE10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta charset="utf-8">
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <title>Phalcon-Chat</title>
    {{ stylesheet_link("https://fonts.googleapis.com/css?family=Open+Sans:700,400,300", false) }}
    {{ stylesheet_link("css/bootstrap.min.css") }}
    {{ stylesheet_link("css/styles.css") }}
</head>
<body>

{{ content() }}

{{ javascript_include("js/jquery-1.11.1.min.js") }}
{{ javascript_include("js/bootstrap.min.js") }}
{{ javascript_include("js/utils.js") }}
{{ javascript_include("js/chat.js") }}

</body>
</html>