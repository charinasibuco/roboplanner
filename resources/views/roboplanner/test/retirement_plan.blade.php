<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<a href="{{ route('dashboard_show',$id) }}"> Go Back </a>
		<table style="overflow: scroll;overflow: auto;width: 250%;">	
			<thead>
				<tr>
					@foreach($columns as $key => $column)
						<?php 
							$prev = isset($columns[$key-1]) && $column['name'] == $columns[$key-1]['name'] && $column['owner'] == $columns[$key-1]['owner'];  
						?>
						@if(!$prev && isset($column["field"]))
							<th colspan=2>{{ $column["owner"] }} {{ $column["name"] }}</th>
						@elseif(!$prev)
							<th colspan=2></th>
						@endif
					@endforeach
				</tr>
			</thead>
			<thead>
				<tr>
					@foreach($columns as $key => $column)
						<?php 
							$prev = isset($columns[$key-1]) && ($column['name'] == $columns[$key-1]['name']) && ($column['owner'] == $columns[$key-1]['owner']);  
							$next = isset($columns[$key+1]) && ($column['name'] == $columns[$key+1]['name']) && ($column['owner'] == $columns[$key+1]['owner']);  
						?>
						@if($next && !$prev)
							<th>{{ $column["field"] }}</th>
							<th>{{ $columns[$key+1]["field"] }}</th>
						@elseif(!$next && !$prev)
							<th colspan=2>{{ $column["field"] or $column["owner"]." ".$column["name"] }}</th>
						@endif	
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($plan as $row)
					<tr>
						@foreach($columns as $column)
							@if(isset($column["owner"]) && isset($row[$column["owner"]]))
								@if(isset($column["field"]))
									<td>
										{{ round($row[$column["owner"]][$column["name"]][$column["field"]]) }}
									</td>	
								@else
									<td colspan=2>
										{{ round($row[$column["owner"]][$column["name"]]) }}
									</td>
								@endif
							@elseif(isset($row[$column["name"]]))
									@if(isset($column["field"]))
										<td>
											{{ round($row[$column["name"]][$column["field"]]) }}
										</td>
									@else
										<td colspan=2>
											{{ round($row[$column["name"]]) }}
										</td>
									@endif
								</td>
							@else
								<td colspan=2></td>
							@endif
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	</body>
</html>
