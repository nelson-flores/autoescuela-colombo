<div class="card">

    <div class="card-body">
        <h4 class="header-title">{{ __('Editar Grupo de Usuarios') }}</h4>

        <form action="{{ route('web.admin.user.role.update.do') }}" class="form_ --parent-load row" method="post">
            <input type="hidden" name="id" value="{{ $role->id }}">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">{{ __('Nome') }}</label>
                <input type="text" name="name" required id="name" class="form-control" value="{{  $role->name }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="code" class="form-label">{{ __('Codigo') }}</label>
                <input type="text" name="code" id="code" class="form-control" value="{{  $role->code }}">
            </div>


            <div class="col-12 mb-3">
                <label for="">{{ __('Descricao') }}</label>
                <textarea rows="5" class="w-100 form-control" name="description">{!! $role->description !!}</textarea>
            </div>
<div class="col-md-12">
    <button type="submit" class="btn btn-primary  --chl_loader"><i class="fa fa-save p-1"></i>{{ __('guardar') }}</button>
</div>
        </form>

    </div> <!-- end card-body -->
</div>
