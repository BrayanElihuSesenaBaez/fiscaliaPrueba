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
<h3>Encabezado:</h3>
<div class="pdf-preview" id="pdfPreview">
    {{-- Límite del encabezado --}}
    <div class="header-limit"></div>
    {{-- Límite del pie de página --}}
    <div class="footer-limit"></div>

    @foreach($logosDetails as $logo)
        @if($logo->location == 'header')
            <div class="logo" id="logo-{{ $logo->id }}"
                 style="width: {{ $logo->width }}px; height: {{ $logo->height }}px;
                    top: {{ min($logo->position_y, 120 - $logo->height) }}px;
                    left: {{ $logo->alignment === 'center' ? 'calc(50% - '.($logo->width / 2).'px)' :
                            ($logo->alignment === 'right' ? 'calc(100% - '.$logo->width.'px)' : $logo->position_x.'px') }};">
                <img src="{{ Storage::url($logo->file_path) }}" alt="{{ $logo->name }}"
                     style="width: 100%; height: 100%; object-fit: contain;">
            </div>
        @endif
    @endforeach

    @foreach($logosDetails as $logo)
        @if($logo->location == 'footer')
            <div class="logo" id="logo-{{ $logo->id }}"
                 style="width: {{ $logo->width }}px; height: {{ $logo->height }}px;
                    bottom: {{ min($logo->position_y, 80) }}px;
                    left: {{ $logo->alignment === 'center' ? 'calc(50% - '.($logo->width / 2).'px)' :
                            ($logo->alignment === 'right' ? 'calc(100% - '.$logo->width.'px)' : $logo->position_x.'px') }};">
                <img src="{{ Storage::url($logo->file_path) }}" alt="{{ $logo->name }}"
                     style="width: 100%; height: 100%; object-fit: contain;">
            </div>
        @endif
    @endforeach
</div>

<button id="save-changes">Guardar Cambios</button>
<div id="notification" class="notification"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configuración de interact.js para mover y redimensionar los logotipos en la vista previa
        interact('.logo')
            .draggable({
                listeners: {
                    // Evento de movimiento
                    move(event) {
                        const target = event.target;
                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    }
                }
            })
            .resizable({
                edges: { left: true, right: true, bottom: true, top: true },
                listeners: {
                    // Evento de redimensionamiento
                    move(event) {
                        const target = event.target;
                        const width = parseFloat(target.style.width || target.offsetWidth) + event.deltaRect.width;
                        const height = parseFloat(target.style.height || target.offsetHeight) + event.deltaRect.height;

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

        // Guardar los cambios realizados
        document.getElementById('save-changes').addEventListener('click', function () {
            const logos = [];

            document.querySelectorAll('.logo').forEach(logo => {
                const id = logo.id.replace('logo-', '');
                const x = parseFloat(logo.getAttribute('data-x')) || 0;
                const y = parseFloat(logo.getAttribute('data-y')) || 0;
                const width = parseFloat(logo.style.width || logo.offsetWidth);
                const height = parseFloat(logo.style.height || logo.offsetHeight);

                logos.push({
                    id,
                    position_x: x,
                    position_y: y,
                    width,
                    height
                });
            });

            // Enviar los cambios al servidor
            fetch('/pdf-design/save-logo-changes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ logos })
            })
                .then(response => response.json())
                .then(data => {
                    const notification = document.getElementById('notification');
                    if (data.status === 'success') {
                        notification.textContent = 'Logotipos guardados correctamente.';
                        notification.style.color = 'green';
                    } else {
                        notification.textContent = data.message;
                        notification.style.color = 'red';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
</body>
</html>













