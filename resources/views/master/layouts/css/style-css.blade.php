<link href="{{ asset('templating/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
{{-- <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet"> --}}
<link href="{{ asset('templating/css/sb-admin-2.min.css') }}" rel="stylesheet">
<style>
    body.app-shell {
        background: #f4f7fb;
        color: #1f2937;
    }

    .app-shell #wrapper {
        background: #f4f7fb;
    }

    .app-shell .app-sidebar {
        background: linear-gradient(180deg, #0f172a 0%, #18253f 100%) !important;
        box-shadow: 14px 0 32px rgba(15, 23, 42, 0.12);
        z-index: 1040;
    }

    .app-shell .app-sidebar .sidebar-brand {
        height: auto;
        padding: 1.4rem 1rem 1.25rem;
        justify-content: flex-start !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .app-shell .sidebar-brand-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.85rem;
        background: rgba(255, 255, 255, 0.1);
        color: #facc15;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .app-shell .sidebar-brand-text {
        margin: 0 !important;
        line-height: 1.2;
        text-align: left;
    }

    .app-shell .sidebar-brand-text .brand-title {
        display: block;
        font-size: 0.92rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.02em;
    }

    .app-shell .sidebar-brand-text .brand-subtitle {
        display: block;
        margin-top: 0.2rem;
        font-size: 0.72rem;
        font-weight: 400;
        color: rgba(255, 255, 255, 0.65);
        text-transform: none;
    }

    .app-shell .sidebar-divider {
        border-top-color: rgba(255, 255, 255, 0.08);
        margin: 1rem 1rem 0.75rem;
    }

    .app-shell .sidebar-heading {
        padding: 0 1.25rem;
        margin-bottom: 0.75rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.45);
    }

    .app-shell .app-sidebar .nav-item {
        margin: 0 0.85rem 0.35rem;
    }

    .app-shell .app-sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        min-height: 50px;
        padding: 0.9rem 1rem;
        border-radius: 14px;
        color: rgba(255, 255, 255, 0.82) !important;
        transition: all 0.2s ease;
    }

    .app-shell .app-sidebar .nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .app-shell .app-sidebar .nav-link:hover,
    .app-shell .app-sidebar .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff !important;
        transform: translateX(2px);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
    }

    .app-shell .app-sidebar .nav-item.active .nav-link i,
    .app-shell .app-sidebar .nav-link:hover i {
        color: #facc15;
    }

    .app-shell #content-wrapper {
        background: transparent;
    }

    .app-shell .app-topbar {
        background: rgba(255, 255, 255, 0.86) !important;
        border: 1px solid rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        margin: 1.1rem 1.25rem 0.75rem;
        padding: 0.8rem 1rem;
        min-height: 76px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.07);
        position: relative;
        z-index: 1055;
    }

    .modal {
        z-index: 1070;
    }

    .modal-backdrop {
        z-index: 1065;
    }

    .app-shell .app-topbar .topbar-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .app-shell .app-topbar .topbar-subtitle {
        margin: 0.15rem 0 0;
        font-size: 0.82rem;
        color: #64748b;
    }

    .app-shell .app-topbar .nav-link {
        color: #334155;
    }

    .app-shell .app-topbar .topbar-copy {
        min-width: 0;
    }

    .app-shell .app-topbar .min-w-0 {
        min-width: 0;
    }

    .app-shell .app-topbar .topbar-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 0.85rem;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 0.8rem;
        font-weight: 600;
        margin-right: 0.9rem;
    }

    .app-shell .app-topbar .img-profile {
        width: 42px;
        height: 42px;
        object-fit: cover;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.14);
    }

    .app-shell .app-content {
        padding: 0 1.25rem 1.25rem;
    }

    .app-shell .app-page-title {
        font-weight: 700;
        color: #0f172a !important;
        margin-bottom: 1.25rem !important;
    }

    .app-shell .card {
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    .app-shell .card-header {
        background: #ffffff;
        border-bottom: 1px solid rgba(226, 232, 240, 0.75);
    }

    .app-shell .sticky-footer {
        background: transparent !important;
        padding: 0 1.25rem 1.5rem;
    }

    .app-shell .sticky-footer .container {
        max-width: none;
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 18px;
        padding: 1rem 1.25rem;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .app-shell .scroll-to-top {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    @media (max-width: 991.98px) {
        .app-shell .app-topbar {
            margin: 0.75rem 0.75rem 0.5rem;
            min-height: auto;
            border-radius: 18px;
        }

        .app-shell .app-content,
        .app-shell .sticky-footer {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }

    @media (max-width: 767.98px) {
        .app-shell.mobile-sidebar-icon .app-sidebar,
        .app-shell .app-sidebar,
        .app-shell #wrapper.toggled .app-sidebar,
        .app-shell .app-sidebar.toggled {
            width: 5.75rem !important;
            min-height: 100vh;
            overflow: visible;
            transition: margin-left 0.2s ease, width 0.2s ease;
        }

        .app-shell.mobile-sidebar-icon #wrapper.toggled .app-sidebar {
            margin-left: 0 !important;
        }

        .app-shell.mobile-sidebar-hidden #wrapper.toggled .app-sidebar,
        .app-shell.mobile-sidebar-hidden .app-sidebar.toggled,
        .app-shell.mobile-sidebar-hidden .app-sidebar {
            margin-left: -5.75rem !important;
        }

        .app-shell .app-sidebar .sidebar-brand {
            justify-content: center !important;
            padding: 1rem 0.75rem 0.95rem;
        }

        .app-shell .app-sidebar .sidebar-brand-icon {
            margin-right: 0;
            width: 42px;
            height: 42px;
        }

        .app-shell .app-sidebar .sidebar-brand-text,
        .app-shell .app-sidebar .sidebar-heading,
        .app-shell .app-sidebar .nav-link span,
        .app-shell .app-sidebar .sidebar-divider,
        .app-shell .app-sidebar #sidebarToggle {
            display: none !important;
        }

        .app-shell .app-sidebar .nav-item {
            margin: 0 0.55rem 0.45rem;
        }

        .app-shell .app-sidebar .nav-link {
            justify-content: center;
            padding: 0.82rem;
            min-height: 48px;
            gap: 0;
        }

        .app-shell .app-sidebar .nav-link i {
            width: auto;
            margin: 0;
            font-size: 1rem;
        }

        .app-shell.toggled .app-sidebar {
            width: 5.75rem !important;
        }

        .app-shell .app-topbar {
            padding: 0.75rem 0.85rem;
            min-height: 64px;
        }

        .app-shell #sidebarToggleTop {
            position: relative;
            z-index: 1061;
            padding: 0.55rem 0.8rem;
            margin-right: 0.55rem !important;
            border-radius: 12px;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .app-shell .app-topbar .topbar-chip {
            display: none;
        }

        .app-shell .app-topbar .topbar-title {
            font-size: 0.92rem;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .app-shell .app-topbar .topbar-subtitle {
            display: none;
        }

        .app-shell .app-topbar .user-toggle {
            padding-right: 0;
            padding-left: 0.35rem;
        }

        .app-shell .app-topbar .user-toggle::after {
            display: none;
        }

        .app-shell .sidebar-brand-text .brand-subtitle {
            font-size: 0.68rem;
        }

        .app-shell .card {
            border-radius: 18px;
        }

        .app-shell .app-page-title {
            font-size: 1.2rem;
        }
    }
</style>

@stack("css")
