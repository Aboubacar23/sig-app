<?php
namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintPdf
{
    private $domPdf;

    public function __construct() {
        $this->domPdf = new Dompdf();
        $pdfOptions = new Options();
        $this->domPdf->setOptions($pdfOptions);
    }

    public function print($html, $fichier) {
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->getOptions()->set('isPhpEnabled', true);
        $dompdf->getOptions()->set('isHtml5ParserEnabled', true);

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);

        $dompdf->setHttpContext($context);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        //$dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        exit();
    }
}
