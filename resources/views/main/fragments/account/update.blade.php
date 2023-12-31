<!-- card start -->
<div class="card">
    <div class="card-header">
        <h4>Configuraciones de la cuenta</h4>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <form action="{{ route('web.app.profile.update.do') }}" class="parent-load form_ prompt">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 pt-2 col-md-4 col-sm-4 col-12">
                            <img src="{{ tools()->photo($user->photo) }}"
                                class="img-fluid rounded-circle nf_picture my-3" alt="Image">
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            <div class="col-12">

                                <button type="button" class="btn btn-primary btn-sm btnpp"><i
                                        class="fa fa-image p-2"></i>Cambiar foto de perfil</button>
                            </div>
                        </div>
                        <div class="col-12 pt-2">

                            <div class="form-group">
                                <label class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" name="code" value="{{ $user->code }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="{{ $user->last_name }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="born_date"
                                    value="{{ $user->born_date }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">
                            <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                            <div class="input-group">
                                <select class="form-control w-25" style="width: 25%" name="idd_country_id">
                                    @foreach ($country as $item)
                                        <option value="{{ $item->id }}"
                                            {{ strtolower($item->code) == (empty($user->idd_country_id) ? 'bo' : strtolower($user->idd_country_code)) ? 'selected' : '' }}>
                                            {{ $item->idd . '     (' . $item->name . ' - ' . $item->native_name . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control w-75" placeholder="" aria-label=""
                                    aria-describedby="basic-addon1" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                            </div>

                        </div>
                        <div class="col-12 col-md-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Carnet de Identidad</label>
                                <input type="text" class="form-control" name="national_id"
                                    value="{{ $user->national_id }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Apellido paterno</label>
                                <input type="text" class="form-control" name="father_name"
                                    value="{{ $user->father_name }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Apellido materno</label>
                                <input type="text" class="form-control" name="mother_name"
                                    value="{{ $user->mother_name }}">
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-4 pt-2">

                            <div class="form-group">
                                <label class="form-label">Pais</label>
                                <select class="form-control" name="country_id">
                                    @foreach ($country as $item)
                                        <option value="{{ $item->id }}"
                                            {{ strtolower($item->code) == (empty($user->country_id) ? 'bo' : strtolower($user->country_code)) ? 'selected' : '' }}>
                                            {{ $item->name . ' (' . $item->native_name . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-12 pt-2">

                            <div class="form-group">
                                <label class="form-label">Direccion</label>
                                <textarea name="address" cols="3" class="form-control">{{ $user->address }}</textarea>
                            </div>

                        </div>
                        <div class="pt-3 col-12">
                            <button class="btn btn-primary mb-3 chl_loader"><i
                                    class="fa fa-save p-2"></i>{{ __('Salvar') }}</button>
                            <button data-href="{{ route('web.app.profile.index') }}"
                                class="btn btn-primary mb-3 _link_"><i class="fa fa-arrow-left p-2"></i>Volver al
                                perfil</button>

                        </div>
                    </div>
                </form>
            </div>

            <div class="col-xl-4 col-lg-4 pt-2 col-md-12 col-sm-12 col-12">
                <div class="account-settings-block">

                    <div class="settings-block">
                        <div class="settings-block-body">
                            <div class="list-group">
                                <div class="list-group-itdm">

                                    <button data-href="{{ route('web.app.profile.password.update.index') }}"
                                        class="btn btn-primary w-100 _link_"><i class="fa fa-key p-2"></i>Cambiar
                                        contraseña</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- card end -->










@include('profile-modal')

<script type="text/javascript">
    $image_crop = $('#_pictureProfileIMG').croppie({
        enableExif: true,
        viewport: {
            width: 350,
            height: 350,
            type: 'square'
        },
        boundary: {
            width: 352,
            height: 352
        }
    });
    //$('#myModal').on('hidden.bs.modal', function() {})


    $('.picbtn').click(
        function() {
            $("#tgProfile_Pic").modal('hide');
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(
                function(response) {
                    var data = new FormData();
                    data.append('foto', response);
                    var url = "{{ route('web.app.profile.change_picture') }}";
                    new request(url)
                        .setData(data)
                        .toNext()
                        .execute();
                });
        });

    $(".btnpp").click(
        function() {
            $("#_picture").click();
            $("#tgProfile_Pic").modal('show');
        });

    $('#_picture').on('change', function() {
        var that = this;
        setTimeout(function() {
            try {

                var reader = new FileReader();
                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {});
                }

                reader.readAsDataURL(that.files[0]);

            } catch (error) {

            }
        }, 500);
    });
</script>
