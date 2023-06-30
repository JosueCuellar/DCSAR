@if ($errors->any())
    <div {{ $attributes }} class="bg-white sm:rounded-lg">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">
                {{ __('Whoops! Parece que algo salio mal.') }}
                !</h4>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        // Selecciona el elemento que quieres ocultar
        const elemento = document.querySelector('.alert.alert-danger');
        // Establece un tiempo de espera en milisegundos
        const tiempoDeEspera = 4000; // 3 segundos
        // Usa setTimeout para ejecutar una función después del tiempo de espera
        setTimeout(() => {
            // Oculta el elemento
            elemento.style.display = 'none';
        }, tiempoDeEspera);
    </script>
@endif
