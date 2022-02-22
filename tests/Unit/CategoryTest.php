<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Traits\Uuid;
use Tests\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    private $category;

    private function setup(): void {
        parent::setup();
        $this->category = new Category();
    }

    public function testIfUseTraits()
    {
        Genre::create(['name' => 'test']);
        $traits = [SoftDeletes::class, Uuid::class];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'description', 'is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testCastsAttribute()
    {
        $casts = ['id' => 'string'];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach($dates as $date){
            $this->assertContains($date, $this->category->getDates());
        }
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->category->incrementing);
    }
}
