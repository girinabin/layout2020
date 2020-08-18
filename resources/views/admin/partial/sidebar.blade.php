<ul class="sidebar navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @can('isAdmin')
      <li class="nav-item">
        <a class="nav-link" href="/roles">
          <i class="fa fa-unlock-alt"></i>
          <span>Roles</span></a>
      </li>
    @endcan
    @canany(['isAdmin','isManager'])
      <li class="nav-item">
        <a class="nav-link" href="/users">
          <i class="fas fa-fw fa-table"></i>
          <span>Users</span></a>
      </li>
    @endcan
    <li class="nav-item">
      <a class="nav-link" href="{{ route('posts.index') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Posts</span></a>
    </li>
    {{-- @role('manager,content-editor') --}}
    <li class="nav-item">
      <a class="nav-link" href="/posts">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Test</span></a>
    </li>
    {{-- @endrole --}}
    @directive_name()
  </ul>