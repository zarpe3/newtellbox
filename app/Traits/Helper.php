<?php

namespace App\Traits;

trait Helper
{
    private static function removeCharacters($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    private static function cpfValidator($cpf)
    {
        // Extract only the numbers
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        // Check if all digits were entered correctly
        if (strlen($cpf) != 11) {
            return false;
        }

        // Checks if a sequence of repeated digits was informed. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Do the calculation to validate the CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
