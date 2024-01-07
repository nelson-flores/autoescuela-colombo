<div class="card">

    <div class="card-body">
        <h4 class="header-title">{{ __('Registro de Usuario') }}</h4>

        <form action="{{ route('web.app.question.category.update.do') }}" class="form_ parent-load row" method="post">
            <input type="hidden" name="id" value="{{ $question_category->id }}">

            <div class="col-md-12 mb-3">
                <label for="name" class="form-label">{{ __('Correo') }}</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ $question_category->name }}">
            </div>


            <div class="col-12 pt-2">
                <button type="submit" class="btn btn-secondary  chl_loader"><i
                        class="fa fa-save p-1"></i>{{ __('Salvar') }}</button>
            </div>

        </form>

    </div> <!-- end card-body -->
</div>
