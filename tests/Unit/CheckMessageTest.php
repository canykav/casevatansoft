<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CheckMessageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_message_data_is_filled()
    {
        $message = [
            'title' => 'Test Title',
            'content' =>  'Test Content',
        ];
        if(in_array('title', $message) && !empty($message['title'])) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }

        if(in_array('content', $message) && !empty($message['content'])) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
    }
}
