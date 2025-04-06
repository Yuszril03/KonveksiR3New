<?php

namespace App\Libraries;

class PDF
{
    function __construct()
    {
        include_once APPPATH . '/third_party/fpdf/fpdf.php';
    }
}
