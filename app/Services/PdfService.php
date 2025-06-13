<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate PDF view and stream/download
     *
     * @param string $view Nama view Blade
     * @param array $data Data untuk view
     * @param string|null $filename Nama file untuk download (tanpa path)
     * @param bool $stream Apakah stream (tampilkan di browser) atau download
     * @return \Illuminate\Http\Response
     */
    public function generate(string $view, array $data = [], string $filename = null, bool $stream = true)
    {
        $pdf = Pdf::loadView($view, $data);

        if ($stream) {
            return $pdf->stream($filename ?? 'document.pdf');
        } else {
            return $pdf->download($filename ?? 'document.pdf');
        }
    }

    /**
     * Generate PDF and save to storage
     *
     * @param string $view
     * @param array $data
     * @param string $path Path relative terhadap storage/app
     * @return string Full path of saved PDF
     */
    public function save(string $view, array $data, string $path): string
    {
        $pdf = Pdf::loadView($view, $data);

        Storage::put($path, $pdf->output());

        return Storage::path($path);
    }
}
