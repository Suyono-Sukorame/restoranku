<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::files('backups'))
                  ->map(function ($file) {
                      return [
                          'name' => basename($file),
                          'size' => Storage::size($file),
                          'date' => Storage::lastModified($file)
                      ];
                  })
                  ->sortByDesc('date');

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        $filename = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
        
        $tables = DB::select('SHOW TABLES');
        $sql = '';
        
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            
            // Get table structure
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $sql .= $createTable->{'Create Table'} . ";\n\n";
            
            // Get table data
            $rows = DB::select("SELECT * FROM `{$tableName}`");
            foreach ($rows as $row) {
                $values = array_map(function($value) {
                    return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                }, (array) $row);
                
                $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }
        
        Storage::put("backups/{$filename}", $sql);
        
        return redirect()->route('backup.index')->with('success', 'Backup berhasil dibuat: ' . $filename);
    }

    public function download($filename)
    {
        if (!Storage::exists("backups/{$filename}")) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan.');
        }
        
        return Storage::download("backups/{$filename}");
    }

    public function delete($filename)
    {
        if (Storage::exists("backups/{$filename}")) {
            Storage::delete("backups/{$filename}");
            return redirect()->route('backup.index')->with('success', 'Backup berhasil dihapus.');
        }
        
        return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan.');
    }
    
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql'
        ]);
        
        try {
            $file = $request->file('backup_file');
            $sql = file_get_contents($file->getPathname());
            
            // Execute SQL commands
            DB::unprepared($sql);
            
            return redirect()->route('backup.index')->with('success', 'Database berhasil di-restore.');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'Gagal restore database: ' . $e->getMessage());
        }
    }
}