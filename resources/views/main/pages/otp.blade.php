@extends('main.templates.auth')

@section('content')
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-xl-5 col-md-6">
            <div class="mini-logo text-center my-4"><a href="{{ route('web.public.index') }}">
                <img src="{{ url('public/assets/images/logo.png') }}" alt="" height="100px"></a>
            </div>
            <div class="auth-form card">
                <div class="card-body">
                    <div class="d-block text-center">
                        <h3>{{ __("Ativação de conta") }}</h3>
                        <span>{{ __("Para ativar a sua conta, abra sua caixa de entrada do e-mail cadastrado e copie e cole o código de ativação no campo abaixo:") }}</span>
                    </div>
                    <form method="post" action="{{ route('web.account.activation.otp.auth') }}" method="post"
                        class="form_ parent-load">
                        <input type="hidden" name="email" value="{{ $email }}">


                        <div class="form-group">
                            <input type="text" name="otp" class="form-control">
                        </div>


                        <div class="mt-3 d-grid gap-2"><button type="submit"
                                class="btn btn-primary mr-2 chl_loader">{{ __("Confirmar") }}</button></div>
                    </form>
                    </p>
                </div>
            </div>
            <div class="privacy-link d-inline w-100">
                <a class="text-primary p-2" href="{{ route('web.public.index') }}">{{ __("Pagina Inicial") }}</a>
                <a class="text-primary p-2" target="_blank" href="{{ route('web.public.terms.index') }}">{{ __("Termos de Uso") }}</a>
                <a class="text-primary p-2" target="_blank" href="{{ route('web.public.privacy.index') }}">{{ __("Politicas") }}</a>
            </div>
        </div>
    @endsection






    @extends('main.templates.auth', ['page_title' => 'Login'])

@section('content')
    <section class="inner-page">
        <div class="container">

            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-5 col-md-6">
                    <div class="auth-form card">
                        <div class="card-body">

                            <form method="post" action="{{ route('web.account.forgot.auth') }}" method="post"
                                class="form_ parent-load">

                                <div class="form-group">
                                    <label>{{ __('Ingrese seu email') }}</label>
                                    <input type="email" class="form-control" name="email">
                                </div>

                                <div class="mt-3 d-grid gap-2"><button type="submit"
                                        class="btn btn-primary mr-2 chl_loader">{{ __('Enviar') }}</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a class="text-primary p-2" href="{{ route('web.public.index') }}">{{ __('Página Inicial') }}</a>
                        <a class="text-primary p-2"
                            href="{{ route('web.account.signup.index') }}">{{ __('Criar Conta') }}</a>
                        <a class="text-primary p-2" target="_blank"
                            href="{{ route('web.public.terms.index') }}">{{ __('Termos de Uso') }}</a>
                        <a class="text-primary p-2" target="_blank"
                            href="{{ route('web.public.privacy.index') }}">{{ __('Políticas') }}</a>
                    </div>
                </div>


            </div>
    </section>
@endsection
