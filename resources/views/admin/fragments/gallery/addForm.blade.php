<div class="card">

    <div class="card-body">
        <h4 class="header-title">{{ __('Cargar fotos') }}</h4>

        <div id="dropzone">
            <form action="{{ route('web.admin.page.gallery.add.do') }}" class="dropzone needsclick dz-clickable"
                id="photo-upload-form">

                <div class="dz-message needsclick">
                    <button type="button" class="dz-button">Suelte los archivos aquí o haga clic para cargarlos.</button>
                </div>

            </form>
            <div class="mt-3">
                <button type="submit" class="sb btn btn-primary chl_loader"><i
                        class="fa fa-upload p-1"></i>{{ __('Enviar') }}</button>
            </div>
        </div>

    </div> <!-- end card-body -->
</div>


<script>
    var dz;
    $(function() {
        dz = new Dropzone("#photo-upload-form", {
            addRemoveLinks: true,
            uploadMultiple: true,
            autoProcessQueue: false
        });

        $(".sb").click(function() {
            var form = new FormData();
            for (const i in dz.files) {
                if (Object.hasOwnProperty.call(dz.files, i)) {
                    const file = dz.files[i];
                    form.append('attach[]', file);
                }
            }
            var that = this;
            var inner = $(that).html();
            $(that).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>');


            new request($("#photo-upload-form").attr('action'))
                .setData(form)
                .toNext()
                .execute(function() {
                    $(that).html(inner);
                });
        });




    });
</script>
