@extends('layouts.customer')

@section('title', 'Jelajah Barbershop')

@section('content')
@php
    use Illuminate\Support\Str;

    $now = now('Asia/Jakarta')->format('H:i:s');

    // Foto hanya dipakai kalau berupa URL / path valid, selain itu tampil placeholder
    $photoUrl = function ($photo) {
        if (! $photo) return null;
        if (Str::startsWith($photo, ['http://', 'https://', '/'])) return $photo;
        if (Str::startsWith($photo, ['storage/', 'images/'])) return asset($photo);
        return null;
    };

    $isOpen = fn ($s) => $s->open_time && $s->close_time && $now >= $s->open_time && $now <= $s->close_time;
@endphp

<div class="mx-auto max-w-7xl px-4 pb-6 pt-8 sm:px-6 lg:px-8">

    {{-- JUDUL --}}
    <nav class="text-xs text-zinc-500">
        Beranda <span class="mx-1">›</span>
        <span class="font-semibold text-zinc-900">Jelajah Barbershop</span>
    </nav>

    <div class="mt-4 flex flex-wrap items-end justify-between gap-4">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Temukan Barbershop Terbaik</h1>
        <span class="rounded-full bg-zinc-950 px-5 py-2.5 text-xs font-bold text-white">☷ Daftar Katalog</span>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[272px_minmax(0,1fr)]">

        {{-- ============ FILTER ============ --}}
        <aside class="h-fit rounded-3xl bg-white p-6 shadow-sm lg:sticky lg:top-24">
            <form action="{{ route('shops.explore') }}" method="GET" class="space-y-6">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-bold">☷ Filter Pencarian</h2>
                    <a href="{{ route('shops.explore') }}" class="text-xs font-semibold text-zinc-400 hover:text-zinc-700">Reset Filter</a>
                </div>

                {{-- Buka sekarang --}}
                <label class="flex cursor-pointer items-center justify-between rounded-2xl bg-zinc-100 px-4 py-3">
                    <span class="flex items-center gap-2 text-xs font-semibold">
                        <span class="size-2 rounded-full bg-amber-500"></span> Buka Sekarang Saja
                    </span>
                    <input type="checkbox" name="open_now" value="1" class="peer sr-only" @checked(request('open_now'))>
                    <span class="relative h-6 w-11 rounded-full bg-zinc-300 transition peer-checked:bg-zinc-950
                                 after:absolute after:left-0.5 after:top-0.5 after:size-5 after:rounded-full after:bg-white after:transition
                                 peer-checked:after:translate-x-5"></span>
                </label>

                {{-- Lokasi --}}
                <div>
                    <label class="mb-2 block text-xs font-semibold text-zinc-500">Lokasi</label>
                    <select name="city" class="h-10 w-full rounded-xl border border-zinc-200 bg-white px-3 text-sm outline-none focus:border-zinc-950">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div x-data>
                    <div class="mb-2 flex items-center justify-between text-xs font-semibold text-zinc-500">
                        <span>Rentang Harga</span>
                        <span id="price-label" class="text-amber-700">
                            Maks. Rp {{ number_format((float) request('max_price', 180000), 0, ',', '.') }}
                        </span>
                    </div>
                    <input type="range" name="max_price" min="35000" max="250000" step="5000"
                           value="{{ request('max_price', 180000) }}"
                           oninput="document.getElementById('price-label').textContent='Maks. Rp '+Number(this.value).toLocaleString('id-ID')"
                           class="h-1.5 w-full cursor-pointer appearance-none rounded-full bg-zinc-200 accent-zinc-950">
                    <div class="mt-1 flex justify-between text-[11px] text-zinc-500">
                        <span>Rp 35 rb</span><span>Rp 250 rb</span>
                    </div>
                </div>

                {{-- Rating --}}
                <div>
                    <p class="mb-3 text-xs font-semibold text-zinc-500">Rating Bintang</p>
                    <div class="space-y-2.5 text-sm">
                        @foreach(['4.5' => '4.5 ke atas (Terbaik)', '4' => '4.0 ke atas', '' => 'Semua Rating'] as $val => $label)
                            <label class="flex cursor-pointer items-center gap-2.5">
                                <input type="radio" name="rating" value="{{ $val }}" class="size-4 accent-zinc-950"
                                       @checked((string) request('rating', '') === (string) $val)>
                                @if($val !== '') <span class="text-amber-500">★</span> @endif
                                <span class="text-[13px]">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit"
                        class="h-12 w-full rounded-full bg-zinc-950 text-sm font-bold text-white transition hover:bg-zinc-800">
                    Terapkan Filter
                </button>
            </form>
        </aside>

        {{-- ============ HASIL ============ --}}
        <section class="min-w-0 space-y-5">

            {{-- Pencarian aktif --}}
            <div class="flex flex-wrap items-center gap-2 rounded-2xl bg-white px-5 py-4 text-xs shadow-sm">
                <span class="text-zinc-500">Pencarian aktif:</span>

                @if(request('search'))
                    <span class="rounded-full bg-zinc-100 px-3 py-1.5 font-semibold">“{{ request('search') }}”</span>
                @endif
                @if(request('city'))
                    <span class="rounded-full bg-zinc-100 px-3 py-1.5 font-semibold">Wilayah: {{ request('city') }}</span>
                @endif
                @if(request('open_now'))
                    <span class="rounded-full bg-amber-100 px-3 py-1.5 font-semibold text-amber-800">Buka Sekarang</span>
                @endif
                @if(request('max_price'))
                    <span class="rounded-full bg-amber-100 px-3 py-1.5 font-semibold text-amber-800">Maks. Rp {{ number_format((float) request('max_price'), 0, ',', '.') }}</span>
                @endif
                @if(request('rating'))
                    <span class="rounded-full bg-amber-100 px-3 py-1.5 font-semibold text-amber-800">Rating {{ request('rating') }}+</span>
                @endif
                @if(! request()->hasAny(['search','city','open_now','max_price','rating']))
                    <span class="text-zinc-400">Semua barbershop</span>
                @endif
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                @forelse($shops as $shop)
                    @php
                        $img     = $photoUrl($shop->photo);
                        $open    = $isOpen($shop);
                        $service = $shop->services->first();
                        $minPrice = $shop->services->min('price');
                        $rating  = $shop->reviews_avg_rating ?? null;
                        $reviews = $shop->reviews_count ?? 0;
                        $wide    = $loop->index < 2;
                        $place   = collect([$shop->location?->city, $shop->location?->province])->filter()->implode(', ');
                    @endphp

                    @if($wide)
                    {{-- KARTU LEBAR (2 teratas) --}}
                    <article class="grid gap-5 rounded-3xl bg-white p-4 shadow-sm md:col-span-2 md:grid-cols-[260px_minmax(0,1fr)]">
                        <div class="relative h-56 overflow-hidden rounded-2xl bg-zinc-950 md:h-full md:min-h-[260px]">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $shop->barbershop_name }}" class="absolute inset-0 size-full object-cover">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
                                    <span class="text-5xl">💈</span>
                                    <span class="mt-2 text-lg font-extrabold">GoBarber</span>
                                </div>
                            @endif
                            @if($open)
                                <span class="absolute left-3 top-3 flex items-center gap-1.5 rounded-full bg-black/70 px-3 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                    <span class="size-1.5 rounded-full bg-amber-400"></span> Buka Sekarang
                                </span>
                            @endif
                            @if($loop->first)
                                <span class="absolute left-3 top-11 rounded-full bg-amber-400 px-2.5 py-0.5 text-[10px] font-bold text-zinc-950">Pilihan Editor</span>
                            @endif
                        </div>

                        <div class="flex min-w-0 flex-col py-1 pr-1">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-xs text-zinc-500">{{ $place ?: 'Lokasi belum tersedia' }}</p>
                                    <h3 class="mt-1 text-xl font-extrabold leading-tight">{{ $shop->barbershop_name }}</h3>
                                </div>
                                @if($rating)
                                    <span class="shrink-0 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-800">
                                        ★ {{ number_format((float) $rating, 1) }}
                                        <span class="font-medium text-zinc-400">({{ $reviews }} ulasan)</span>
                                    </span>
                                @endif
                            </div>

                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-zinc-500">
                                {{ $shop->description ?: 'Nikmati layanan grooming profesional di barbershop kami.' }}
                            </p>

                            <div class="mt-4 flex items-center justify-between gap-4 rounded-2xl bg-stone-100 px-5 py-4">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold">{{ $service?->service_name ?? 'Layanan belum tersedia' }}</p>
                                    @if($service)
                                        <p class="mt-1 line-clamp-1 text-xs text-zinc-500">{{ $service->description }} ({{ $service->duration }} mnt)</p>
                                    @endif
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-[11px] text-zinc-500">Mulai dari</p>
                                    <p class="text-xl font-extrabold">{{ $minPrice ? 'Rp '.number_format((float) $minPrice, 0, ',', '.') : '-' }}</p>
                                </div>
                            </div>

                            <div class="mt-auto flex flex-wrap justify-end gap-2 pt-4">
                                <a href="{{ url('/barbershop/'.$shop->go_barbershop_id) }}"
                                   class="rounded-full bg-stone-100 px-5 py-3 text-xs font-bold hover:bg-stone-200">Lihat Profil &amp; Paket</a>
                                <a href="{{ route('booking', ['shop' => $shop->go_barbershop_id]) }}"
                                   class="rounded-full bg-zinc-950 px-5 py-3 text-xs font-bold text-white hover:bg-zinc-800">Pilih Jam &amp; Kapster</a>
                            </div>
                        </div>
                    </article>

                    @else
                    {{-- KARTU KOMPAK (sisanya, 2 kolom) --}}
                    <article class="flex flex-col rounded-3xl bg-white p-4 shadow-sm">
                        <div class="relative h-48 overflow-hidden rounded-2xl bg-zinc-950">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $shop->barbershop_name }}" class="absolute inset-0 size-full object-cover">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
                                    <span class="text-4xl">💈</span>
                                    <span class="mt-1 font-extrabold">GoBarber</span>
                                </div>
                            @endif
                            @if($open)
                                <span class="absolute left-3 top-3 flex items-center gap-1.5 rounded-full bg-black/70 px-3 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                    <span class="size-1.5 rounded-full bg-amber-400"></span> Buka Sekarang
                                </span>
                            @endif
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-2 text-xs text-zinc-500">
                            <span class="truncate">{{ $place ?: 'Lokasi belum tersedia' }}</span>
                            @if($rating)
                                <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 font-bold text-amber-800">★ {{ number_format((float) $rating, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="mt-1 text-lg font-extrabold leading-tight">{{ $shop->barbershop_name }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-zinc-500">
                            {{ $shop->description ?: 'Nikmati layanan grooming profesional di barbershop kami.' }}
                        </p>

                        <div class="mt-4 flex items-center justify-between rounded-xl bg-stone-100 px-4 py-3">
                            <span class="truncate text-xs text-zinc-500">{{ $service?->service_name ?? 'Layanan belum tersedia' }}</span>
                            <span class="shrink-0 text-sm font-extrabold">{{ $minPrice ? 'Mulai Rp '.number_format((float) $minPrice, 0, ',', '.') : '-' }}</span>
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-3 pt-4">
                            <a href="{{ url('/barbershop/'.$shop->go_barbershop_id) }}" class="text-xs font-bold text-amber-700 hover:underline">Lihat profil</a>
                            <a href="{{ route('booking', ['shop' => $shop->go_barbershop_id]) }}"
                               class="rounded-full bg-zinc-950 px-5 py-2.5 text-xs font-bold text-white hover:bg-zinc-800">Pilih Jadwal ›</a>
                        </div>
                    </article>
                    @endif

                @empty
                    <div class="rounded-3xl bg-white px-6 py-14 text-center shadow-sm md:col-span-2">
                        <h3 class="text-base font-bold">Barbershop tidak ditemukan</h3>
                        <p class="mt-2 text-sm text-zinc-500">Belum ada barbershop yang sesuai. Coba hapus filter atau gunakan kata kunci lain.</p>
                        <a href="{{ route('shops.explore') }}"
                           class="mt-5 inline-block rounded-full bg-zinc-950 px-5 py-2.5 text-xs font-bold text-white">Reset pencarian</a>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if($shops->hasPages())
                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm">
                    {{ $shops->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
@endsection