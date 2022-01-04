<!DOCTYPE html>
<html>
<head>
	<title>Dom PDF Printing Google Charts</title>

	<style>
		@page { size: legal landscape; }
	</style>
</head>
<body>

	<h1>Printing Multiple Charts Using DomPdf In Loop </h1>
	<div align="center">

		@foreach($data as $d)
			{!! $d !!}
		@endforeach

	</div>
</body>
</html>