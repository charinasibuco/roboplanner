<div class="row">
    <div class="col-md-12">
        <h3 class="results-heading">Action Steps</h3>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                @foreach($wealth_scores as $key => $wealth_score)
                    <li class="@if($key == 0)active @endif chart-title {{ $wealth_score }}-flag-title">
                        <a data-toggle="tab" href="#menu{{ $key }}">
                            <span class="chart-title {{ $wealth_score }}-flag-title">
                                {{ $wealth_score }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($wealth_scores as $key => $wealth_score)
                    <div id="menu{{ $key }}" class="tab-pane fade @if($key == 0)in active @endif">
                        <br/>
                        <div class="flag-panel panel-group {{ $wealth_score }}-panel" id="bs-collapse">
                            @foreach($colors as $key => $color)
                                <span class="chart-title {{ strtolower($color) }}-flag-title">
                                    <i class="fa fa-flag fa-lg"></i>&nbsp; {{ $color }} Flags
                                </span>
                                <br/><br/>
                                <table class="table table-hover expandable-table" width="100%">
                                    <thead>
                                    <tr class="panel-title {{ strtolower($color) }}-flag">
                                        <th width="10%">Rank</th>
                                        <th width="85%">Description</th>
                                        <th width="5%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flags as $key => $row ) @if(($row->color == $color) && ($row->wealth_score == $wealth_score))
                                            <tr class="@if($color == 'Red') danger @elseif($color=='Yellow') warning @endif flag-main">
                                                <td>#{{ $row->range }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td class="caret-column"><i class="fa fa-lg fa-caret-down" aria-hidden="true"></i></td>
                                            </tr>
                                            <tr class="flag-consequences">
                                                <td colspan="3" style="padding: 0">
                                                    <ul class="list-group" style="margin: 0; border-radius: 0 0 0 0; box-shadow: 0 0 0 0">
                                                        <li href="javascript:void(0)" class="list-group-item">
                                                            <strong>Consequences:</strong>
                                                        </li>
                                                        @if($row->consequences)
                                                            @foreach($row->consequences as $consequence)
                                                                <li href="javascript:void(0)" class="list-group-item">
                                                                    <div class="consequence-list-item">{{ $consequence }}</div>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>




