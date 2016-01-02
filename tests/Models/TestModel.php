<?php namespace igaster\modelOptions\Tests\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TestModel extends Eloquent
{
	use \igaster\modelOptions\modelOptions;

    protected $table = 'testing';
	protected $validOptions = ['option1'];
}