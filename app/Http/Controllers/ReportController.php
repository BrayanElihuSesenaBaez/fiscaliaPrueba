<?php
namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Witness;
use App\Models\State;
use App\Models\Municipality;
use Carbon\Carbon; //Biblioteca de fechas y horas
use App\Models\PdfLogo;

class ReportController extends Controller{

    //Muestra la lista de reportes filtrados para el 'Fiscal General'
    public function index(Request $request)
    {
        //Consula para obtener todos los reportes
        $query = Report::query();

        // Filtra por palabras clave (fecha, número de expediente, nombre de la víctima)
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('expedient_number', 'like', "%{$keyword}%")
                ->orWhere('report_date', 'like', "%{$keyword}%")
                ->orWhere('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%");
        }

        // Obtiene los reportes filtrados
        $reports = $query->get(); //Ejecuta la consulta y obtiene el o los reportes buscados

        return view('dashboard', compact('reports'));
    }

    // Muestra el formulario para crear un reporte
    public function create(){
        // Se obtiebe la fecha y hora actual
        $currentDate = Carbon::now()->setTimezone('America/Mexico_City')->format('Y-m-d\TH:i');


        // Obtiene todas categorias, subcategorias de delitos, estados y municipios de México
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $states = State::all();
        $municipalities = Municipality::all();
        return view('reports.create', compact( 'categories', 'subcategories', 'states', 'municipalities', 'currentDate'));
    }


