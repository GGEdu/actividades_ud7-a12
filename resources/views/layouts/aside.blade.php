<nav class="navbar navbar-expand-md col-12 ">
    <div class="container-fluid d-flex flex-column col-12 ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDark" aria-controls="navbarDark" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse hidden d-md-flex flex-column col-12 " id="navbarDark">
            <ul class="list-group col-12">
            <li class="list-group-item col-12 d-flex justify-content-between align-items-center " aria-current="true">
                        <a href="{{ route('weather') }}" class="text-decoration-none col-7">Weather</a>
                    </li>
                @foreach ($sections as $section)
                    <li class="list-group-item col-12 d-flex justify-content-between align-items-center " aria-current="true">
                        <a href="#" class="text-decoration-none col-7">{{ $section->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>