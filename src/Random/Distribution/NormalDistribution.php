<?php
/**
 * This file is part of the Random.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Random\Distribution;

use Random\Engine\AbstractEngine;

class NormalDistribution extends AbstractDistribution
{
    /**
     * @var float
     */
    private $mean;

    /**
     * @var float
     */
    private $sigma;

    /**
     * @param float $mean
     * @param float $sigma
     */
    public function __construct($mean, $sigma)
    {
        assert($sigma >= 0);

        $this->mean = $mean;
        $this->sigma = $sigma;
    }

    /**
     * @return float
     */
    public function getMean()
    {
        return $this->mean;
    }

    /**
     * @return float
     */
    public function getSigma()
    {
        return $this->sigma;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(AbstractEngine $engine)
    {
        $r1 = $engine->nextFloat();
        $r2 = $engine->nextFloat();

        return $this->mean + $this->sigma
               * sqrt(-2 * log($r1)) * cos(2 * M_PI * $r2);
    }
}
