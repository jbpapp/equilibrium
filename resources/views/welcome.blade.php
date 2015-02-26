<html>
	<head>
		<title>Equilibrium</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100,400' rel='stylesheet' type='text/css'>
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 400;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: top;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title, .subtitle {
				font-size: 96px;
				margin-bottom: 40px;
                font-weight: 100;
			}
            .subtitle {
                margin-top: 40px;
                margin-bottom: 20px;
                font-size: 24px;
            }

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Equilibrium</div>
                @if (isset($msg))
                    <p>{{ $msg }}</p>
                @elseif ($index)
                    <div class="subtitle">Filtered array:</div>
                    <?php print_r($array); ?>
                    <div class="subtitle">Separator index:</div>
                    {{ $index }}
                    <div class="subtitle">Arrays</div>
                    <?php print_r($eqArrays); ?>
                @else
                    <p>The array doesn't have any equilibrium index.</p>
                @endif

			</div>
		</div>
	</body>
</html>
