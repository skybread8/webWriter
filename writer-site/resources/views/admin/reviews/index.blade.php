@extends('layouts.admin')

@section('title', 'Reseñas')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-100">Reseñas de libros</h1>
                <p class="text-zinc-400 mt-1">Gestiona las reseñas que los clientes han dejado en los libros</p>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-600/40 bg-emerald-900/40 text-emerald-100 px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-zinc-900 rounded-lg p-4 border border-zinc-800">
                <p class="text-sm text-zinc-400 mb-1">Total de reseñas</p>
                <p class="text-2xl font-bold text-zinc-100">{{ $reviews->count() }}</p>
            </div>
            <div class="bg-amber-900/20 border border-amber-800/50 rounded-lg p-4">
                <p class="text-sm text-zinc-400 mb-1">Pendientes de aprobación</p>
                <p class="text-2xl font-bold text-amber-400">{{ $pendingCount }}</p>
            </div>
            <div class="bg-emerald-900/20 border border-emerald-800/50 rounded-lg p-4">
                <p class="text-sm text-zinc-400 mb-1">Aprobadas</p>
                <p class="text-2xl font-bold text-emerald-400">{{ $approvedCount }}</p>
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="bg-zinc-900 rounded-lg p-8 text-center border border-zinc-800">
                <p class="text-zinc-400">Aún no hay reseñas.</p>
            </div>
        @else
            <div class="bg-zinc-900 rounded-lg border border-zinc-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-800/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Libro</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Usuario</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Valoración</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Comentario</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">Fecha</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800">
                            @foreach($reviews as $review)
                                <tr class="hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-medium text-zinc-100">{{ $review->book->title }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm text-zinc-300">{{ $review->user->name }}</p>
                                        <p class="text-xs text-zinc-500">{{ $review->user->email }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 10; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="w-4 h-4 text-amber-400 fill-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-zinc-700 fill-zinc-700" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="ml-2 text-xs text-zinc-400">{{ $review->rating }}/10</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($review->comment)
                                            <p class="text-sm text-zinc-300 line-clamp-2 max-w-xs">{{ Str::limit($review->comment, 100) }}</p>
                                        @else
                                            <span class="text-xs text-zinc-500">Sin comentario</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($review->approved)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-900/40 text-emerald-300 border border-emerald-800/50">
                                                Aprobada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-900/40 text-amber-300 border border-amber-800/50">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-xs text-zinc-400">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if(!$review->approved)
                                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-emerald-300 bg-emerald-900/20 border border-emerald-800/50 rounded-lg hover:bg-emerald-900/40 transition-colors">
                                                        Aprobar
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-amber-300 bg-amber-900/20 border border-amber-800/50 rounded-lg hover:bg-amber-900/40 transition-colors">
                                                        Rechazar
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('¿Seguro que quieres eliminar esta reseña?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-300 bg-red-900/20 border border-red-800/50 rounded-lg hover:bg-red-900/40 transition-colors">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