    // Guarda el reporte en la base de datos y generar el PDF
    public function store(Request $request){
        // Valida los campos del formulario

        $request->validate([
            'report_date' => 'required|date',
            'last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'first_name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'education' => 'required|string',
            'birth_place' => 'required|string',
            'age' => 'required|integer',
            'civil_status' => 'required|string',
            'curp' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',

            'residence_state_id' => 'required|exists:states,id',
            'residence_municipality_id' => 'required|exists:municipalities,id',

//            'colony' => 'required|string',
//            'code_postal' => 'required|string',
            'residence_code_postal' => 'required|string',
            'residence_colony' => 'required|string',
            'residence_city' => 'nullable|string',
            'incident_city' => 'nullable|string',

            'street' => 'required|string',
            'ext_number' => 'required|string',
            'int_number' => 'nullable|string',
            'incident_date_time' => 'required|date',

            'incident_state_id' => 'required|exists:states,id',
            'incident_municipality_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $isValid = Municipality::where('id', $value)
                        ->where('state_id', $request->incident_state_id)
                        ->exists();

                    if (!$isValid) {
                        $fail('El municipio seleccionado no pertenece al estado especificado.');
                    }
                },
            ],
            // Otras validaciones

            'incident_colony' => 'required|string',
            'incident_code_postal' => 'required|string',
            'incident_street' => 'required|string',
            'incident_ext_number' => 'required|string',
            'incident_int_number' => 'nullable|string',
            'suffered_damage' => 'required|string',

            'has_witnesses' => 'required|string|in:yes,no',
            'numWitnesses' => 'nullable|integer|min:1|max:15',  // Asegurarse de que el número de testigos sea un valor adecuado
            'witnesses' => 'nullable|array',  // Ahora 'witnesses' es un array
            'witnesses.*.full_name' => 'required|string|max:255',  // Validación de nombre completo
            'witnesses.*.phone' => 'nullable|string|max:20',  // Validación de teléfono
            'witnesses.*.relationship' => 'nullable|string|max:255',  // Validación de parentesco
            'witnesses.*.incident_description' => 'nullable|string',  // Validación de la descripción


            'emergency_call' => 'required|string',
            'emergency_number' => 'nullable|string',
            'detailed_account' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Obtiene los nombres de la categoria y subcategoria
        $category = Category::findOrFail($request->category_id); //Busca la categoria por ID
        $subcategory = Subcategory::findOrFail($request->subcategory_id);//Busca la subcategoria por ID

        // Genera un numero de expediente basado en la información del formulario
        $expedientNumber = $this->generateExpedientNumber($request);


        // Se crea el reporte
        $report = Report::create([
            'report_date' => $request->report_date,
            'expedient_number' => $expedientNumber,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'first_name' => $request->first_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'education' => $request->education,
            'birth_place' => $request->birth_place,
            'age' => $request->age,
            'civil_status' => $request->civil_status,
            'curp' => $request->curp,
            'phone' => $request->phone,
            'email' => $request->email,

            'residence_state' => State::findOrFail($request->residence_state_id)->name,
            'residence_municipality' => Municipality::findOrFail($request->residence_municipality_id)->name,

//            'colony' => $request->colony,
//            'code_postal' => $request->code_postal,

            'residence_code_postal' => $request->residence_code_postal,
            'residence_colony' => $request->residence_colony,
            'residence_city' => $request->residence_city,
            'incident_city' => $request->incident_city,

            'street' => $request->street,
            'ext_number' => $request->ext_number,
            'int_number' => $request->int_number,
            'incident_date_time' => $request->incident_date_time,

            'incident_state' => State::find($request->incident_state_id)->name,
            'incident_municipality' => Municipality::find($request->incident_municipality_id)->name,

            'incident_colony' => $request->incident_colony,
            'incident_code_postal' => $request->incident_code_postal,
            'incident_street' => $request->incident_street,
            'incident_ext_number' => $request->incident_ext_number,
            'incident_int_number' => $request->incident_int_number,
            'suffered_damage' => $request->suffered_damage,

            'has_witnesses' => $request->has_witnesses == 'yes' ? true : false,
            'witnesses' => $request->witnesses ?? [],

            'emergency_call' => $request->emergency_call,
            'emergency_number' => $request->emergency_number,
            'detailed_account' => $request->detailed_account,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'category_name' =>$category->name,
            'subcategory_name' => $subcategory->name,
            'pdf_path' => null,
        ]);

        // Si hay testigos, guardarlos en la base de datos
        if ($request->has('witnesses') && !empty($request->witnesses)) {
            foreach ($request->witnesses as $witnessData) {
                if (!empty($witnessData['full_name'])) {
                    // Crear el testigo y asociarlo con el reporte
                    Witness::create([
                        'full_name' => $witnessData['full_name'],
                        'phone' => $witnessData['phone'] ?? null,
                        'relationship' => $witnessData['relationship'] ?? null,
                        'description' => $witnessData['description'] ?? null,
                        'report_id' => $report->id, // Asegúrate de asociar el testigo con el reporte
                    ]);
                }
            }
        }
        // Cargar los detalles de los logotipos
        $logosDetails = PdfLogo::all(); // Suponiendo que tienes un modelo Logo para manejar los logotipos

        // Genera el PDF
        $data = [
            'logosDetails' => $logosDetails,  // Se pasa los detalles de los logotipos
            'report_date' => $report->report_date,
            'expedient_number' => $report->expedient_number,
            'last_name' => $report->last_name,
            'mother_last_name' => $report->mother_last_name,
            'first_name' => $report->first_name,
            'birth_date' => $report->birth_date,
            'gender' => $report->gender,
            'education' => $report->education,
            'birth_place' => $report->birth_place,
            'age' => $report->age,
            'civil_status' => $report->civil_status,
            'curp' => $report->curp,
            'phone' => $report->phone,
            'email' => $report->email,

            'residence_state' => $report->residence_state,
            'residence_municipality' => $report->residence_municipality,

//            'colony' => $report->colony,
//            'code_postal' => $report->code_postal,

            'residence_code_postal' => $report->residence_code_postal,
            'residence_colony' => $report->residence_colony,
            'residence_city' => $report->residence_city,
            'incident_city' => $report->incident_city,

            'street' => $report->street,
            'ext_number' => $report->ext_number,
            'int_number' => $report->int_number,
            'incident_date_time' => $report->incident_date_time,

            'incident_state' => $report->incident_state,
            'incident_municipality' => $report->incident_municipality,

            'incident_colony' => $report->incident_colony,
            'incident_code_postal' => $report->incident_code_postal,
            'incident_street' => $report->incident_street,
            'incident_ext_number' => $report->incident_ext_number,
            'incident_int_number' => $report->incident_int_number,
            'suffered_damage' => $report->suffered_damage,

            'has_witnesses' => $report->has_witnesses ? 'Sí' : 'No',
            'witnesses' => is_array($report->witnesses) ? $report->witnesses : [],

            'emergency_call' => $report->emergency_call,
            'emergency_number' => $report->emergency_number,
            'detailed_account' => $report->detailed_account,
            'category_name' => $report->category->name,
            'subcategory_name' => $report->subcategory->name,

        ];


        // Crea y guarda el PDF
        $pdf = Pdf::loadView('pdf.view', $data);
        $pdfPath = 'pdfs/report_' . $report->id . '.pdf';
        $pdf->save(storage_path("app/public/{$pdfPath}"));

        // Guarda la ruta del PDF en el reporte
        $report->update(['pdf_path' => $pdfPath]);

        return redirect()->route('reports.pdf', ['reportId' => $report->id]);
    }

