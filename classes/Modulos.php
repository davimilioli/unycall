<?php
class Modulos
{
    public function formatarNascimento($nascimento)
    {
        $nascimentoFormatado = date("d/m/Y", strtotime($nascimento));
        return $nascimentoFormatado;
    }

    public function formatarCpf($cpf)
    {
        $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        return $cpfFormatado;
    }

    public function formatarNumero($numero)
    {
        $ddi = '+' . substr($numero, 0, 2);
        $ddd = substr($numero, 2, 2);
        $numeroFormatado = "($ddi) $ddd-" . substr($numero, 4);
        return $numeroFormatado;
    }

    public function formatarCep($cep)
    {
        $cepFormatado = substr($cep, 0, 5) . '-' . substr($cep, 5);
        return $cepFormatado;
    }
}
