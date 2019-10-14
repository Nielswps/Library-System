<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm d-flex justify-content-center">
    <div class="container-fluid row">
        <!-- Left Side Of Navbar -->
        <div class="col-4 d-flex justify-content-start">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Center Of Navbar -->
            <div class="col-6">
                <ul class="navbar-nav mr-auto d-flex justify-content-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Browse
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/browse">Browse all items</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/movies/browse" role="button">Browse Movies</a>
                            <a class="dropdown-item" href="/books/browse" role="button">Browse Books</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/items/add" role="button">Add Item</a></li>
                    <!--<div class="border-right"></div>-->
                    <li class="nav-item"><a class="nav-link" data-toggle="collapse" href="#filtersMovies" aria-expanded="false" aria-controls="filters">Search</a></li>
                </ul>

                <div class="tab-content" id="filterTabContent">
                    <div class="tab-pane fade" id="filters" role="tabpanel" aria-labelledby="filters-tab">
                    </div>
                </div>
            </div>
            <!-- Right Side Of Navbar -->
            <div class="col-6 d-flex justify-content-end">
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</nav>
@php($listOfGenres = ['All','Action','Adult','Adventure','Animation','Biography','Comedy','Crime','Documentary',
'Drama','Family','Fantasy','Film Noir','Game-Show','History','Horror','Musical','Music','Mystery','News',
'Reality-TV','Romance','Sci-Fi','Short','Sport','Talk-Show','Thriller','War','Western'])
<div class="row">
    <div class="collapse" id="filtersMovies">
        <div class="card card-body">
            <form action="{{route('/search')}}" method="GET">
            @csrf
                <div class="form-row d-flex justify-content-center">
                    <div class="col-md-1 text-right">
                        <label class="col-form-label" for="searchItemType">Item type:</label>
                    </div>
                    <div class="col-md-1">
                        <select class="custom-select" id="searchItemType" name="searchItemType">
                            <option value="movie" selected>Movie</option>
                            <option value="book">Book</option>
                        </select>
                    </div>
                    <div class="col-md-1 text-right">
                        <label class="col-form-label" for="genre">Genre:</label>
                    </div>
                    <div class="col-md-2">
                        <select class="custom-select" id="genre" name="genre">
                            @foreach($listOfGenres as $genre)
                                @if(isset($filters) && $genre == $filters['genre'])
                                    <option value="{{$genre}}" selected>{{$genre}}</option>
                                @else
                                    <option value="{{$genre}}">{{$genre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 text-right">
                        <label class="col-form-label text-center" for="lowestRating">Lowest Rating:</label>
                    </div>
                    <div class="col-md-2">
                        <select class="custom-select" id="lowestRating" name="lowestRating">
                            @for($i=1; $i <= 10; $i++)
                                @if(isset($filters) && $filters['rating'] == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 ml-5">
                        @if(isset($filters['search']))
                            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search" value="{{$filters['search']}}">
                        @else
                            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                        @endif
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
