<div class="card">

    <div class="card-body">
        <h4 class="header-title">{{ __('Editar Pais') }}</h4>

        <form action="{{ route('web.app.survey.survey_answer.update.do') }}" class="form_ parent-load row" method="post">
            <input type="hidden" name="id" value="{{ $survey_answer->id }}">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" name="name" required id="name" class="form-control" value="{{  $survey_answer->name }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="code" class="form-label">{{ __('Codigo') }}</label>
                <input type="text" name="code" id="code" class="form-control" value="{{  $survey_answer->code }}">
            </div>


<div class="col-md-12">
    <button type="submit" class="btn btn-primary chl_loader"><i class="fa fa-save p-1"></i>{{ __('salvar') }}</button>
</div>
        </form>

    </div> <!-- end card-body -->
</div>
