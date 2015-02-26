<?php

class EquilibriumTest extends TestCase {

	/**
	 * Test if the paramaters passed.
	 *
	 * @test
	 */
	public function it_shows_a_message_if_no_parameters_were_passes()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());

        $this->assertViewHas('msg', 'Please provide a comma seperated list as the first url segment.');
	}

    /**
     * It determines the equilibrium index
     *
     * @test
     */
    public function it_determines_the_equilibrium_index_and_generates_the_array()
    {
        // First test
        $this->call('GET', '/1,2,7,3');

        $this->assertViewHas('index', 2);
        $this->assertViewHas('array', [1,2,7,3]);

        // Another array
        $this->call('GET', '/1,2,7,8,10');

        $this->assertViewHas('index', 3);
        $this->assertViewHas('array', [1,2,7,8,10]);
    }

    /**
     * It ignores the non-numeric array elements
     *
     * @test
     */
    public function it_ignores_the_non_numeric_array_elements()
    {
        $this->call('GET', '/apple,1,2,peach,7,3,melon');

        $this->assertViewHas('index', 2);
        $this->assertViewHas('array', [1,2,7,3]);
    }

    /**
     * It throws a 400 error page if the strict flag is used
     *
     * @test
     */
    public function it_throws_a_400_error_page_if_the_strict_flag_is_used()
    {
        $this->call('GET', '/1,2,7,3,apple,juice/strict');

        $this->assertResponseStatus(400);
    }

    /**
     * It ignores the second url segment if the value is not strict
     *
     * @test
     */
    public function it_ignores_the_second_url_segment_if_the_value_is_not_strict()
    {
        $this->call('GET', '/1,2,7,3,apple,juice/peach');

        $this->assertViewHas('index', 2);
        $this->assertViewHas('array', [1,2,7,3]);
    }

    /**
     * It shows a message if the array doesn't have equilibrium index
     *
     * @test
     */
    public function it_shows_a_message_if_the_array_does_not_have_equilibrium_index()
    {
        $response = $this->call('GET', '/1,2,7,23');

        $this->assertRegExp('/The array doesn\'t have any equilibrium index./', $response->getContent());
    }

}
