<?php
/**
 * This file is part of the Random.php package.
 *
 * Copyright (C) 2013 Shota Nozaki <emonkak@gmail.com>
 *
 * Licensed under the MIT License
 */

namespace Random\Engine;

class MT19937Engine extends AbstractEngine
{
    const N = 624;
    const M = 397;

    /**
     * @var integer
     */
    private $seed;

    /**
     * @var \SplFixedArray
     */
    private $state;

    /**
     * @var integer
     */
    private $left = 0;

    /**
     * @param integer|null Initial seed
     */
    public function __construct($seed = null)
    {
        $this->state = new \SplFixedArray(self::N + 1);

        if ($seed !== null) {
            $this->seed($seed);
        } else {
            $this->seed(time() * getmypid()) ^ (1000000.0 * lcg_value());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function max()
    {
        $x = 0x7fffffff;
        print __LINE__ . ' ' . $x . PHP_EOL;
        return 0x7fffffff;
    }

    /**
     * {@inheritdoc}
     */
    public function min()
    {
        $x = 0;
        print __LINE__ . ' ' . $x . PHP_EOL;
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if ($this->left === 0) {
            $this->nextSeed();
        }
        $x = $this->left;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $this->left--;

        $x = $this->left;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $s1 = $this->state->current();

        $x = $s1;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $s1 ^= ($s1 >> 11);

        $x = $s1;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $s1 ^= ($s1 <<  7) & 0x9d2c5680;

        $x = $s1;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $s1 ^= ($s1 << 15) & 0xefc60000;

        $x = $s1;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $this->state->next();

        $x = ($s1 ^ ($s1 >> 18)) >> 1;
        print __LINE__ . ' ' . $x . PHP_EOL;

        return ($s1 ^ ($s1 >> 18)) >> 1;
    }

    /**
     * {@inheritdoc}
     */
    public function seed($seed)
    {
        $x = $seed;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $this->state[0] = $seed & 0xffffffff;

        $x = $this->state[0];
        print __LINE__ . ' ' . $x . PHP_EOL;

        for ($i = 1; $i < self::N; $i++) {
            $x = $i;
            print __LINE__ . ' ' . $x . PHP_EOL;

            $r = $this->state[$i - 1];

            $x = $r;
            print __LINE__ . ' ' . $x . PHP_EOL;

            $this->state[$i] = (1812433253 * ($r ^ ($r >> 30)) + $i) & 0xffffffff;

            $x = $this->state[$i];
            print __LINE__ . ' ' . $x . PHP_EOL;
        }
    }

    /**
     * @return void
     */
    private function nextSeed()
    {
        for ($i = 0, $l = self::N - self::M; $i < $l; $i++) {
            $this->state[$i] = $this->twist(
                $this->state[$i + self::M],
                $this->state[$i],
                $this->state[$i + 1]
            );

            $x = $this->state[$i];
            print __LINE__ . ' ' . $x . PHP_EOL;
        }

        for ($l = self::N - 1; $i < $l; $i++) {
            $this->state[$i] = $this->twist(
                $this->state[$i + self::M - self::N],
                $this->state[$i],
                $this->state[$i + 1]
            );

            $x = $this->state[$i];
            print __LINE__ . ' ' . $x . PHP_EOL;
        }

        $this->state[$i] = $this->twist(
            $this->state[$i + self::M - self::N],
            $this->state[$i],
            $this->state[0]
        );

        $x = $this->state[$i];
        print __LINE__ . ' ' . $x . PHP_EOL;

        $this->left = self::N;

        $x = $this->left;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $this->state->rewind();
    }

    /**
     * @return integer
     */
    private function twist($m, $u, $v)
    {
        $x = ($u & 0x80000000);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ($v & 0x7FFFFFFF);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = (($u & 0x80000000) | ($v & 0x7FFFFFFF));
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ((($u & 0x80000000) | ($v & 0x7FFFFFFF)) >> 1);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ((($u & 0x80000000) | ($v & 0x7FFFFFFF)) >> 1);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ($u & 0x00000001);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ($u & 0x00000001);
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = -($u & 0x00000001) & 0x9908B0DF;
        print __LINE__ . ' ' . $x . PHP_EOL;

        $x = ($m ^ ((($u & 0x80000000) | ($v & 0x7FFFFFFF)) >> 1)
            ^ -($u & 0x00000001) & 0x9908B0DF);
        print __LINE__ . ' ' . $x . PHP_EOL;

        return ($m ^ ((($u & 0x80000000) | ($v & 0x7FFFFFFF)) >> 1)
                   ^ -($u & 0x00000001) & 0x9908B0DF);
    }
}
