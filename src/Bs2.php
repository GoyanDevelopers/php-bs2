<?php

namespace Goyan\Bs2;

class Bs2
{
    /*
     * Retorna uma nova instância de Banking.
     *
     * @return \Goyan\Bs2\Banking
     */
    public function banking()
    {
        return new Banking();
    }

    /*
     * Retorna uma nova instância de Pix.
     *
     * @return \Goyan\Bs2\Pix
     */
    public function pix()
    {
        return new Pix();
    }
}
