<?php namespace App\Http\Controllers;

use App;
use Illuminate\Support\Collection;

class WelcomeController extends Controller {

    protected $array;
    protected $index;
    protected $eqArrays;

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index($arrayString = null, $strict = null)
	{
        if ( ! $arrayString)
            return view('welcome')->with('msg', 'Please provide a comma seperated list as the first url segment.');

        $this->determineEquilibrium($arrayString, $strict);

		return view('welcome', [
            'array' => $this->array->toArray(),
            'index' => $this->index,
            'eqArrays' => $this->eqArrays
        ]);
	}

    /**
     * Sets the protected properties.
     *
     * @param $arrayString
     * @param $strict
     */
    private function determineEquilibrium($arrayString, $strict)
    {
        $this->filterArrayString($arrayString, $strict)
                ->determineIndex()
                ->buildEqArrays();
    }

    /**
     * Build a Collection about the array string parameter
     * or throw a 400 error page.
     *
     * @param $arrayString
     * @param $strict
     * @return $this
     */
    private function filterArrayString($arrayString, $strict)
    {
        $array = new Collection(explode(',', $arrayString));

        $this->array = $array->filter(function($item) use($strict) {
            if (is_string($item) and $strict == 'strict') abort(400, 'Bad request.');

            elseif (is_numeric($item)) return $item;
        })->values();

        return $this;
    }

    /**
     * Determine the equilibrium index of the given array.
     *
     * @return $this
     */
    private function determineIndex()
    {
        $count = $this->array->count();
        $sum = $this->array->sum();
        $keys = $this->array->keys();

        $leftSide = $i = 0;
        while ($i < $count)
        {
            if ( $keys->has($i))
            {
                if ($i>0) $leftSide += $this->array->get($i - 1);

                if ($leftSide == $sum - $leftSide - $this->array->get($i))
                    $this->index = $i;
            }

            $i++;
        }

        return $this;
    }

    /**
     * Split the given array into 2 arrays at the equilibrium index
     *
     * @return $this
     */
    private function buildEqArrays()
    {
        $this->eqArrays = [
            $this->array->slice(0, $this->index)->toArray(),
            $this->array->slice($this->index + 1)->toArray()
        ];

        return $this;
    }

}
