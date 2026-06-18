<?php

use PHPUnit\Framework\TestCase;
use App\Models\Articles;

class ArticlesTest extends TestCase
{
    public function testGetSuggestReturnsArray()
    {
        $this->assertIsArray(Articles::getSuggest());
    }

    public function testGetOneReturnsArray()
    {
        $this->assertIsArray(Articles::getOne(999999));
    }
}