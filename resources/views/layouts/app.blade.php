<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Pengaduan Sarana Sekolah - Sistem aspirasi dan pelaporan fasilitas sekolah">
    <title>@yield('title', 'Pengaduan Sarana Sekolah')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================
           DESIGN SYSTEM - CSS Variables & Reset
           ============================================ */
        :root {
            /* Color Palette */
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --primary-bg: rgba(99, 102, 241, 0.08);

            --secondary: #06b6d4;
            --secondary-light: #22d3ee;

            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.1);
            --warning: #f59e0b;
            --warning-bg: rgba(245, 158, 11, 0.1);
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.1);

            --info: #3b82f6;
            --info-bg: rgba(59, 130, 246, 0.1);

            /* Neutral Palette */
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-card-hover: #334155;
            --bg-input: #0f172a;
            --bg-surface: #1e293b;

            --border-color: rgba(148, 163, 184, 0.15);
            --border-focus: #6366f1;

            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --text-inverse: #0f172a;

            /* Spacing */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;
            --space-2xl: 48px;

            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-full: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.4);
            --shadow-glow: 0 0 30px rgba(99, 102, 241, 0.15);

            /* Transition */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================
           RESET & BASE
           ============================================ */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at 20% 50%, rgba(99, 102, 241, 0.06) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 20%, rgba(6, 182, 212, 0.04) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 80%, rgba(139, 92, 246, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        a {
            text-decoration: none;
            color: var(--primary-light);
            transition: var(--transition);
        }

        a:hover {
            color: var(--primary);
        }

        /* ============================================
           NAVIGATION BAR
           ============================================ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: var(--space-md) var(--space-xl);
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--text-primary);
        }

        .navbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-xs) var(--space-md);
            background: var(--bg-card);
            border-radius: var(--radius-full);
            border: 1px solid var(--border-color);
        }

        .navbar-user .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }

        .navbar-user .user-info {
            font-size: 0.85rem;
        }

        .navbar-user .user-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .navbar-user .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============================================
           BUTTONS
           ============================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
            padding: 10px 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--bg-card-hover);
            border-color: var(--primary);
            color: var(--text-primary);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 1rem;
        }

        .btn-block {
            width: 100%;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary-light);
            background: var(--primary-bg);
        }

        .btn-logout {
            background: transparent;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--danger);
            padding: 8px 16px;
            font-size: 0.8rem;
        }

        .btn-logout:hover {
            background: var(--danger-bg);
            border-color: var(--danger);
        }

        /* ============================================
           MAIN CONTAINER
           ============================================ */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: var(--space-xl);
            position: relative;
            z-index: 1;
        }

        /* ============================================
           CARDS
           ============================================ */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: var(--space-lg);
            transition: var(--transition);
        }

        .card:hover {
            border-color: rgba(148, 163, 184, 0.25);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-lg);
            padding-bottom: var(--space-md);
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* ============================================
           STATS GRID
           ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-md);
            margin-bottom: var(--space-xl);
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: var(--space-lg);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .stat-card.stat-total::before { background: linear-gradient(90deg, var(--primary), var(--secondary)); }
        .stat-card.stat-menunggu::before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-card.stat-proses::before { background: linear-gradient(90deg, var(--info), #60a5fa); }
        .stat-card.stat-selesai::before { background: linear-gradient(90deg, var(--success), #34d399); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: var(--space-md);
        }

        .stat-total .stat-icon { background: var(--primary-bg); }
        .stat-menunggu .stat-icon { background: var(--warning-bg); }
        .stat-proses .stat-icon { background: var(--info-bg); }
        .stat-selesai .stat-icon { background: var(--success-bg); }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: var(--space-xs);
        }

        .stat-total .stat-number { color: var(--primary-light); }
        .stat-menunggu .stat-number { color: var(--warning); }
        .stat-proses .stat-number { color: var(--info); }
        .stat-selesai .stat-number { color: var(--success); }

        .stat-card .stat-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============================================
           TABLE
           ============================================ */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-md);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead th {
            background: rgba(15, 23, 42, 0.5);
            padding: var(--space-md);
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        thead th:first-child { border-radius: var(--radius-sm) 0 0 0; }
        thead th:last-child { border-radius: 0 var(--radius-sm) 0 0; }

        tbody td {
            padding: var(--space-md);
            font-size: 0.875rem;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:hover {
            background: rgba(99, 102, 241, 0.04);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ============================================
           BADGES
           ============================================ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: var(--radius-full);
            white-space: nowrap;
        }

        .badge-menunggu {
            background: var(--warning-bg);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-proses {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .badge-selesai {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-menunggu::before { background: var(--warning); }
        .badge-proses::before { background: var(--info); animation: pulse-dot 2s infinite; }
        .badge-selesai::before { background: var(--success); }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* ============================================
           FORMS
           ============================================ */
        .form-group {
            margin-bottom: var(--space-lg);
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: var(--space-sm);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            transition: var(--transition);
            outline: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-muted);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
            cursor: pointer;
        }

        .form-select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* ============================================
           ALERTS
           ============================================ */
        .alert {
            padding: var(--space-md) var(--space-lg);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: var(--space-lg);
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-info {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* ============================================
           FILTER BAR
           ============================================ */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-md);
            align-items: flex-end;
            padding: var(--space-lg);
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-xl);
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: var(--space-xs);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 8px 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--text-primary);
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            outline: none;
            transition: var(--transition);
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: var(--primary);
        }

        .filter-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
            cursor: pointer;
        }

        .filter-group select option {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .filter-actions {
            display: flex;
            gap: var(--space-sm);
        }

        /* ============================================
           PAGE HEADER
           ============================================ */
        .page-header {
            margin-bottom: var(--space-xl);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: var(--space-xs);
            background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ============================================
           FEEDBACK BOX
           ============================================ */
        .feedback-box {
            background: rgba(99, 102, 241, 0.06);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: var(--radius-sm);
            padding: var(--space-sm) var(--space-md);
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: var(--space-sm);
            max-width: 300px;
        }

        .feedback-box .feedback-label {
            font-weight: 600;
            color: var(--primary-light);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        /* ============================================
           EMPTY STATE
           ============================================ */
        .empty-state {
            text-align: center;
            padding: var(--space-2xl);
            color: var(--text-muted);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: var(--space-md);
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            margin-bottom: var(--space-sm);
            color: var(--text-secondary);
        }

        .empty-state p {
            font-size: 0.85rem;
            max-width: 400px;
            margin: 0 auto;
        }

        /* ============================================
           ASPIRASI TIMELINE CARD (Siswa View)
           ============================================ */
        .aspirasi-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-md);
        }

        .aspirasi-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: var(--space-lg);
            transition: var(--transition);
            position: relative;
        }

        .aspirasi-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: var(--shadow-md);
        }

        .aspirasi-card .aspirasi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-md);
            flex-wrap: wrap;
            gap: var(--space-sm);
        }

        .aspirasi-card .aspirasi-meta {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            flex-wrap: wrap;
        }

        .aspirasi-card .aspirasi-meta span {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .aspirasi-card .aspirasi-body {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .aspirasi-card .aspirasi-footer {
            margin-top: var(--space-md);
            padding-top: var(--space-md);
            border-top: 1px solid var(--border-color);
        }

        /* ============================================
           DETAIL TAG
           ============================================ */
        .detail-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(99, 102, 241, 0.08);
            color: var(--primary-light);
            padding: 3px 10px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .navbar {
                padding: var(--space-sm) var(--space-md);
            }

            .navbar-inner {
                flex-wrap: wrap;
                gap: var(--space-sm);
            }

            .main-container {
                padding: var(--space-md);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-bar {
                flex-direction: column;
            }

            .filter-group {
                min-width: 100%;
            }

            .page-header h1 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .navbar-user .user-info {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')

    @yield('scripts')
</body>
</html>
