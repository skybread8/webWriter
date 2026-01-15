@extends('layouts.site')

@section('title', 'Compra completada')

@section('content')
    <section class="px-5 sm:px-8 py-14 sm:py-20 max-w-3xl mx-auto text-center space-y-6">
        <p class="text-[11px] tracking-[0.3em] uppercase text-emerald-400">
            Pago confirmado
        </p>
        <h1 class="font-['DM_Serif_Display'] text-3xl sm:text-4xl tracking-tight">
            Gracias por tu compra
        </h1>
        <p class="text-sm text-zinc-300 max-w-xl mx-auto">
            El pago se ha completado correctamente mediante Stripe. Si el libro incluye material digital, recibirás los detalles por correo electrónico.
        </p>
        <div class="pt-2 flex justify-center gap-3">
            <a href="{{ route('books.index.public') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-zinc-100 text-zinc-950 text-[11px] font-semibold tracking-[0.25em] uppercase hover:bg-white transition">
                Volver a los libros
            </a>
            <a href="{{ route('home') }}" class="text-[11px] tracking-[0.25em] uppercase text-zinc-400 hover:text-zinc-100">
                Ir a inicio
            </a>
        </div>
    </section>
@endsection

