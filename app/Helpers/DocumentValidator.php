<?php

namespace App\Helpers;

class DocumentValidator
{
    /**
     * Valida CPF
     */
    public static function validateCPF(string $cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

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

    /**
     * Valida CNPJ
     */
    public static function validateCNPJ(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        
        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;

        if ($cnpj[12] != $digit1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;

        return $cnpj[13] == $digit2;
    }

    /**
     * Formata documento (CPF ou CNPJ)
     */
    public static function formatDocument(string $document, string $type): string
    {
        $document = preg_replace('/\D/', '', $document);
        
        if ($type === 'fisica' && strlen($document) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $document);
        }
        
        if ($type === 'juridica' && strlen($document) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $document);
        }
        
        return $document;
    }

    /**
     * Formata telefone
     */
    public static function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        
        if (strlen($phone) === 11) {
            // Celular: (00) 00000-0000
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        } elseif (strlen($phone) === 10) {
            // Fixo: (00) 0000-0000
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }

        return $phone;
    }

    /**
     * Formata CEP
     */
    public static function formatZipCode(string $zipCode): string
    {
        $zipCode = preg_replace('/\D/', '', $zipCode);
        
        if (strlen($zipCode) === 8) {
            return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $zipCode);
        }
        
        return $zipCode;
    }
} 