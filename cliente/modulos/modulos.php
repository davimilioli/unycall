<?php
    function formatarNascimento($nascimento)
    {
        $nascimentoFormatado = date("d/m/Y", strtotime($nascimento));
        return $nascimentoFormatado;
    }

    function formatarCpf($cpf)
    {
        $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        return $cpfFormatado;
    }

    function formatarNumero($numero)
    {
        $numeroFormatado = '(' . substr($numero, 0, 3) . ') ' . substr($numero, 3, 2) . '-' . substr($numero, 5);
        return $numeroFormatado;
    }

    function formatarCep($cep)
    {
        $cepFormatado = substr($cep, 0, 5) . '-' . substr($cep, 5);
        return $cepFormatado;
    }
