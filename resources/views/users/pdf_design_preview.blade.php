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
            width: 800px;
            height: 1100px;
            border: 1px solid #ccc;
            position: relative;
            background-color: #fff;
            padding-top: 120px;
            padding-bottom: 80px;
            box-sizing: border-box;
        }

        .header-limit {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            border-bottom: 2px dashed #ff0000;
            background-color: rgba(255, 0, 0, 0.1);
            pointer-events: none;
        }

        .footer-limit {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            border-top: 2px dashed #0000ff;
            background-color: rgba(0, 0, 255, 0.1);
            pointer-events: none;
        }

        .logo {
            position: absolute;
            cursor: grab;
            border: 1px dashed #aaa;
            background-color: rgba(255, 255, 255, 0.8);
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
    <div class="header-limit"></div>
    {{-- Límite del pie de página --}}
    <div class="footer-limit"></div>

    @foreach ($logos as $logo)
        @if (in_array($logo->id, $pdfDesign->header_logos ?? []) || in_array($logo->id, $pdfDesign->footer_logos ?? []))
            {{-- Mostrar logo solo si fue seleccionado para encabezado o pie de página --}}
            <div
                class="logo"
                id="logo-{{ $logo->id }}"
                data-section="{{ in_array($logo->id, $pdfDesign->header_logos ?? []) ? 'header' : 'footer' }}"
                style="top: {{ $logo->position_y ?? 10 }}px;
                       left: {{ $logo->position_x ?? 10 }}px;
                       width: {{ $logo->width ?? 50 }}px;
                       height: {{ $logo->height ?? 50 }}px;">
                <img src="data:{{ $logo->mime_type }};base64,{{ base64_encode($logo->image_data) }}" alt="Logo">
            </div>
        @endif
    @endforeach
</div>

{{-- Botón para guardar cambios --}}
<button id="save-changes">Guardar Cambios</button>
<button id="save-selection">Guardar Selección de Logos</button>
<div id="notification" class="notification"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const headerLimit = { top: 0, bottom: 120, left: 0, right: 800 }; // Límites del encabezado
        const footerLimit = { top: 1020, bottom: 1100, left: 0, right: 800 }; // Límites del pie de página

        interact('.logo')
            .draggable({
                listeners: {
                    move(event) {
                        const target = event.target;
                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        // Verificar si el logo está dentro de los límites de la sección correspondiente
                        const section = target.dataset.section;

                        let limit = {};
                        if (section === 'header') {
                            limit = headerLimit;
                        } else if (section === 'footer') {
                            limit = footerLimit;
                        }

                        const newX = Math.min(Math.max(x, limit.left), limit.right - target.offsetWidth);
                        const newY = Math.min(Math.max(y, limit.top), limit.bottom - target.offsetHeight);

                        target.style.transform = `translate(${newX}px, ${newY}px)`; // Usar backticks
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

                        target.style.width = `${width}px`; // Usar backticks
                        target.style.height = `${height}px`; // Usar backticks

                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.deltaRect.left;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.deltaRect.top;

                        target.style.transform = `translate(${x}px, ${y}px)`; // Usar backticks
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    }
                }
            });

        function isWithinLimits(logo, limit) {
            const x = parseFloat(logo.getAttribute('data-x')) || 0;
            const y = parseFloat(logo.getAttribute('data-y')) || 0;
            const width = parseFloat(logo.style.width);
            const height = parseFloat(logo.style.height);

            return (
                x >= limit.left &&
                y >= limit.top &&
                x + width <= limit.right &&
                y + height <= limit.bottom
            );
        }

        document.getElementById('save-changes').addEventListener('click', function () {
            const logos = [];
            let isValid = true;
            let message = '';

            document.querySelectorAll('.logo').forEach(logo => {
                const id = logo.id.replace('logo-', '');
                const x = parseFloat(logo.getAttribute('data-x')) || 0;
                const y = parseFloat(logo.getAttribute('data-y')) || 0;
                const width = parseFloat(logo.style.width);
                const height = parseFloat(logo.style.height);
                const section = logo.dataset.section || 'default';

                if (section === 'header' && !isWithinLimits(logo, headerLimit)) {
                    isValid = false;
                    message = 'Uno o más logotipos en el encabezado están fuera de los límites permitidos.';
                } else if (section === 'footer' && !isWithinLimits(logo, footerLimit)) {
                    isValid = false;
                    message = 'Uno o más logotipos en el pie de página están fuera de los límites permitidos.';
                }

                logos.push({
                    id: id,
                    position_x: x,
                    position_y: y,
                    width: width,
                    height: height,
                    section: section
                });
            });

            const notification = document.getElementById('notification');
            if (!isValid) {
                notification.textContent = message;
                notification.style.color = 'red';
                return;
            }

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
                    if (data.success) {
                        notification.textContent = data.success;  // Mostrar mensaje de éxito
                        notification.style.color = 'green';
                    } else {
                        notification.textContent = 'Hubo un error al guardar los cambios.';
                        notification.style.color = 'red';
                    }
                })
                .catch(error => {
                    notification.textContent = 'Hubo un error al guardar los cambios.';
                    notification.style.color = 'red';
                    console.error('Error:', error);
                });
        });

        // Verifica la existencia del botón antes de agregar el event listener
        const saveSelectionButton = document.getElementById('save-selection');
        if (saveSelectionButton) {
            saveSelectionButton.addEventListener('click', function () {
                const selectedHeaderLogos = [];
                const selectedFooterLogos = [];

                document.querySelectorAll('.logo[data-section="header"]').forEach(logo => {
                    selectedHeaderLogos.push(logo.id.replace('logo-', ''));
                });

                document.querySelectorAll('.logo[data-section="footer"]').forEach(logo => {
                    selectedFooterLogos.push(logo.id.replace('logo-', ''));
                });

                fetch('/pdf-design/update-selection', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        header_logos: selectedHeaderLogos,
                        footer_logos: selectedFooterLogos
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        const notification = document.getElementById('notification');
                        if (data.success) {
                            notification.textContent = 'Selección de logos guardada exitosamente.';
                            notification.style.color = 'green';
                        } else {
                            notification.textContent = 'Hubo un error al guardar la selección de logos.';
                            notification.style.color = 'red';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    });

</script>

</body>
</html>















