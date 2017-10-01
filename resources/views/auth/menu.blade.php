<li class="nav-item dropdown">
    <a href="#" class="nav-link" id="user-menu" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false" title="Settings">
        <span class="fa fa-ellipsis-v"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="user-menu">
        <div class="dropdown-static">
            <strong>{{ Auth::user()->name }}</strong><br>
            <span class="text-muted">{{ Auth::user()->email }}</span>
        </div>
        <div class="dropdown-divider"></div>
        @foreach (Auth::user()->budgets as $otherBudget)
            <a class="dropdown-item {{ (isset($budget) && $otherBudget->id == $budget->id)?'active':'' }}"
               href="{{ route('budgets.show', ['id' => $otherBudget->id])  }}">
                {{ $otherBudget->name }}
            </a>
        @endforeach
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('budgets.index') }}">
            <span class="fa fa-th-large fa-fw"></span>
            {{ __('Budgets') }}
        </a>
        <a class="dropdown-item" href="{{ route('settings') }}">
            <span class="fa fa-cog fa-fw"></span>
            {{ __('Settings') }}
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            {{ csrf_field() }}
        </form>
    </div>
</li>