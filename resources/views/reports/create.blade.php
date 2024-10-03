<h1>Crear Reporte</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<form method="POST" action="/reports">
    @csrf
    <label for="description">Descripción:</label>
    <input type="text" name="description" id="description" required>

    <label for="report_date">Fecha del reporte:</label>
    <input type="date" name="report_date" id="report_date" required>

    <label for="category">Categoría:</label>
    <select name="category_id" id="category" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="subcategory">Subcategoría:</label>
    <select name="subcategory_id" id="subcategory" required>
        @foreach($subcategories as $subcategory)
            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
        @endforeach
    </select>

    <button type="submit">Guardar Reporte</button>
</form>
