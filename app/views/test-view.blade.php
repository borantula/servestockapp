<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>

</head>
<body>

<ul>
	<li style="list-style: none;float:left;">
		@for($i = 0;$i < 10;$i++)
			<img src="<?=url('/');?>/test/125/125?t=<?=mt_rand(0,12300);?>" />
		@endfor
	</li>
</ul>

</body>
</html>
