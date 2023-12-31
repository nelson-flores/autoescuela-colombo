<div class="card">

    <div class="card-body">
        <span class="header-title text-end w-100 d-block">{{ __('Responder Examen') }}</span>
        <div class="alert alert-dark">
            <h6 class="header-title">{{ $survey->name }}</h6>
            <p>{{ $survey->description }}</p>
        </div>

        <form action="{{ route('web.app.survey.survey_answer.add.do') }}" class="form_ parent-load row" method="post">
            <input type="hidden" name="survey_id" value="{{ $survey->id }}">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">{{ __('Tag') }}</label>
                <input type="text" name="tag" id="name" class="form-control" value="#{{ $count+1 }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="city_id" class="form-label">{{ __('Ciudad') }}</label>
                <select name="city_id" class="form-control">
                    @foreach ($city as $item)
                        <option value="{{ $item->id }}">{{ $item->name.' |'.$item->country_name  }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <hr>
            </div>
            @foreach ($data as $item)
                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">{{ __($item->name) }}</label>
                    <input type="{{ $item->data_type }}" name="data[{{ $item->id }}]" class="form-control" value="">
                </div>
            @endforeach

            <div class="col-12">
                <hr>
            </div>


            @php
                $nr = 1;
            @endphp
            @foreach ($question as $item)
                <div class="col-md-12 mb-3">
                    <label class="form-label d-block">{{ $nr }}. {{ $item->question }}</label>

                    @switch($item->question_type)
                    @case('single-choice-radio')
                        <div class="form-group mb-3">

                            @foreach ($option as $q)
                                @php
                                    if ($q->survey_question_id !== $item->id) {
                                        continue;
                                    }
                                @endphp
                                <span class="d-inline m-1"><input type="radio" name="question[{{ $item->id }}]" value="{{$q->option_}}">
                                    {{ $q->option_ }}</span>
                            @endforeach
                        </div>
                    @break
                    @case('multiple-choice')
                        <div class="form-group mb-3">

                            @foreach ($option as $q)
                                @php
                                    if ($q->survey_question_id !== $item->id) {
                                        continue;
                                    }
                                @endphp
                                <span class="d-inline m-1"><input type="checkbox" name="question[{{ $item->id }}]" value="{{$q->option_}}">
                                    {{ $q->option_ }}</span>
                            @endforeach
                        </div>
                    @break

                    @case('open-ended-single')
                    <div class="form-group mb-3">
                        <textarea class="form-control" cols="30" name="question[{{ $item->id }}]"></textarea>
                    </div>
                    @break

                        @default
                            <div class="form-group mb-3">
                                <textarea class="form-control" cols="30" name="question[{{ $item->id }}]"></textarea>
                            </div>
                    @endswitch

                    <div>
                        @php
                            $nr++;
                        @endphp
            @endforeach

            <button type="submit" class="btn btn-primary chl_loader"><i
                    class="fa fa-paper-plane p-1"></i>{{ __('enviar') }}</button>
        </form>

    </div> <!-- end card-body -->
</div>
