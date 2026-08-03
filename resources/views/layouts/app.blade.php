<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APPSI - Asosiasi Pemerintah Provinsi Seluruh Indonesia')</title>
    
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        try {
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "background": "#f8f9fb",
                            "on-primary-container": "#7d94db",
                            "on-tertiary": "#ffffff",
                            "on-error": "#ffffff",
                            "surface-variant": "#e1e2e4",
                            "inverse-on-surface": "#f0f1f3",
                            "on-surface": "#191c1e",
                            "surface-white": "#FFFFFF",
                            "surface": "#f8f9fb",
                            "secondary-fixed-dim": "#ffb956",
                            "surface-tint": "#445b9e",
                            "on-surface-variant": "#444650",
                            "primary": "#001647",
                            "tertiary": "#001a39",
                            "secondary-fixed": "#ffddb5",
                            "on-background": "#191c1e",
                            "surface-container": "#edeef0",
                            "surface-bright": "#f8f9fb",
                            "error-container": "#ffdad6",
                            "on-primary-fixed": "#00174a",
                            "on-secondary-fixed": "#2a1800",
                            "surface-container-lowest": "#ffffff",
                            "surface-container-high": "#e7e8ea",
                            "on-tertiary-container": "#8097bf",
                            "on-primary-fixed-variant": "#2b4385",
                            "surface-container-highest": "#e1e2e4",
                            "primary-fixed-dim": "#b4c5ff",
                            "on-tertiary-fixed-variant": "#30476a",
                            "border-subtle": "#DDE1E6",
                            "tertiary-fixed": "#d5e3ff",
                            "secondary": "#E8A33D",
                            "inverse-primary": "#b4c5ff",
                            "outline-variant": "#c5c6d2",
                            "outline": "#757681",
                            "tertiary-container": "#162f51",
                            "error": "#ba1a1a",
                            "on-secondary-container": "#714800",
                            "text-main": "#1A1A1A",
                            "on-tertiary-fixed": "#001b3c",
                            "on-error-container": "#93000a",
                            "on-secondary": "#ffffff",
                            "surface-container-low": "#f3f4f6",
                            "on-secondary-fixed-variant": "#643f00",
                            "primary-fixed": "#dbe1ff",
                            "tertiary-fixed-dim": "#b0c7f1",
                            "on-primary": "#ffffff",
                            "secondary-container": "#feb64e",
                            "surface-dim": "#d9dadc",
                            "primary-container": "#0c2a6b",
                            "inverse-surface": "#2e3132"
                        },
                        "borderRadius": {
                            "DEFAULT": "0.125rem",
                            "lg": "0.25rem",
                            "xl": "0.5rem",
                            "full": "0.75rem"
                        },
                        "spacing": {
                            "stack-lg": "3rem",
                            "max-width-content": "1200px",
                            "gutter": "1.5rem",
                            "margin-page": "2rem",
                            "stack-md": "1.5rem",
                            "stack-sm": "0.5rem"
                        },
                        "fontFamily": {
                            "headline-sm": ["Plus Jakarta Sans"],
                            "body-lg": ["Plus Jakarta Sans"],
                            "button": ["Plus Jakarta Sans"],
                            "headline-lg": ["Plus Jakarta Sans"],
                            "headline-md": ["Plus Jakarta Sans"],
                            "headline-lg-mobile": ["Plus Jakarta Sans"],
                            "label-caps": ["Plus Jakarta Sans"],
                            "body-md": ["Plus Jakarta Sans"]
                        },
                        "fontSize": {
                            "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                            "body-lg": ["17px", {"lineHeight": "1.8", "fontWeight": "400"}],
                            "button": ["16px", {"lineHeight": "1", "fontWeight": "600"}],
                            "headline-lg": ["36px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "600"}],
                            "headline-md": ["26px", {"lineHeight": "1.3", "fontWeight": "600"}],
                            "headline-lg-mobile": ["28px", {"lineHeight": "1.2", "fontWeight": "600"}],
                            "label-caps": ["13px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
                            "body-md": ["15px", {"lineHeight": "1.6", "fontWeight": "400"}]
                        }
                    },
                },
            }
        } catch(_e){}
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fb; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col justify-between">

    @include('components.navbar')

    <main class="pt-16 pb-32 flex-grow">
        @yield('content')
    </main>

    @include('components.footer')
    
    @include('components.bottom-nav')

    <script>
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            if (header) {
                if (window.scrollY > 50) {
                    header.classList.add('shadow-lg', 'bg-primary/95');
                } else {
                    header.classList.remove('shadow-lg', 'bg-primary/95');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
