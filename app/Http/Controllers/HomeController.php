<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aes;
use App\Models\Des;
use App\Models\Rc4;
use App\Models\UserInbox;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    public function index()
    {
        $dess = Des::where('user_id', Auth::user()->id)->get();
        $rc4s = Rc4::where('user_id', Auth::user()->id)->get();
        $aess = Aes::where('user_id', Auth::user()->id)->get();
        return view('home.index', compact('dess', 'rc4s', 'aess'));
    }

    public function seeUsers()
    {
        $aess = Aes::where('user_id', Auth::user()->id)->get();
        $usernames = User::select('users.id', 'users.username')
            ->join('aes', 'users.id', '=', 'aes.user_id')
            ->where('users.id', '!=', Auth::user()->id)
            ->get();
        return view('home.users', compact('usernames', 'aess'));
    }

    public function create()
    {
        $aess = Aes::where('user_id', Auth::user()->id)->get();
        if (!$aess->isEmpty())
            return redirect('/home/edit');
        return view('home.create', compact('aess'));
    }

    public function edit()
    {
        $aess = Aes::where('user_id', Auth::user()->id)->get();
        return view('home.edit', compact('aess'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'id_card' => 'required|mimes:jpg,jpeg,png',
            'document' => 'required|mimes:pdf,docx,xls',
            'video' => 'required|mimes:mp4,mov,avi',
        ], [
            'fullname.required' => 'Fullname can\'t be empty!',
            'id_card.required' => 'ID Card can\'t be empty!',
            'id_card.mimes' => 'Allowed ID Card extension are JPG, JPEG, and PNG!',
            'document.required' => 'Document can\'t be empty!',
            'document.mimes' => 'Allowed document extension are PDF, DOCX, and XLS!',
            'video.required' => 'Video can\'t be empty!',
            'video.mimes' => 'Allowed video extension are MP4, MOV, and AVI!'
        ]);

        // Encryption keys and IVs
        $keysAndIvs = [
            'aes' => [
                'key' => openssl_random_pseudo_bytes(32),
                'iv' => openssl_random_pseudo_bytes(16)
            ],
            'des' => [
                'key' => random_bytes(7),
                'iv' => random_bytes(8)
            ],
            'rc4' => [
                'key' => date('ymdhis')
            ]
        ];

    // Encrypt fullname
    $fullname_des = $this->Desencrypt($request->fullname, $keysAndIvs['des']['key'], $keysAndIvs['des']['iv'], 0);
    $fullname_rc4 = $this->Rc4encrypt($request->fullname, $keysAndIvs['rc4']['key'], 0);
    $fullname_aes = $this->AESencrypt($request->fullname, $keysAndIvs['aes']['key'], $keysAndIvs['aes']['iv'], 0);

        
        // Process files
        $files = ['id_card', 'document', 'video'];
        foreach ($files as $fileType) {
            $file = $request->file($fileType);
            $file_ext = $file->extension();
            $file_new = date('ymdhis') . "." . $file_ext;
            
            // Store original file
            $file->storeAs("public/{$fileType}/aes", $file_new);
            $file->storeAs("public/{$fileType}/des", $file_new);
            $file->storeAs("public/{$fileType}/rc4", $file_new);

            // Encrypt files
            $this->Desencrypt(storage_path("app/public/{$fileType}/des/{$file_new}"), $keysAndIvs['des']['key'], $keysAndIvs['des']['iv'], 1);
            $this->Rc4encrypt(storage_path("app/public/{$fileType}/rc4/{$file_new}"), $keysAndIvs['rc4']['key'], 1);
            $this->AESencrypt(storage_path("app/public/{$fileType}/aes/{$file_new}"), $keysAndIvs['aes']['key'], $keysAndIvs['aes']['iv'], 1);
        }

        // Store encrypted data in the database
        Aes::create([
            'fullname' => $fullname_aes,
            'id_card' => $file_new,
            'document' => $file_new,
            'video' => $file_new,
            'user_id' => Auth::user()->id,
            'fullname_key' => base64_encode($keysAndIvs['aes']['key']),
            'fullname_iv' => base64_encode($keysAndIvs['aes']['iv']),
            'id_card_key' => base64_encode($keysAndIvs['aes']['key']),
            'id_card_iv' => base64_encode($keysAndIvs['aes']['iv']),
            'document_key' => base64_encode($keysAndIvs['aes']['key']),
            'document_iv' => base64_encode($keysAndIvs['aes']['iv']),
            'video_key' => base64_encode($keysAndIvs['aes']['key']),
            'video_iv' => base64_encode($keysAndIvs['aes']['iv']),
        ]);

        Des::create([
            'fullname' => $fullname_des,
            'id_card' => $file_new,
            'document' => $file_new,
            'video' => $file_new,
            'user_id' => Auth::user()->id,
            'key' => bin2hex($keysAndIvs['des']['key']),
            'iv' => bin2hex($keysAndIvs['des']['iv'])
        ]);

        Rc4::create([
            'fullname' => $fullname_rc4,
            'id_card' => $file_new,
            'document' => $file_new,
            'video' => $file_new,
            'user_id' => Auth::user()->id,
            'key' => $keysAndIvs['rc4']['key']
        ]);

        return redirect('/home');
    }

    public function update(Request $request)
    {
        // The same validation rules as in store method
        $this->store($request);
    }

    public function download($algo, $type, int $id, $akey)
    {
        if ($type == 'id_card')
            $type = 'idcard';
        $isAcc = UserInbox::where('main_user_id', $id)
            ->where('client_user_id', Auth::user()->id)
            ->where('type', $type)->get();

        if ((!$isAcc || count($isAcc) < 1) && $id !== Auth::user()->id) {
            return abort('403');
        }

        $fileData = $this->getFileData($algo, $type, $id);
        if (!$fileData) return abort('404');

        $checkKey = str_replace('/', '', $fileData['key']);
        if ($akey != $checkKey) return abort('403');

        $copyFilePath = $this->copyFile($fileData['filePath'], $fileData['fileName']);
        $this->decryptFile($algo, $copyFilePath, $fileData['key'], $fileData['iv']);

        return response()->download($copyFilePath)->deleteFileAfterSend(true);
    }

    private function getFileData($algo, $type, $id)
    {
        if ($algo == 'aes') {
            return $this->getAesFileData($type, $id);
        } elseif ($algo == 'des') {
            return $this->getDesFileData($type, $id);
        } elseif ($algo == 'rc4') {
            return $this->getRc4FileData($type, $id);
        }
        return null;
    }

    private function getAesFileData($type, $id)
    {
        $data = Aes::where('user_id', $id)->first();
        return $this->prepareFileData($data, $type, 'aes');
    }

    private function getDesFileData($type, $id)
    {
        $data = Des::where('user_id', $id)->first();
        return $this->prepareFileData($data, $type, 'des');
    }

    private function getRc4FileData($type, $id)
    {
        $data = Rc4::where('user_id', $id)->first();
        return $this->prepareFileData($data, $type, 'rc4');
    }

    private function prepareFileData($data, $type, $algo)
    {
        if ($type == 'fullname') {
            return [
                'fileName' => 'fullname',
                'filePath' => storage_path("app/public/fullname/{$algo}/{$data->fullname}"),
                'key' => $data->{$algo . '_key'},
                'iv' => $data->{$algo . '_iv'}
            ];
        } elseif ($type == 'idcard') {
            return [
                'fileName' => 'id_card',
                'filePath' => storage_path("app/public/id_card/{$algo}/{$data->id_card}"),
                'key' => $data->{$algo . '_key'},
                'iv' => $data->{$algo . '_iv'}
            ];
        } elseif ($type == 'document') {
            return [
                'fileName' => 'document',
                'filePath' => storage_path("app/public/document/{$algo}/{$data->document}"),
                'key' => $data->{$algo . '_key'},
                'iv' => $data->{$algo . '_iv'}
            ];
        } elseif ($type == 'video') {
            return [
                'fileName' => 'video',
                'filePath' => storage_path("app/public/video/{$algo}/{$data->video}"),
                'key' => $data->{$algo . '_key'},
                'iv' => $data->{$algo . '_iv'}
            ];
        }
        return null;
    }

    private function copyFile($filePath, $fileName)
    {
        $copyPath = storage_path("app/public/copy_{$fileName}_" . date('ymdhis'));
        File::copy($filePath, $copyPath);
        return $copyPath;
    }

    private function decryptFile($algo, $filePath, $key, $iv)
    {
        if ($algo == 'aes') {
            $this->AESdecrypt($filePath, base64_decode($key), base64_decode($iv));
        } elseif ($algo == 'des') {
            $this->Desdecrypt($filePath, hex2bin($key), hex2bin($iv));
        } elseif ($algo == 'rc4') {
            $this->Rc4decrypt($filePath, $key);
        }
    }

    public function AESencrypt($data, $key, $iv, $is_file)
    {
        if ($is_file == 1)
            $plaintext = file_get_contents($data);
        else
            $plaintext = $data;
    
        // Start timing AES encryption
        $startTime = microtime(true);
        $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv); // AES-256 CBC
        // End timing AES encryption
        $executionTime = microtime(true) - $startTime;
    
        // Log execution time for AES encryption
        Log::info('AES Encryption Time: ' . $executionTime . ' seconds');
    
        if ($is_file == 1)
            file_put_contents($data, $ciphertext);
        else
            return $ciphertext;
    }
    
    public function Rc4encrypt($data, $key, $is_file)
    {
        if ($is_file == 1)
            $plaintext = file_get_contents($data);
        else
            $plaintext = $data;
    
        // Start timing RC4 encryption
        $startTime = microtime(true);
    
        $len = strlen($key);
        $S = range(0, 255);
        $j = 0;
    
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $len])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }
    
        $i = 0;
        $j = 0;
        $ciphertext = '';
    
        for ($k = 0; $k < strlen($plaintext); $k++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
            $char = $plaintext[$k] ^ chr($S[($S[$i] + $S[$j]) % 256]);
            $ciphertext .= $char;
        }
        $ciphertext = bin2hex($ciphertext);
    
        // End timing RC4 encryption
        $executionTime = microtime(true) - $startTime;
    
        // Log execution time for RC4 encryption
        Log::info('RC4 Encryption Time: ' . $executionTime . ' seconds');
    
        if ($is_file == 1)
            file_put_contents($data, $ciphertext);
        else
            return $ciphertext;
    }
    
    public function Desdecrypt($data, $key, $iv, $is_file)
    {
        if ($is_file == 1)
            $ciphertext = file_get_contents($data);
        else
            $ciphertext = $data;
    
        // Start timing DES decryption
        $startTime = microtime(true);
    
        $ciphertext = hex2bin($ciphertext);
        $iv = hex2bin($iv);
        $key = hex2bin($key);
    
        $plaintext = openssl_decrypt($ciphertext, 'des-ede-cfb', $key, 0, $iv);
    
        // End timing DES decryption
        $executionTime = microtime(true) - $startTime;
    
        // Log execution time for DES decryption
        Log::info('DES Decryption Time: ' . $executionTime . ' seconds');
    
        if ($is_file == 1)
            file_put_contents($data, $plaintext);
        else
            return $plaintext;
    }
    
    public function AESdecrypt($data, $key, $iv, $is_file)
    {
        $key = base64_decode($key);
        $iv = base64_decode($iv);
        if ($is_file == 1)
            $ciphertext = file_get_contents($data);
        else
            $ciphertext = $data;
    
        // Start timing AES decryption
        $startTime = microtime(true);
        $plaintext = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
        // End timing AES decryption
        $executionTime = microtime(true) - $startTime;
    
        // Log execution time for AES decryption
        Log::info('AES Decryption Time: ' . $executionTime . ' seconds');
    
        if ($is_file == 1)
            file_put_contents($data, $plaintext);
        else
            return $plaintext;
    }
    
    public function Rc4decrypt($data, $key, $is_file)
    {
        if ($is_file == 1)
            $ciphertext = file_get_contents($data);
        else
            $ciphertext = $data;
    
        // Start timing RC4 decryption
        $startTime = microtime(true);
    
        $ciphertext = hex2bin($ciphertext);
        $len = strlen($key);
        $S = range(0, 255);
        $j = 0;
    
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $len])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }
    
        $i = 0;
        $j = 0;
        $plaintext = '';
    
        for ($k = 0; $k < strlen($ciphertext); $k++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
            $plaintext .= $ciphertext[$k] ^ chr($S[($S[$i] + $S[$j]) % 256]);
        }
    
        // End timing RC4 decryption
        $executionTime = microtime(true) - $startTime;
    
        // Log execution time for RC4 decryption
        Log::info('RC4 Decryption Time: ' . $executionTime . ' seconds');
    
        if ($is_file == 1)
            file_put_contents($data, $plaintext);
        else
            return $plaintext;
    }
}