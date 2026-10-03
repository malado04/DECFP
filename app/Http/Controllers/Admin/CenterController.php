<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Centre;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centres = Centre::all();
        return view('admin.centres.index', compact('centres'));
    }

    public function create()
    {
        $centres = Centre::all();
        $exams = Exam::all();
        return view('admin.centres.create', compact('centres', 'exams'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 'code'=>'required|string',
            'name'=>'required|string',
            'region'=>'nullable|string',
            'address'=>'nullable|string',
            'contact_email'=>'nullable|email',
            'contact_phone' => 'nullable|regex:/^[0-9]+$/',
            'active'=>'nullable|boolean'
        ]);
        
        // Générer un code unique du type EXAM-YYYYMMDD-XXX
        // $datePart = date('Ymd');
        switch ($request->region) {
            case 'Dakar':$abbr = 'DK';break;
            case 'Thiès':$abbr = 'TH';break;
            case 'Diourbel':$abbr = 'DB';break;
            case 'Saint Louis':$abbr = 'SL';break;
            case 'Louga':$abbr = 'LG';break;
            case 'Matam':$abbr = 'MT';break;
            case 'Kaolack':$abbr = 'KL';break;
            case 'Fatick':$abbr = 'FK';break;
            case 'Kaffrine':$abbr = 'KF';break;
            case 'Kolda':$abbr = 'KD';break;
            case 'Sédhiou':$abbr = 'SD';break;
            case 'Ziguinchor':$abbr = 'ZG';break;
            case 'Tambacounda':$abbr = 'TB';break;
            case 'Kedougou': $abbr= 'KG';break;
            default:
                $abbr = 'UNK';
                break;
        }

        // Compter le nombre d'examens créés aujourd'hui
        $countToday = Centre::whereDate('created_at', now()->toDateString())->count() + 1;

        // Formater le compteur sur 3 chiffres
        $counter = str_pad($countToday, 3, '0', STR_PAD_LEFT);

        // Générer le code final
        $data['code'] = $abbr . '-' . $counter;


        Centre::create($data);
        return redirect()->route('admin.centres.index')->with('success', 'Centre créé.');
    }

    public function show(Centre $centre)
    {
        // Récupérer les examens liés à ce centre
        $exams = $centre->exams()->with('sessions')->get();

        return view('admin.centres.show', compact('centre', 'exams'));
    }


    public function edit(Centre $centre)
    {
        return view('admin.centres.edit', compact('centre'));
    }

    public function update(Request $request, Centre $centre)
    {
        $data = $request->validate([
            'code'=>'required|string',
            'name'=>'required|string',
            'region'=>'nullable|string',
            'address'=>'nullable|string',
            'contact_email'=>'nullable|email',
            // 'contact_phone' => 'nullable|regex:/^[0-9]+$/',
            'active'=>'nullable|boolean'
        ]);

        $centre->update($data);
        return redirect()->route('admin.centres.index')->with('success', 'Centre mis à jour.');
    }

    public function destroy(Centre $centre)
    {
        $centre->delete();
        return redirect()->route('admin.centres.index')->with('success', 'Centre supprimé.');
    }

    // Route custom
    public function showExams(Centre $centre)
    {
        $exams = $centre->candidates()->with('exam')->get();
        return view('admin.centres.exams', compact('centre', 'exams'));
    }
}
