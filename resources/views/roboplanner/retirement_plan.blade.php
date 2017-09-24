<div class="row">
    <div class="col-md-12">
        <h3 class="results-heading">Retirement Plan</h3>
    </div>
</div>

<div class="chart-container">
    <div class="row">
        <div class="col-md-12">
            <div id="chart-container-income" class="chart-item"></div>
        </div>
    </div>

    <br/>
    <br/>


    <div class="row">
        <div class="col-md-12">
            <div class="wrapper1">
                <div class="div1"></div>
            </div>
            <div class="wrapper2">
                <div class="div2" id="ïllustrative_plan">

                    <table class="table" id="ill_plan">
                        <thead>
                            <tr>
                                @foreach($retirement_columns as $key => $column)
                                    <?php 
                                        $prev = isset($retirement_columns[$key-1]) && $column['name'] == $retirement_columns[$key-1]['name'] && $column['owner'] == $retirement_columns[$key-1]['owner'];  
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
                                @foreach($retirement_columns as $key => $column)
                                    <?php 
                                        $prev = isset($retirement_columns[$key-1]) && ($column['name'] == $retirement_columns[$key-1]['name']) && ($column['owner'] == $retirement_columns[$key-1]['owner']);  
                                        $next = isset($retirement_columns[$key+1]) && ($column['name'] == $retirement_columns[$key+1]['name']) && ($column['owner'] == $retirement_columns[$key+1]['owner']);  
                                    ?>
                                    @if($next && !$prev)
                                        <th>{{ $column["field"] }}</th>
                                        <th>{{ $retirement_columns[$key+1]["field"] }}</th>
                                    @elseif(!$next && !$prev)
                                        <th colspan=2>{{ $column["field"] or $column["owner"]." ".$column["name"] }}</th>
                                    @endif  
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($retirement_table as $row)
                                <tr 
                                    @if($row["Client"]["Age"] == $retirement_age) class="retired" @endif 
                                    @if($row["Client"]["Age"] == $life_expectancy) class="life_exectancy_own" @endif 
                                    @if($row["Client"]["Age"] == $life_expectancy) class="life_exectancy_spouse" @endif 
                                >
                                    @foreach($retirement_columns as $column)
                                        @if(isset($column["owner"]) && isset($row[$column["owner"]]))
                                            @if(isset($column["field"]))
                                                <td>
                                                    {{ $row[$column["owner"]][$column["name"]][$column["field"]] }}
                                                </td>   
                                            @else
                                                <td colspan=2>
                                                    {{ $row[$column["owner"]][$column["name"]] }}
                                                </td>
                                            @endif
                                        @elseif(isset($row[$column["name"]]))
                                                @if(isset($column["field"]))
                                                    <td>
                                                        {{ $row[$column["name"]][$column["field"]] }}
                                                    </td>
                                                @else
                                                    <td colspan=2>
                                                        {{ $row[$column["name"]] }}
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
                </div>
            </div>
        </div>
    </div>
</div>


