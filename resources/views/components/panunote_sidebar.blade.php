<nav id="sidebar" class="sidebar js-sidebar">

    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('/')}}">
            <div class="sizebox"></div>
            <span class="align-middle">Panunote</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Personal
            </li>

            <li class="sidebar-item {{(request()->is('subjects')  || request()->is('notes') || request()->is('/')) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('subjects') }}">
                    <i class="bi bi-journals"></i> <span class="align-middle">Subjects</span>
                </a>
            </li>

            <li class="sidebar-item {{request()->is('quizzes') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('quizzes') }}">
                    <i class="bi bi-question-square"></i> <span class="align-middle">Quizzes</span>
                </a>
            </li>

            <li class="sidebar-item {{request()->is('shared') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('shared') }}">
                    <i class="bi bi-share"></i> <span class="align-middle">Shared</span>
                </a>
            </li>
            
            <li class="sidebar-item {{request()->is('dictionary') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dictionary') }}">
                    <i class="bi bi-book"></i> <span class="align-middle">Dictionary</span>
                </a>
            </li>

            <li class="sidebar-item {{request()->is('panugame') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('panugame') }}" target="_blank">
                    <i class="bi bi-controller"></i> <span class="align-middle">Panugame</span>
                </a>
            </li>


            <li class="sidebar-header">
                Discover
            </li>

            <li class="sidebar-item {{request()->is('favorites') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('favorites') }}">
                    <i class="bi bi-heart"></i> <span class="align-middle">Favorites</span>
                </a>
            </li>

             
            <li class="sidebar-item {{request()->is('browse/subjects') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{route('browse_subjects')}}">
                    <i class="bi bi-journals"></i> <span class="align-middle">Subjects</span>
                </a>
            </li>

            <li class="sidebar-item {{request()->is('browse/notes') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{route('browse_notes')}}">
                    <i class="bi bi-journal-text"></i> <span class="align-middle">Notes</span>
                </a>
            </li>

            <li class="sidebar-item {{request()->is('browse/quizzes') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{route('browse_quizzes')}}">
                    <i class="bi bi-question-square"></i> <span class="align-middle">Quizzes</span>
                </a>
            </li>
            
        </ul>

        <div class="sidebar-cta">
                <div class="card sidebar-cta-content">
                    <strong class="d-inline-block mb-2">Analytics</strong>
                    <div class="text-sm">
                        Check out your popular <strong>Notes and Quizzes!</strong>
                    </div>
                    <a href="{{route('analytics')}}" class="stretched-link"></a>
                </div>
        </div>

    </div>
</nav>
