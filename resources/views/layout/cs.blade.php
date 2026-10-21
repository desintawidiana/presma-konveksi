<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CS | Presma Operations')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <!-- Konfigurasi Tailwind asli dari Stitch; untuk pratinjau lokal saja. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            "darkMode": "class",
            "theme": {
                "extend": {
                    "colors": {
                        "outline": "#8d706c",
                        "primary-container": "#830909",
                        "on-surface-variant": "#59413e",
                        "tertiary-container": "#004078",
                        "surface-container-low": "#f3f4f4",
                        "on-primary": "#ffffff",
                        "on-primary-fixed-variant": "#8e1310",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#ffb4aa",
                        "secondary-fixed-dim": "#cdc4c5",
                        "secondary-container": "#e9e0e1",
                        "primary-fixed": "#ffdad5",
                        "tertiary-fixed-dim": "#a5c8ff",
                        "on-surface": "#191c1c",
                        "outline-variant": "#e1bfba",
                        "surface-dim": "#d9dada",
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary": "#002a52",
                        "surface-container-highest": "#e1e3e3",
                        "on-secondary-fixed": "#1e1b1c",
                        "on-secondary-container": "#696364",
                        "on-primary-fixed": "#410001",
                        "surface-variant": "#e1e3e3",
                        "background": "#f8f9f9",
                        "inverse-primary": "#ffb4aa",
                        "surface-bright": "#f8f9f9",
                        "error": "#ba1a1a",
                        "on-primary-container": "#ff8a7b",
                        "error-container": "#ffdad6",
                        "on-background": "#191c1c",
                        "surface-container-high": "#e7e8e8",
                        "secondary": "#635d5e",
                        "surface-tint": "#b02e25",
                        "on-tertiary-fixed": "#001c3a",
                        "surface": "#f8f9f9",
                        "secondary-fixed": "#e9e0e1",
                        "inverse-surface": "#2e3131",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#edeeee",
                        "on-tertiary-container": "#78adf7",
                        "on-secondary-fixed-variant": "#4b4546",
                        "tertiary-fixed": "#d4e3ff",
                        "primary": "#5c0002",
                        "on-tertiary-fixed-variant": "#004785",
                        "inverse-on-surface": "#f0f1f1"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "space-xl": "2rem",
                        "gutter": "1rem",
                        "space-md": "1rem",
                        "space-sm": "0.5rem",
                        "margin-mobile": "1rem",
                        "margin": "1.5rem",
                        "space-lg": "1.5rem",
                        "space-xs": "0.25rem",
                        "gutter-compact": "0.5rem"
                    },
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "body-sm": ["Inter"],
                        "title-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "display-lg": ["Inter"],
                        "title-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "data-tabular": ["Inter"]
                    },
                    "fontSize": {
                        "label-md": ["13px", {
                            "lineHeight": "18px",
                            "fontWeight": "500"
                        }],
                        "headline-lg": ["24px", {
                            "lineHeight": "32px",
                            "letterSpacing": "-0.015em",
                            "fontWeight": "600"
                        }],
                        "headline-sm": ["20px", {
                            "lineHeight": "28px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["12px", {
                            "lineHeight": "16px",
                            "fontWeight": "400"
                        }],
                        "title-md": ["16px", {
                            "lineHeight": "24px",
                            "letterSpacing": "-0.005em",
                            "fontWeight": "600"
                        }],
                        "label-sm": ["11px", {
                            "lineHeight": "14px",
                            "letterSpacing": "0.04em",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "title-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "body-md": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "data-tabular": ["13px", {
                            "lineHeight": "18px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "500"
                        }]
                    }
                }
            }
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface font-body-md text-on-surface antialiased">
    @include('cs.partials.sidebar')
    <div class="cs-shell pl-64">
        @include('cs.partials.header')
        @yield('content')
    </div>
    <div class="cs-backdrop" id="cs-backdrop" hidden></div>
</body>

</html>
