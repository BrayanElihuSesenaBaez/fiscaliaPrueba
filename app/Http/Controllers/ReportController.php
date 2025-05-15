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
use Carbon\Carbon;
use App\Models\PdfLogo;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller{

    public function index(Request $request)
    {
        $user = Auth::user(); // Usuario autenticado
        $query = Report::with('user'); // Cargar la relación con el usuario

        // Filtrar reportes según el rol
        if (!$user->hasRole('Fiscal General')) {
            $query->where('user_id', $user->id);
        }

        // Búsqueda por palabras clave
        if ($request->has('query') && !empty($request->input('query'))) {
            $keyword = $request->input('query');

            $query->where(function ($q) use ($keyword, $user) {
                $q->where('expedient_number', 'like', "%{$keyword}%")
                    ->orWhere('report_date', 'like', "%{$keyword}%")
                    ->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%");

                // Solo el Fiscal General puede buscar por usuario
                if ($user->hasRole('Fiscal General')) {
                    $q->orWhereHas('user', function ($u) use ($keyword) {
                        // Concatenar los campos y buscar en cualquiera de ellos
                        $u->whereRaw("CONCAT(name, ' ', firstLastName, ' ', secondLastName) LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("CONCAT(firstLastName, ' ', secondLastName, ' ', name) LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("CONCAT(firstLastName, ' ', name) LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("CONCAT(secondLastName, ' ', name) LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("CONCAT(secondLastName, ' ', firstLastName, ' ', name) LIKE ?", ["%{$keyword}%"]);
                    });
                }
            });
        }

        // Obtener los reportes paginados
        $reports = $query->paginate(10);

        return view('dashboard', compact('reports'));
    }

    public function create(){
        $currentDate = Carbon::now()->setTimezone('America/Mexico_City')->format('Y-m-d\TH:i');

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $states = State::all();
        $municipalities = Municipality::all();
        return view('reports.create', compact( 'categories', 'subcategories', 'states', 'municipalities', 'currentDate'));
    }

    public function store(Request $request)
    {

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

            'residence_code_postal' => 'required|string',
            'residence_colony' => 'required|string',
            'residence_city' => 'nullable|string',
            'incident_city' => 'nullable|string',

            'street' => 'required|string',
            'ext_number' => 'nullable|string',
            'int_number' => 'nullable|string',
            'incident_date_time' => 'required|date',

            'incident_state_id' => 'required|exists:states,id',
            'incident_municipality_id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    $isValid = Municipality::where('id', $value)
                        ->where('state_id', $request->incident_state_id)
                        ->exists();

                    if (!$isValid) {
                        $fail('El municipio seleccionado no pertenece al estado especificado.');
                    }
                },
            ],

            'incident_colony' => 'nullable|string',
            'incident_code_postal' => 'nullable|string',
            'incident_street' => 'nullable|string',
            'incident_ext_number' => 'nullable|string',
            'incident_int_number' => 'nullable|string',
            'suffered_damage' => 'required|string',

            'vehicle_related' => 'required|string|in:yes,no',
            'marca' => 'nullable:vehicle_related,yes|string',
            'modelo' => 'nullable:vehicle_related,yes|string',
            'color' => 'nullable:vehicle_related,yes|string',
            'placa' => 'nullable:estadoPlaca,!Placa Extranjera|string',
            'numeroSerie' => 'nullable:vehicle_related,yes|string|unique:vehicles,numeroSerie',
            'numeroMotor' => 'nullable|string',
            'submarca' => 'nullable|string',
            'tipoUso' => 'nullable:vehicle_related,yes|string',
            'estadoPlaca' => 'nullable:vehicle_related,yes|string',
            'placaExtranjera' => 'nullable|string',
            'señasParticulares' => 'nullable|string',


            'has_witnesses' => 'required|string|in:yes,no',
            'numWitnesses' => 'nullable|integer|min:1|max:15',
            'witnesses' => 'nullable|array',
            'witnesses.*.full_name' => 'required|string|max:255',
            'witnesses.*.phone' => 'nullable|string|max:20',
            'witnesses.*.relationship' => 'nullable|string|max:255',
            'witnesses.*.incident_description' => 'nullable|string',


            'emergency_call' => 'required|string',
            'emergency_number' => 'nullable|string',
            'detailed_account' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        $category = Category::findOrFail($request->category_id);
        $subcategory = Subcategory::findOrFail($request->subcategory_id);
        $expedientNumber = $this->generateExpedientNumber($request);

        $validatedData = $request->all();
        $validatedData['user_id'] = Auth::id();

        $report = Report::create([
            'user_id' => Auth::id(),

            'report_date' => $request->report_date,
            'expedient_number' => $expedientNumber,

            'pdf_blob' => null,

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
            'category_name' => $category->name,
            'subcategory_name' => $subcategory->name,
            'pdf_path' => null,

            'vehicle_related' => $request->vehicle_related == 'yes' ? true : false,
            'vehicles' => $request->vehicles,
        ]);

        if ($request->has('witnesses') && !empty($request->witnesses)) {
            foreach ($request->witnesses as $witnessData) {
                if (!empty($witnessData['full_name'])) {
                    Witness::create([
                        'full_name' => $witnessData['full_name'],
                        'phone' => $witnessData['phone'] ?? null,
                        'relationship' => $witnessData['relationship'] ?? null,
                        'incident_description' => $witnessData['incident_description'] ?? null,
                        'report_id' => $report->id,
                    ]);
                }
            }
        }
        $logos = PdfLogo::where('is_active', 1)->get();

        if ($request->vehicle_related === 'yes') {
            $vehicleData = $request->only([
                'marca', 'modelo', 'numeroSerie', 'numeroMotor', 'tipoUso',
                'color', 'placa', 'estadoPlaca', 'placaExtranjera', 'submarca',
                'procedenciaVehiculo', 'NRPV', 'placaPermiso', 'clase', 'aseguradora',
                'señasParticulares'
            ]);

            if ($request->estadoPlaca === 'Placa Extranjera') {
                $vehicleData['placa'] = null;
            }

            $report->vehicles()->create($vehicleData);
        }


        $data = [
            'logos' => $logos,
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

            'vehicles' => $report->vehicles,
        ];

        $pdf = Pdf::loadView('pdf.view', $data);
        $pdfContent = $pdf->output();

        if (!$pdfContent) {
            return back()->withErrors('Hubo un error al generar el PDF.');
        }

        $report->update(['pdf_blob' => $pdfContent]);

        $pdfDownloadUrl = route('reports.downloadPdf', $report->id);
        return redirect()->route('dashboard')->with('pdf_download_url', $pdfDownloadUrl);
    }
    protected function generateExpedientNumber(Request $request) {
        return strtoupper(substr($request->first_name, 0, 1) . $request->last_name . now()->format('YmdHis'));
    }

    public function show($id){
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    public function edit($id){
        $report = Report::findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('reports.edit', compact('report', 'categories', 'subcategories'));
    }

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

        $report = Report::findOrFail($id);
        $report->update($request->all());

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

    public function destroy($id){
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->route('dashboard');
    }

    public function viewPdf(Report $report)
    {
        if (!$report->pdf_blob) {
            return redirect()->route('dashboard')->withErrors('El PDF no está disponible.');
        }

        $fileName = $report->expedient_number . '.pdf';

        return response($report->pdf_blob)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"{$fileName}\"");
    }


    public function downloadPdf(Report $report)
    {
        if (!$report->pdf_blob) {
            return redirect()->route('dashboard')->withErrors('No se ha generado el PDF para este reporte.');
        }

        $fileName = 'reporte_' . $report->expedient_number . '.pdf';

        return response()->streamDownload(function () use ($report) {
            echo $report->pdf_blob;
        }, $fileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

}





