<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Gera backup do PostgreSQL e salva em 2 locais';

    public function handle()
    {
        $dbname   = config('database.connections.pgsql.database', 'psico');
        $password = config('database.connections.pgsql.password');

        $filename   = 'backup_' . now()->format('Y_m_d_His') . '.backup';
        $pgDump     = 'C:\Program Files\PostgreSQL\16\bin\pg_dump.exe';

        // LOCAL 1 → dentro do projeto Laravel
        $local1 = storage_path('app/backups/' . $filename);

        // LOCAL 2 → seu OneDrive (crie a pasta antes ou deixe o código criar)
        $local2 = 'C:\Users\jefin\OneDrive\Documentos\Backups Psico/' . $filename;

        // Garante que as duas pastas existam
        foreach ([$local1, $local2] as $caminho) {
            $pasta = dirname($caminho);
            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }
        }

        // Gera o backup em um local temporário primeiro (mais seguro)
        $tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        $command = sprintf(
            'set "PGPASSWORD=%s" && "%s" --host=127.0.0.1 --port=5432 --username=postgres --format=custom --compress=9 --blobs --file="%s" "%s"',
            $password,
            $pgDump,
            $tempFile,
            $dbname
        );

        $this->info('Gerando backup...');
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            $this->error('Erro ao gerar backup!');
            $this->line(implode(PHP_EOL, $output));
            return 1;
        }

        // Copia para os dois locais finais
        File::copy($tempFile, $local1);
        File::copy($tempFile, $local2);

        // Apaga o temporário
        @unlink($tempFile);

        $tamanho = round(filesize($local1) / 1024 / 1024, 2);

        $this->newLine();
        $this->components->info('BACKUP GERADO E SALVO EM 2 LOCAIS!');

        $this->table(
            ['Local', 'Caminho'],
            [
                ['Projeto Laravel', 'storage/app/backups/' . $filename],
                ['OneDrive', 'Documentos\Backups Psico\\' . $filename],
                ['Tamanho', $tamanho . ' MB'],
                ['Horário', now()->format('d/m/Y H:i:s')],
            ]
        );

        // Opcional: abre a pasta do OneDrive automaticamente
        if (file_exists($local2)) {
            exec('explorer "C:\Users\jefin\OneDrive\Documentos\Backups Psico"');
        }
    }
}