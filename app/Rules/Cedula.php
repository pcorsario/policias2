<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cedula implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // fuerzo parametro de entrada a string
        $numero = (string)$value;

        try {
            $this->validarInicial($numero, '10');
            $this->validarCodigoProvincia(substr($numero, 0, 2));
            $this->validarTercerDigito($numero[2], 'cedula');
            $this->algoritmoModulo10(substr($numero, 0, 9), $numero[9]);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El número de cédula ingresado es incorrecto';
    }

    /**
     * Validaciones iniciales para CI y RUC.
     *
     * @param string $numero CI o RUC
     * @param int $caracteres Cantidad de caracteres requeridos
     *
     * @return bool
     * @throws exception Cuando valor esta vacio, cuando no es dígito y
     *                   cuando no tiene cantidad requerida de caracteres
     *
     */
    protected function validarInicial($numero, $caracteres)
    {
        if (empty($numero)) {
            throw new \Exception('Valor no puede estar vacio');
        }

        if (!ctype_digit($numero)) {
            throw new \Exception('Valor ingresado solo puede tener dígitos');
        }

        if (strlen($numero) != $caracteres) {
            throw new \Exception('Valor ingresado debe tener ' . $caracteres . ' caracteres');
        }

        return true;
    }

    /**
     * Validación de código de provincia (dos primeros dígitos de CI/RUC).
     *
     * @param string $numero Dos primeros dígitos de CI/RUC
     *
     * @return bool
     * @throws exception Cuando el código de provincia no esta entre 00 y 24
     *
     */
    protected function validarCodigoProvincia($numero)
    {
        if ($numero < 0 || $numero > 24) {
            throw new \Exception('Codigo de Provincia (dos primeros dígitos) no deben ser mayor a 24 ni menores a 0');
        }

        return true;
    }

    /**
     * Validación de tercer dígito.
     *
     * Permite validad el tercer dígito del documento. Dependiendo
     * del campo tipo (tipo de identificación) se realizan las validaciones.
     * Los posibles valores del campo tipo son: cedula, ruc_natural, ruc_privada
     *
     * Para Cédulas y RUC de personas naturales el terder dígito debe
     * estar entre 0 y 5 (0,1,2,3,4,5)
     *
     * Para RUC de sociedades privadas el terder dígito debe ser
     * igual a 9.
     *
     * Para RUC de sociedades públicas el terder dígito debe ser
     * igual a 6.
     *
     * @param string $numero tercer dígito de CI/RUC
     * @param string $tipo tipo de identificador
     *
     * @return bool
     * @throws exception Cuando el tercer digito no es válido. El mensaje
     *                   de error depende del tipo de Idenficiación.
     *
     */
    protected function validarTercerDigito($numero, $tipo)
    {
        switch ($tipo) {
            case 'cedula':
            case 'ruc_natural':
                if ($numero < 0 || $numero > 5) {
                    throw new \Exception('Tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas y RUC de persona natural');
                }
                break;
            case 'ruc_privada':
                if ($numero != 9) {
                    throw new \Exception('Tercer dígito debe ser igual a 9 para sociedades privadas');
                }
                break;

            case 'ruc_publica':
                if ($numero != 6) {
                    throw new \Exception('Tercer dígito debe ser igual a 6 para sociedades públicas');
                }
                break;
            default:
                throw new \Exception('Tipo de Identificacion no existe.');
                break;
        }

        return true;
    }

    protected function algoritmoModulo10($digitosIniciales, $digitoVerificador)
    {
        $arrayCoeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

        $digitoVerificador = (int)$digitoVerificador;
        $digitosIniciales = str_split($digitosIniciales);

        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);

            if ($valorPosicion >= 10) {
                $valorPosicion = str_split($valorPosicion);
                $valorPosicion = array_sum($valorPosicion);
                $valorPosicion = (int)$valorPosicion;
            }

            $total = $total + $valorPosicion;
        }

        $residuo = $total % 10;

        $resultado = ($residuo == 0) ? 0 : 10 - $residuo;

        if ($resultado != $digitoVerificador) {
            throw new \Exception('Dígitos iniciales no validan contra Dígito Idenficador');
        }

        return true;
    }

}
