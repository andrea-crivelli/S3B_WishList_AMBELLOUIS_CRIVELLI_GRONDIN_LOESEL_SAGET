<?php

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
    /**
     * Get the name of the vues.
     *
     * @return string
     */
    public function name();

    /**
     * Add a piece of data to the vues.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null);

    /**
     * Get the array of vues data.
     *
     * @return array
     */
    public function getData();
}
