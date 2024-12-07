<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseño PDF Interactivo</title>
    <script src="/js/interact.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .pdf-preview {
            width: 612px;
            height: 792px;
            border: 1px solid #ccc;
            position: relative;
            background-color: #fff;
            margin: 0;
        }

        .header-limit {
            height: 72px;
            background-color: rgba(0, 0, 255, 0.15);
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1;
        }

        .footer-limit {
            height: 75px; /* 2 cm */
            background-color: rgba(255, 0, 0, 0.15);
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 1;
        }

        .logo {
            position: absolute;
            cursor: grab;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 2;
        }

        .notification {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
<h1>Diseño PDF Interactivo</h1>

{{-- Vista previa del PDF --}}
<div class="pdf-preview" id="pdfPreview">
    {{-- Límite del encabezado --}}
    <div class="header-limit" id="headerLimit"></div>
    {{-- Límite del pie de página --}}
    <div class="footer-limit" id="footerLimit"></div>

    @foreach ($logos as $logo)
        <div
            class="logo"
            id="logo-{{ $logo->id }}"
            data-section="{{ $logo->section }}"
            style="transform: translate({{ $logo->position_x ?? 0 }}px, {{ $logo->position_y ?? 0 }}px);
            width: {{ $logo->width ?? 100 }}px;
            height: {{ $logo->height ?? 100 }}px;">
            <img src="data:{{ $logo->mime_type }};base64,{{ base64_encode($logo->image_data) }}" alt="Logo">
        </div>
    @endforeach

</div>

<button id="save-changes">Guardar Cambios</button>
<button id="back-to-home">Regresar al Inicio</button>
<div id="notification" class="notification"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const headerLimit = {
            top: 0,
            bottom: 72,
            left: 0,
            right: 612
        };

        const footerLimit = {
            top: 720,
            bottom: 792,
            left: 0,
            right: 612
        };

        interact('.logo')
            .draggable({
                listeners: {
                    move(event) {
                        const target = event.target;
                        const section = target.dataset.section;
                        let limit;

                        if (section === 'header') {
                            limit = headerLimit;
                        } else if (section === 'footer') {
                            limit = footerLimit;
                        } else {
                            limit = { top: 0, bottom: 1100, left: 0, right: 800 };
                        }

                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        const newX = Math.min(Math.max(x, limit.left), limit.right - target.offsetWidth);
                        const newY = Math.min(Math.max(y, limit.top), limit.bottom - target.offsetHeight);

                        target.style.transform = `translate(${newX}px, ${newY}px)`;
                        target.setAttribute('data-x', newX);
                        target.setAttribute('data-y', newY);
                    }
                }
            })
            .resizable({
                edges: { left: true, right: true, bottom: true, top: true },
                listeners: {
                    move(event) {
                        const target = event.target;
                        const width = parseFloat(target.style.width) + event.deltaRect.width;
                        const height = parseFloat(target.style.height) + event.deltaRect.height;

                        target.style.width = `${width}px`;
                        target.style.height = `${height}px`;

                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.deltaRect.left;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.deltaRect.top;

                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    }
                }
            });

        document.getElementById('save-changes').addEventListener('click', function () {
            const logos = [];
            document.querySelectorAll('.logo').forEach(logo => {
                const id = logo.id.replace('logo-', '');
                const x = parseFloat(logo.getAttribute('data-x')) || 0;
                const y = parseFloat(logo.getAttribute('data-y')) || 0;
                const width = parseFloat(logo.style.width);
                const height = parseFloat(logo.style.height);
                const section = logo.dataset.section || 'default';

                logos.push({
                    id: id,
                    position_x: x,
                    position_y: y,
                    width: width,
                    height: height,
                    section: section
                });
            });

            fetch('/pdf-design/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ logos: logos })
            })
                .then(response => response.json())
                .then(data => {
                    const notification = document.getElementById('notification');
                    if (data.success) {
                        notification.textContent = 'Cambios guardados exitosamente.';
                        notification.style.color = 'green';
                    } else {
                        notification.textContent = 'Error al guardar los cambios.';
                        notification.style.color = 'red';
                    }
                })
                .catch(error => {
                    console.error('Error al guardar:', error);
                });
        });

        document.getElementById('back-to-home').addEventListener('click', function () {
            window.location.href = '{{ route('home') }}';
        });
    });
</script>
</body>
</html>
















