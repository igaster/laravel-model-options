<?php

use igaster\modelOptions\Tests\TestCase\TestCaseWithDatbase;

use igaster\modelOptions\Tests\Models\TestModel;

class ModelOptionsTest extends TestCaseWithDatbase
{
    // -----------------------------------------------
    //  Setup Database
    // -----------------------------------------------

    private $model;

    public function setUp()
    {
        parent::setUp();

        // -- Set  migrations
        $this->database->schema()->create('testing', function ($table) {
            $table->increments('id');
            $table->integer('testValue')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    public function tearDown()
    {
        $this->database->schema()->drop('testing');
    }

    // -----------------------------------------------

    public function getNewModel()
    {
        $model = TestModel::create();
        return $this->reloadModel($model);
    }

    public function reloadModel($model)
    {
        return TestModel::find($model->id);
    }

    // -----------------------------------------------


    public function testPropertyAccess()
    {
        $model = $this->getNewModel();

        $model->option1 = 10;
        $model->save();
        $model = $model->fresh();
        $this->assertEquals($model->option1, 10);
    }

    public function testArrayAccessSet()
    {
        $model = $this->getNewModel();
        $model['option1'] = 11;
        $model->save();
        $model->fresh();
        $this->assertEquals($model->option1, 11);
    }

    public function testArrayAccessGet()
    {
        $model = $this->getNewModel();
        $model->option1 = 14;
        $this->assertEquals($model['option1'], 14);
    }

    public function testOperatorIncrease()
    {
        $model = $this->getNewModel();
        $model->option1 = 12;
        $model->option1++;
        $model->save();
        $model->fresh();
        $this->assertEquals($model->option1, 13);
    }

    public function testInvalidProperty()
    {
        $model = $this->getNewModel();
        $this->expectException(\Illuminate\Database\QueryException::class);
        $model->option2 = 99;
        $model->save();
    }

    public function test_it_saves_options_in_database()
    {
        $model = $this->getNewModel();

        $model->option1 = 15;
        $model->save();
        $this->assertEquals($model->option1, 15);

        $model = $this->reloadModel($model);
        $this->assertEquals($model->option1, 15);
    }

    public function test_not_interfere_with_normal_properties()
    {
        $model = $this->getNewModel();

        $model->option1 = 16;
        $model->testValue = 17;

        $this->assertEquals(16, $model->option1);
        $this->assertEquals(17, $model->testValue);

        $model->save();
        $model = $this->reloadModel($model);

        $this->assertEquals(16, $model->option1);
        $this->assertEquals(17, $model->testValue);
    }

    public function test_not_interfere_with_array_access_normal_properties()
    {
        $model = $this->getNewModel();

        $model['option1'] = 16;
        $model['testValue'] = 17;

        $this->assertEquals(16, $model['option1']);
        $this->assertEquals(17, $model['testValue']);

        $model->save();
        $model = $this->reloadModel($model);

        $this->assertEquals(16, $model['option1']);
        $this->assertEquals(17, $model['testValue']);

        $this->assertEquals(16, $model->option1);
        $this->assertEquals(17, $model->testValue);
    }

}
