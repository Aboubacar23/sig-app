<?php
// src/Twig/NumberToWordsExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Kwn\NumberToWords\NumberToWords;

class NumberToWordsExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('number_to_words', [$this, 'numberToWords']),
        ];
    }

    public function numberToWords($number)
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('fr');

        return $numberTransformer->toWords($number);
    }
}
