<div class="row">
    <div class="col-md-12">
        <h3 class="results-heading">Wealth Score</h3>
    </div>
</div>
<div class="grid">
    @foreach($scores as $score)
        <div class="grid-item">
            <div class="test-circle"><input type="hidden" value="{{ $score->result }}"></div>
            {{-- scores ---}}
            <h4 class="chart-title">{{ $score->name }}</h4>
            <div class="panel-group wrap {{ $score->name }}-panel" id="accordion">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent=".{{ $score->name }}-panel" href="#{{ $score->name }}-one">
                                <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i> Why did I get this score?
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $score->name }}-one" class="panel-collapse collapse">
                        <div class="list-group">
                            @if(count($score->why_did_i_get_this_score) > 0)
                                @foreach($score->why_did_i_get_this_score as $row)
                                    <a href="javascript:void(0)" class="list-group-item">
                                        <div class="wealth-score-results">
                                            {{ $row }}
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="wealth-score-results" style="font-style: italic">
                                        No comments found.
                                    </div>
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
                <!-- end of panel -->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent=".{{ $score->name }}-panel" href="#{{ $score->name }}-two">
                                <i class="fa fa-arrow-up fa-fw" aria-hidden="true"></i>What can I do to improve?
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $score->name }}-two" class="panel-collapse collapse">
                        <div class="list-group">
                            @if(count($score->what_can_i_do_to_improve) > 0)
                            @foreach($score->what_can_i_do_to_improve as $row)
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="wealth-score-results">
                                        {{ $row }}
                                    </div>
                                </a>
                            @endforeach
                            @else
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="wealth-score-results" style="font-style: italic">
                                        No comments found.
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- end of panel -->
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent=".{{ $score->name }}-panel" href="#{{ $score->name }}-three">
                                <i class="fa fa-flag fa-fw"></i> Flags
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $score->name }}-three" class="panel-collapse collapse">
                        <div class="list-group">
                            @if(isset($score->flags) && count($score->flags) > 0)
                                @foreach($score->flags as $flag)
                                    <a href="javascript:void(0)" class="list-group-item @if($flag->color=="Red") list-group-item-danger @else list-group-item-warning @endif">
                                        <div class="flag-content">
                                            <div class="flag-content-left">
                                                <i class="fa fa-flag fa-lg"></i>
                                            </div>
                                            <div class="flag-content-right">
                                                {{ $flag->description }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-thumbs-up fa-lg"></i>
                                        </div>
                                        <div class="flag-content-right" style="font-style: italic">
                                            No flags found.
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- end of panel -->
            </div>
            <!-- end of #bs-collapse  -->
        </div>
    @endforeach
</div>