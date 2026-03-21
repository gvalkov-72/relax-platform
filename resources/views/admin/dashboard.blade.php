@extends('adminlte::page')

@section('title', __('dashboard.title'))

@section('content_header')
    <h1>{{ __('dashboard.header') }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $usersCount ?? 0 }}</h3>
                <p>{{ __('dashboard.users') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success" id="online-users-box">
            <div class="inner">
                <h3 id="online-users-count">{{ $onlineUsersCount ?? 0 }}</h3>
                <p>{{ __('dashboard.online_users') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.online_users_list') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body collapse show" id="online-users-list">
                <table class="table table-striped" id="online-users-table">
                    <thead>
                          <tr>
                            <th>ID</th>
                            <th>{{ __('dashboard.name') }}</th>
                            <th>{{ __('dashboard.email') }}</th>
                          </tr>
                    </thead>
                    <tbody>
                        @if($onlineUsers->count())
                            @foreach($onlineUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="no-online-row">
                                <td colspan="3" class="text-muted">{{ __('dashboard.no_online_users') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Функция за обновяване на списъка с онлайн потребители
    function refreshOnlineUsers() {
        fetch('{{ route("admin.online-users") }}', {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Обновяване на броя
            document.getElementById('online-users-count').innerText = data.count;

            // Обновяване на таблицата
            const tableBody = document.querySelector('#online-users-table tbody');
            if (!tableBody) return;

            // Изтриваме съществуващите редове
            tableBody.innerHTML = '';

            if (data.users.length > 0) {
                data.users.forEach(user => {
                    const row = tableBody.insertRow();
                    row.insertCell(0).innerText = user.id;
                    row.insertCell(1).innerText = user.name;
                    row.insertCell(2).innerText = user.email;
                });
            } else {
                const row = tableBody.insertRow();
                row.id = 'no-online-row';
                const cell = row.insertCell(0);
                cell.colSpan = 3;
                cell.className = 'text-muted';
                cell.innerText = '{{ __('dashboard.no_online_users') }}';
            }
        })
        .catch(error => console.error('Грешка при обновяване на онлайн потребителите:', error));
    }

    // Първоначално зареждане (не е задължително, защото данните са вече в HTML)
    // Но можем да извикаме refresh след 1 секунда, за да синхронизираме
    setTimeout(refreshOnlineUsers, 1000);

    // Автоматично обновяване на всеки 30 секунди
    setInterval(refreshOnlineUsers, 30000);
</script>
@stop