<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try {
            //code...

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('ForceSales')->accessToken;

            return response()->json(['token' => $token], 200);
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (auth()->attempt($data)) {
                $req = Request::create('/oauth/token', 'POST', [
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'username' => auth()->user()->email,
                    'password' => $request->password,
                ]);
                $res = app()->handle($req);
                $responseBody = $res->getContent();
                $response = json_decode($responseBody, true);
                return response()->json($response, 200);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function webLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('dashboard'));
                }
                else {
                flash()->error('Não foi possível entrar, dados incorretos.');
                return redirect()->back()->withErrors(['Usuario ou senha invalidos']);
            }

        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function webRegister(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        try {

            User::create([
                'email' => $request->email,
                'name' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            return redirect('/');

        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
