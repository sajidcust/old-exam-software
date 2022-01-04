<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fee Report {{ $session->title }} - {{ $institution->name }}</title>

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

    @page { size: legal landscape; }

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
<td style="width: 100%; text-align: center;">DETAIL FEE COLLECTION REPORT OF STUDENTS OF <strong>{{ strtoupper($institution->name) }}</strong> - {{ strtoupper($session->title) }}</td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse; width: 95%;" border="1">
<thead>
<tr>
<th style="font-size: 13px;">Roll #</th>
<th style="font-size: 13px;">Name</th>
<th style="font-size: 13px;">Smstr</th>
<th style="font-size: 13px;">Bank</th>
<th style="font-size: 13px;">Challan #</th>
<th style="font-size: 13px;">Date</th>
<th style="font-size: 13px;">Fee Type</th>
<th style="font-size: 13px;">Total Amount (Rs)</th>
</tr>
</thead>
<tbody>
	<?php $grand_total_amount = 0; ?>
	@foreach($students as $student)
		<?php $fee_selections = App\Models\StudentsFeesSelection::join('fees', 'fees.id', '=', 'students_fees_selections.fee_id')->where('students_fees_selections.student_id', $student->id)->where('students_fees_selections.semester_id', $student->semester_id)->get(['fees.id', 'fees.title']); ?>
		<?php $counter = count($fee_selections); ?>
		<tr>
		<td style="font-size: 13px; text-align: center;">{{ $student->id }}</td>
		<td style="font-size: 13px;">{{ $student->name }}</td>
		<td style="font-size: 13px; text-align: center;">{{ $student->semester_id }}</td>
		<td style="font-size: 13px; text-align: center;">{{ $student->bank_name }}</td>
		<td style="font-size: 13px; text-align: center;">{{ $student->challan_no }}</td>
		<td style="font-size: 13px; text-align: center;">{{ $student->date_of_deposit }}</td>
		<?php $i=0; $grand_total_amount+= $student->total_amount; ?>
		<td style="font-size: 13px;">
		@foreach($fee_selections as $selection)
			{{ $selection->title.',' }}
		@endforeach
		</td>
		<td style="font-size: 13px; text-align: center;">{{ $student->total_amount }}</td>
		</tr>
	@endforeach
		<tr>
		<td style="font-size: 13px; text-align: right;" colspan="7"><strong>Grand Total</strong></td>
		<td style="font-size: 13px; text-align: center;"><strong>{{ $grand_total_amount }}</strong></td>
		</tr>
</tbody>
</table>

</body>
</html>