    // Función para generar el número de expediente
    protected function generateExpedientNumber(Request $request) {
        // Genera un número de expediente basado en la primera letra del nombre, el apellido y la fecha actual
        return strtoupper(substr($request->first_name, 0, 1) . $request->last_name . now()->format('YmdHis'));
    }

    // Muestra el PDF del reporte
    public function show($id){
        // Encuentra el reporte por ID
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    // Mostrar el formulario de edición de un reporte
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('reports.edit', compact('report', 'categories', 'subcategories'));
    }

    // Funcion para actualizar un reporte existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'first_name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'education' => 'required|string',
            'birth_place' => 'required|string',
            'age' => 'required|integer',
            'civil_status' => 'required|string',
            'curp' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'state' => 'required|string',
            'municipality' => 'required|string',
            'colony' => 'required|string',
            'code_postal' => 'required|string',
            'street' => 'required|string',
            'ext_number' => 'required|string',
            'int_number' => 'nullable|string',
            'incident_date_time' => 'required|date',
            'incident_state' => 'required|string',
            'incident_municipality' => 'required|string',
            'incident_colony' => 'required|string',
            'incident_code_postal' => 'required|string',
            'incident_street' => 'required|string',
            'incident_ext_number' => 'required|string',
            'incident_int_number' => 'nullable|string',
            'suffered_damage' => 'required|string',
            'witnesses' => 'required|string',
            'emergency_call' => 'required|string',
            'emergency_number' => 'nullable|string',
            'detailed_account' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Buscar el reporte y actualiza sus datos
        $report = Report::findOrFail($id);
        $report->update($request->all());

        // Actualiza el PDF con los nuevos datos
        $data = [
            'expedient_number' => $request->expedient_number,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'first_name' => $request->first_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'education' => $request->education,
            'birth_place' => $request->birth_place,
            'age' => $request->age,
            'civil_status' => $request->civil_status,
            'curp' => $request->curp,
            'phone' => $request->phone,
            'email' => $request->email,
            'state' => $request->state,
            'municipality' => $request->municipality,
            'colony' => $request->colony,
            'code_postal' => $request->code_postal,
            'street' => $request->street,
            'ext_number' => $request->ext_number,
            'int_number' => $request->int_number,
            'incident_date_time' => $request->incident_date_time,
            'incident_state' => $request->incident_state,
            'incident_municipality' => $request->incident_municipality,
            'incident_colony' => $request->incident_colony,
            'incident_code_postal' => $request->incident_code_postal,
            'incident_street' => $request->incident_street,
            'incident_ext_number' => $request->incident_ext_number,
            'incident_int_number' => $request->incident_int_number,
            'suffered_damage' => $request->suffered_damage,
            'witnesses' => $request->witnesses,
            'emergency_call' => $request->emergency_call,
            'emergency_number' => $request->emergency_number,
            'detailed_account' => $request->detailed_account,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ];

        $pdf = Pdf::loadView('pdf.view', $data);
        $pdfPath = 'pdfs/report_' . $report->id . '.pdf';
        $pdf->save(storage_path("app/public/{$pdfPath}"));

        $report->update(['pdf_path' => $pdfPath]);

        return redirect()->route('dashboard')->with('success', 'Reporte actualizado correctamente.');
    }

    // Funcion para eliminar un reporte
    public function destroy($id){
        $report = Report::findOrFail($id); // Encuentra el reporte por ID
        $report->delete();
        return redirect()->route('dashboard');
    }

    // Funcion para buscar reportes por número de expediente o fecha
    public function search(Request $request){
        $query = $request->input('query');

        // Filtra reportes por número de expediente o fecha
        $reports = Report::where('expedient_number', 'LIKE', "%$query%")
            ->orWhereDate('report_date', $query)
            ->get();

        return view('dashboard', compact('reports'));
    }
}





