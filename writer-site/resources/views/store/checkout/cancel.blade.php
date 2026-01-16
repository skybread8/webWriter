@extends('layouts.site')

@section('title', 'Pago cancelado')

@section('content')
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-3xl mx-auto text-center space-y-6">
        <p class="text-[11px] tracking-[0.3em] uppercase text-zinc-400">
            Pago cancelado
        </p>
        <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl tracking-tight">
            El pago se ha detenido
        </h1>
        <p class="text-sm text-zinc-300 max-w-xl mx-auto">
            No se ha realizado ningún cargo. Puedes volver a intentar la compra cuando quieras o seguir leyendo otros libros.
        </p>
        <div class="pt-2 flex justify-center gap-3">
            <a href="{{ localized_route('books.index.public') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-[11px] font-semibold tracking-[0.25em] uppercase hover:bg-white transition">
                Volver a los libros
            </a>
            <a href="{{ localized_route('home') }}" class="text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100">
                Ir a inicio
            </a>
        </div>
    </section>
@endsection

