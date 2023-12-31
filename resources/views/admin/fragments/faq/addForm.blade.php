<div class="card">

    <div class="card-body">
        <h4 class="header-title">{{ __('Registro de Preguntas frecuentes') }}</h4>

        <form action="{{ route('web.admin.settings.faq.add.do') }}" class="form_ parent-load row" method="post">

            <div class="col-md-6 mb-3">
                <label for="language_id" class="form-label">{{ __('Idioma') }}</label>
                <select name="language_id" class="form-control">
                    @foreach ($language as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">{{ __('Pregunta') }}</label>
                <input type="text" name="title" id="title" class="form-control"
                    placeholder="{{ __('Digite a pregunta...') }}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="title" class="form-label">{{ __('Respuesta') }}</label>
                <textarea name="description" class="form-control textarea" rows="10"></textarea>
            </div>


            <div class="col-12 pr-5">
                <button type="submit" class="btn btn-primary chl_loader"><i
                        class="fa fa-save p-1"></i>{{ __('Salvar') }}</button>
            </div>
        </form>

    </div> <!-- end card-body -->
</div>
