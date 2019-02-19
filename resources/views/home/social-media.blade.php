<ul class="list-inline social-buttons">
    @foreach ($socialMedia as $s)
    <li class="list-inline-item">
        <a href="{{$s->url}}" target="_blank">
            <i class="{{$s->icon}}"></i>
        </a>
    </li>
    @endforeach
    <!-- <li class="list-inline-item">
        <a href="#">
            <i class="fab fa-twitter"></i>
        </a>
    </li>
    <li class="list-inline-item">
        <a href="#">
            <i class="fab fa-facebook-f"></i>
        </a>
    </li>
    <li class="list-inline-item">
        <a href="#">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </li> -->
</ul>