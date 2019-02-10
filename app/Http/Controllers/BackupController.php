<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ifsnop\Mysqldump as IMysqldump;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    public function index(Request $request)
    {
        if ($request->download && file_exists(env('BACKUP_DIR') . $request->download)) {
            return response()->download(env('BACKUP_DIR') . $request->download);
        }

        $files = scandir(env('BACKUP_DIR'));
        // $files = array_filter($files, function($f) {
        //     return strpos($f, '.sql') !== false;
        // });

        return array_map(function ($f) {
            return [
                'name' => $f,
                'size' => round(filesize(env('BACKUP_DIR') . $f) / 1024, 2),
                'modified_at' => filemtime(env('BACKUP_DIR') . $f)
            ];
        }, $files);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fileName' => 'required'
        ]);

        // backup file
        $zip = new \ZipArchive;
        $zip->open(env('BACKUP_DIR') . $request->fileName . '.zip', \ZipArchive::CREATE);
        foreach (scandir('uploads') as $img) {
            if (!is_dir('uploads/' . $img)) {
                $zip->addFile('uploads/' . $img);
            }
        }

        $zip->close();

        try {
            $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
            $dump->start(env('BACKUP_DIR') . $request->fileName . '.sql');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }

        return ['message' => 'OK'];
    }

    public function destroy(Request $request)
    {
        if ($request->file && file_exists(env('BACKUP_DIR') . $request->file)) {
            unlink(env('BACKUP_DIR') . $request->file);
        }

        return ['message' => $request->file];
    }
}
