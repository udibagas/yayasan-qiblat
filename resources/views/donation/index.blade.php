@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="donation" style="padding:20px 0">
    <div class="container">
        <h1 class="text-center">Donasi Saya</h1>
        <br>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Program</th>
                    <th>Paket</th>
                    <th>Keterangan</th>
                    @if (auth()->user()->role === App\User::ROLE_ADMIN)
                    <th>Donatur</th>
                    @endif
                    <th class="text-center">Qty</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donations as $d)
                <tr>
                    <td>{{$d->created_at}}</td>
                    <td>{{$d->program}}</td>
                    <td>{{$d->package}}</td>
                    <td>{{$d->remark}}</td>
                    @if (auth()->user()->role === App\User::ROLE_ADMIN)
                    <td>{{$d->user}}</td>
                    @endif
                    <td class="text-center">{{number_format($d->qty)}}</td>
                    <td class="text-right" style="width:150px">Rp {{number_format($d->amount)}}</td>
                    <td class="text-center">{{$d->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $donations->links() }}
    </div>
</section>


@endsection