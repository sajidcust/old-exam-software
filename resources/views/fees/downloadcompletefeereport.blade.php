<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Complete Fee Report {{ $session->title }} }}</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: 15px;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: 15px;
    }
    h1{
      font-family: Verdana;
    }

    .gray {
        background-color: lightgray
    }
    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 0cm;
    }

    @page { size: a4 portrait; }

    table.GeneratedTable {
      width: 100%;
      background-color: #ffffff;
      border-collapse: collapse;
      border-width: 1px;
      border-color: #000000;
      border-style: solid;
      color: #000000;
    }

    table.GeneratedTable td, table.GeneratedTable th {
      border-width: 1px;
      border-color: #000000;
      border-style: solid;
      padding: 3px;
    }

    table.GeneratedTable thead {
      background-color: #ffffff;
    }

    .page_break { page-break-before: always; }
</style>

</head>
<body>

<table style="margin-bottom: 10px; padding: 10px; border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 100%; text-align: center;">COMPLETE FEE COLLECTION REPORT FOR - <strong>{{ strtoupper($session->title) }}</strong></td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse; width: 95%;" border="1">
<thead>
<tr>
<th style="font-size: 13px;">S. No</th>
<th style="font-size: 13px;">Code</th>
<th style="font-size: 13px;">Name</th>
<th style="font-size: 13px;">Total Amount (Rs)</th>
</tr>
</thead>
<tbody>
	<?php $grand_total_amount = 0; ?>
  <?php $i=1; ?>
	@foreach($institutions as $institution)
		<tr>
		<td style="font-size: 13px; text-align: center;">{{ $i }}</td>
		<td style="font-size: 13px;text-align: center;">{{ $institution->id }}</td>
		<td style="font-size: 13px;">{{ $institution->name }}</td>
		<td style="font-size: 13px; text-align: center;">{{ $institution->total_amount }}</td>
		</tr>
    <?php $i++; $grand_total_amount += $institution->total_amount; ?>
	@endforeach
		<tr>
		<td style="font-size: 13px; text-align: right;" colspan="3"><strong>Grand Total</strong></td>
		<td style="font-size: 13px; text-align: center;"><strong>{{ $grand_total_amount }}</strong></td>
		</tr>
</tbody>
</table>

</body>
</html>