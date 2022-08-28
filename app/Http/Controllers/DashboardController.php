<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $cortes = Corte::with('user')
                ->orderBy('created_at', 'asc')
                ->paginate(5);

            return view('dashboard', compact('cortes'));
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
