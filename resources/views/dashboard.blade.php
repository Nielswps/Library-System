@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card-deck row">
            @php($card_count = 0)
            @if(isset($items) and count($items) > 0)
                @foreach($items as $item)
                    @php($card_count += 1)
                    @if($card_count > 3 and $card_count % 3 == 1)
                        <div class="w-100"></div>
                    @endif
                    <div class="card mb-3 col-4 div-link">
                        <a class="card-as-link" href="/{{ $item->type == 'movie' ? 'movies' : $item->type == 'book' ? 'books' : 'items' }}/{{ $item->id }}">
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ "[".$item->type."] " }}<strong>{{ $item->title }}</strong></h3>
                                        <div class="row">
                                            <div class="col align-self-center border-right">
                                                <p class="card-text"><strong>Description:</strong><br>{{ substr($item->description, 0, 50)."..." }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p class="card-text"><small class="text-muted">Last updated: {{ $item->updated_at }}</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection()
