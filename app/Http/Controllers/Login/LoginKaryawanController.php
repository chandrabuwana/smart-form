<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use DB;

class LoginKaryawanController extends Controller
{
    //
    function IndexLoginKaryawan(Request $d)
    {
        $this->LogoutAuthenticationProcess($d);
        // dd(Auth::check());
        return view("login/login-karyawan");
    }

    function ProcessLogin(Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);



        // Cek validasi
        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        // Lakukan proses otentikasi
        $credentials = $request->only('username', 'password');
        $this->logEvent($request->ip(),"POST",json_encode($request->all()),"/login","0");
        if (Auth::attempt($credentials)) {
            // Jika otentikasi berhasil

            $user = Auth::user();
            $nik = $user->username;
            $dataUser = DB::connection('sqlsrv2')->select("SELECT TOP 1 Nama nama, KodeST, KodeDP  FROM TKaryawan where nik = '$nik'");

            $logOn = Carbon::now();
            $logOff = $logOn->copy()->addHours(2);

            DB::table("MS_HS_LGN_SMART_FORM")->insert([
                'nik' => $nik,
                'log_on' => $logOn,
                'log_off' => $logOff,
                'created_at' => now(),
                'created_by' => $nik,
            ]);
            session([
                'user_id' => $user->username,
                'username' => $dataUser[0]->nama,
                'kode_site' => $dataUser[0]->KodeST,
                'kode_department' => $dataUser[0]->KodeDP
            ]);

            $prevAuthRoute = $_COOKIE['prev_auth_route'] ?? '';
            if(!empty($prevAuthRoute)) {
                setcookie('prev_auth_route', '', -1, '/');
                unset($_COOKIE['prev_auth_route']);
                return redirect()->intended($prevAuthRoute);
            }

            return redirect()->intended(route('dashboard-smart-pica'));
        } else {
            // Jika otentikasi gagal
            return back()
                ->withErrors(['password' => 'Kombinasi username dan password salah.'])
                ->withInput();
        }
    }

    public function LogoutAuthenticationProcess(Request $request)
    {
        DB::table("MS_HS_LGN_SMART_FORM")->where(
            'nik',
            session("user_id")
        )->delete();
        Auth::logout();

        $request->session()->invalidate();


        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
