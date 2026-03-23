@extends('adminlte::page')

@section('title', __('dashboard.title'))

@section('content_header')
    <h1>{{ __('dashboard.header') }}</h1>
@stop

@section('content')
<div class="row">
    <!-- Total Users -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>{{ __('dashboard.users') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                {{ __('dashboard.more_info') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Online Users -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="online-users-count">{{ $onlineUsersCount }}</h3>
                <p>{{ __('dashboard.online_users') }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#onlineUsersModal">
                {{ __('dashboard.online_users_list') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Chart + Statistics -->
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.active_users_last_7_days') }}</h3>
            </div>
            <div class="card-body">
                <canvas id="activityChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('dashboard.session_statistics') }}</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __('dashboard.total_sessions') }}
                        <span class="badge badge-primary badge-pill">{{ $totalSessions }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __('dashboard.avg_duration') }}
                        <span class="badge badge-primary badge-pill">{{ round($avgDuration) }} min</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __('dashboard.top_session_type') }}
                        <span class="badge badge-primary badge-pill">{{ $topSessionType }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal with online users list -->
<div class="modal fade" id="onlineUsersModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('dashboard.online_users_list') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="online-users-list">
                @if($onlineUsersCount > 0)
                    <ul class="list-group">
                        @foreach($onlineUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user->name }} ({{ $user->email }})
                                <span class="badge badge-primary badge-pill">
                                    {{ \Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>{{ __('dashboard.no_online_users') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart data from PHP
    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartData = {!! json_encode($chartData) !!};

    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: '{{ __("dashboard.active_users") }}',
                data: chartData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });

    // Auto-refresh online users every 30 seconds
    setInterval(() => {
        fetch('{{ route("admin.online-users") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('online-users-count').textContent = data.count;

                const listContainer = document.getElementById('online-users-list');
                if (data.count > 0) {
                    let html = '<ul class="list-group">';
                    data.users.forEach(user => {
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    ${user.name} (${user.email})
                                    <span class="badge badge-primary badge-pill">just now</span>
                                 </li>`;
                    });
                    html += '</ul>';
                    listContainer.innerHTML = html;
                } else {
                    listContainer.innerHTML = '<p>{{ __("dashboard.no_online_users") }}</p>';
                }
            })
            .catch(error => console.error('Error fetching online users:', error));
    }, 30000);
</script>
@stop