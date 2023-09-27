<?php
/**
* NumberToWords
* Github: https://github.com/mohd-baqeri/multi-lang-number-to-words-php/
*/
class NumberToWords
{
    // EN numbers
    protected $ones_en = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
    ];
    protected $ones_5_en = [
        1 => 'eleven',
        2 => 'twelve',
        3 => 'thirteen',
        4 => 'fourteen',
        5 => 'fiveteen',
        6 => 'sixteen',
        7 => 'seventeen',
        8 => 'eighteen',
        9 => 'nineteen',
    ];
    protected $tens_en = [
        1 => 'ten',
        2 => 'twenty',
        3 => 'thirty',
        4 => 'fourty',
        5 => 'fivety',
        6 => 'sixty',
        7 => 'seventy',
        8 => 'eighty',
        9 => 'ninty'
    ];
    protected $hundreds_en = [
        1 => 'one hundred',
        2 => 'two hundred',
        3 => 'three hundred',
        4 => 'four hundred',
        5 => 'five hundred',
        6 => 'six hundred',
        7 => 'seven hundred',
        8 => 'eight hundred',
        9 => 'nine hundred',
    ];
    protected $thousands_en = [
        1 => 'thousand',
        2 => 'million',
        3 => 'billion',
        4 => 'trillion',
        5 => 'quadrillion',
        6 => 'Quintillion',
        7 => 'Sextillion',
        8 => 'Septillion',
    ];
    protected $and_en = [
        'and' => 'and',
    ];

    // AF numbers
    protected $ones_af = [
        0 => 'صفر',
        1 => 'یک',
        2 => 'دو',
        3 => 'سه',
        4 => 'چهار',
        5 => 'پنج',
        6 => 'شش',
        7 => 'هفت',
        8 => 'هشت',
        9 => 'نه',
    ];
    protected $ones_5_af = [
        1 => 'یازده',
        2 => 'دوازده',
        3 => 'سیزده',
        4 => 'چهارده',
        5 => 'پانزده',
        6 => 'شانزده',
        7 => 'هفده',
        8 => 'هجده',
        9 => 'نوزده',
    ];
    protected $tens_af = [
        1 => 'ده',
        2 => 'بیست',
        3 => 'سی',
        4 => 'چهل',
        5 => 'پنجاه',
        6 => 'شصت',
        7 => 'هفتاد',
        8 => 'هشتاد',
        9 => 'نود'
    ];
    protected $hundreds_af = [
        1 => 'صد',
        2 => 'دوصد',
        3 => 'سه صد',
        4 => 'چهارصد',
        5 => 'پنج صد',
        6 => 'ششصد',
        7 => 'هفتصد',
        8 => 'هشتصد',
        9 => 'نهصد',
    ];
    protected $thousands_af = [
        1 => 'هزار',
        2 => 'میلیون',
        3 => 'میلیارد',
        4 => 'تریلیون',
        5 => 'کادریلیون',
        6 => 'کوینتریلیون',
        7 => 'سکستریلیون',
        8 => 'سپتریلیون',
    ];
    protected $and_af = [
        'and' => 'و',
    ];

    public function formatter($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',')
    {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
            $number[1] = round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }

    public function groupToWords($group, $lang = 'af')
    {
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;
    
        $group_array = [];
    
        if ($d3 != 0) {
            if ($lang == 'af') $group_array[] = $this->hundreds_af[$d3];
            if ($lang == 'en') $group_array[] = $this->hundreds_en[$d3];
        }
    
        if ($d2 == 1 && $d1 != 0) { // 11-19
            if ($lang == 'af') $group_array[] = $this->ones_5_af[$d1];
            if ($lang == 'en') $group_array[] = $this->ones_5_en[$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            if ($lang == 'af') $group_array[] = $this->tens_af[$d2];
            if ($lang == 'en') $group_array[] = $this->tens_en[$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 0
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            if ($lang == 'af') $group_array[] = $this->ones_af[$d1];
            if ($lang == 'en') $group_array[] = $this->ones_en[$d1];
        } else { // Others
            if ($lang == 'af') {
                $group_array[] = $this->tens_af[$d2];
                $group_array[] = $this->ones_af[$d1];
            }
            if ($lang == 'en') {
                $group_array[] = $this->tens_en[$d2];
                $group_array[] = $this->ones_en[$d1];
            }
        }

        if (!count($group_array)) {
            return FALSE;
        }
    
        return $group_array;
    }

    public function convert($number, $lang = 'af')
    {
        if ($number == 0) {
            if ($lang == 'af') return $this->ones_af[0];
            if ($lang == 'en') return $this->ones_en[0];
        }

        $formated = $this->formatter($number, 0, '.', ',');
        $groups = explode(',', $formated);

        $thousands = count($groups);

        $parts = [];
        foreach ($groups as $step => $group) {
            $group_words = $this->groupToWords($group, $lang);
            if ($group_words) {
                if ($lang == 'af') $part = implode(' ' . $this->and_af['and'] . ' ', $group_words);
                if ($lang == 'en') $part = implode(' '/* . $this->and_en['and'] . ' '*/, $group_words);

                if ($lang == 'af') {
                    if (isset($this->thousands_af[$thousands - $step - 1])) $part .= ' ' . $this->thousands_af[$thousands - $step - 1];
                }
                if ($lang == 'en') {
                    if (isset($this->thousands_en[$thousands - $step - 1])) $part .= ' ' . $this->thousands_en[$thousands - $step - 1];
                }
                $parts[] = $part;
            }
        }

        if ($lang == 'af') return implode(' ' . $this->and_af['and'] . ' ', $parts);
        if ($lang == 'en') return implode(' ' . $this->and_en['and'] . ' ', $parts);
    }
}
