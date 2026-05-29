<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_loads()
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertSee('Kirim Pesan');
    }

    public function test_visitor_can_submit_contact_form()
    {
        $response = $this->post(route('contact'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Pertanyaan',
            'message' => 'Halo, saya ingin bertanya tentang produk.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Pertanyaan',
        ]);
    }

    public function test_contact_form_validates_required_fields()
    {
        $response = $this->post(route('contact'), []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_validates_email()
    {
        $response = $this->post(route('contact'), [
            'name' => 'John',
            'email' => 'not-an-email',
            'subject' => 'Test',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
