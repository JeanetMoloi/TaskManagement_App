<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TaskFlow') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #0f0f13;
            --surface: #17171e;
            --surface2: #1e1e28;
            --border: #2a2a38;
            --accent: #7c6aff;
            --accent2: #ff6a8e;
            --accent3: #6affcb;
            --text: #f0eff8;
            --text2: #9997b3;
            --text3: #5a5870;
            --danger: #ff4d6d;
            --warning: #ffb347;
            --success: #4dffb4;
            --sidebar-w: 260px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .logo-mark {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text3);
            padding: 0 12px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text2);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .nav-item.active {
            background: rgba(124, 106, 255, 0.15);
            color: var(--accent);
        }

        .nav-item .icon {
            width: 20px; height: 20px;
            opacity: 0.8;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sidebar-user {
            padding: 16px;
            border-top: 1px solid var(--border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background: var(--surface2);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: white;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 13px; font-weight: 500; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: var(--text3); text-transform: capitalize; }

        .logout-btn {
            background: none; border: none; cursor: pointer;
            color: var(--text3); padding: 4px;
            border-radius: 6px; transition: color 0.15s;
        }
        .logout-btn:hover { color: var(--danger); }

        /* MAIN CONTENT */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            padding: 20px 32px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 22px;
            color: var(--text);
        }

        .page-content {
            padding: 32px;
            flex: 1;
        }

        /* FLASH MESSAGES */
        .flash {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flash.success { background: rgba(77, 255, 180, 0.1); border: 1px solid rgba(77, 255, 180, 0.3); color: var(--success); }
        .flash.error { background: rgba(255, 77, 109, 0.1); border: 1px solid rgba(255, 77, 109, 0.3); color: var(--danger); }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 18px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.15s;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }
        .btn-primary:hover { background: #6b58f0; transform: translateY(-1px); }

        .btn-danger {
            background: rgba(255, 77, 109, 0.15);
            color: var(--danger);
            border: 1px solid rgba(255, 77, 109, 0.3);
        }
        .btn-danger:hover { background: rgba(255, 77, 109, 0.25); }

        .btn-ghost {
            background: var(--surface2);
            color: var(--text2);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { color: var(--text); border-color: var(--text3); }

        .btn-sm { padding: 7px 13px; font-size: 13px; }

        /* CARDS */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        /* FORMS */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text2);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 11px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--text);
            transition: border-color 0.15s;
            outline: none;
        }

        .form-control:focus { border-color: var(--accent); }
        .form-control::placeholder { color: var(--text3); }

        select.form-control option { background: var(--surface2); }

        .form-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }

        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-pending { background: rgba(255, 179, 71, 0.15); color: var(--warning); }
        .badge-in_progress { background: rgba(124, 106, 255, 0.15); color: var(--accent); }
        .badge-completed { background: rgba(77, 255, 180, 0.15); color: var(--success); }
        .badge-high { background: rgba(255, 77, 109, 0.15); color: var(--danger); }
        .badge-medium { background: rgba(255, 179, 71, 0.15); color: var(--warning); }
        .badge-low { background: rgba(77, 255, 180, 0.15); color: var(--success); }

        /* TABLE */
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text3);
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }
        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            color: var(--text2);
            vertical-align: middle;
        }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: rgba(255,255,255,0.02); }
        .table .task-title { color: var(--text); font-weight: 500; }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.purple::before { background: var(--accent); }
        .stat-card.pink::before { background: var(--accent2); }
        .stat-card.green::before { background: var(--accent3); }
        .stat-card.orange::before { background: var(--warning); }

        .stat-number {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 36px;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text3);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text3);
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            color: var(--text2);
            margin-bottom: 8px;
        }

        .empty-text { font-size: 14px; margin-bottom: 24px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('dashboard') }}" class="logo-mark">
            <div class="logo-icon">✦</div>
            <span class="logo-text">TaskFlow</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-label">Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                All Tasks
            </a>
            <a href="{{ route('tasks.create') }}" class="nav-item">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Task
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </a>
            @endif
        </div>
    </nav>

    <div class="sidebar-user">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role ?? 'member' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- MAIN -->
<main class="main">
    <div class="topbar">
        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
        <div style="display:flex;gap:10px;align-items:center;">
            @yield('topbar-actions')
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="flash success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash error">✕ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</main>

</body>
</html>
