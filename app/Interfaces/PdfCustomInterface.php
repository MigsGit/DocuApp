<?php

namespace App\Interfaces;

interface PdfCustomInterface
{
    /**
     * Create a interface
     *
     * @param $model,array $data
     */
    public function getPageCount(string $filePath);
    public function convertPdfPageToImage(string $filePath, int $pageNumber, string $outputDir);
    public function insertImageAtCoordinates($pdfPath, $imagePath, $x, $y, $page); //one image only
    public function insertMultipleImageAtCoordinates($data);


}
