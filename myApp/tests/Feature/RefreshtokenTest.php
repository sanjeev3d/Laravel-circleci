<?php

namespace Tests\UFeaturenit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefreshtokenTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testValidRefreshToken()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM3OWE3ZjYwOGViZmI3MzIxZDZkYjNhNjNhYjk0NTUxM2I4MTExMDExNWZhMjgzYjliNDY0YWMzYWFmZWJhMmRmOGMyZTY4NGViY2JhZWNmIn0.eyJhdWQiOiIyIiwianRpIjoiYzc5YTdmNjA4ZWJmYjczMjFkNmRiM2E2M2FiOTQ1NTEzYjgxMTEwMTE1ZmEyODNiOWI0NjRhYzNhYWZlYmEyZGY4YzJlNjg0ZWJjYmFlY2YiLCJpYXQiOjE1NjYzNjcwNDQsIm5iZiI6MTU2NjM2NzA0NCwiZXhwIjoxNTk3OTg5NDQ0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.J_XAnSL5Q-bcWWo9QqjKngQoy4CFK4zyIOs63VauLSy0Am2R76sE6N6xSGXA1L7kme0vVc_fPyd8zhOgSF5pYK7tjYeHqP9KFkqlQ8MxIP2lka8DAfyleF6yenFcim3k-6lXnFz8JTqekAMTt2lzXKeyyvz5HaI4HFnInlv9oTEcsgq4GjWcZGZzYzImPoZkMW4_qSs2-BryHG2NZmHiQg-u0TWO0YdqhK8BfvmES21L6CaKWe35CQMmw9vxJ26N1IcNPMDjfZVJ6fEi9ns6r2btzoiaEPUZO4CulSanILVaERChTkL7EREnH4rYXVNq3Ki8OR7sniekMIHdKTTagwAwRZujcW4HguqBbFbpwbECdoBr3uEiMFBOLp8Zx8tSTrOVSkeuKXwJvXp2TAhzQf0_1i5PSdJpOpfYmSE8ErKEw4_wceBsYqCdVhF_09H7hLt8KuvtphmuzRv0bdzciMjpPWOK1bLz-TeM1WNq2GA8xA8GKjOrWDIoL6ftQ3107TwHZw36-7qqc8cszq75DfiwOFQKeStxEC_CgoENJinAWw7TMNL9dqdGVIjPPb8zT-hwrGQp6WOKpDB6ElZqiVMgHmIm5OselKwtbK2WrLVKnCVXg26MpJLz7JUpVVqJToOeyhWelWzG2EDQesy6XpKXQS8DfCdtKdmH6REkh24",
            "Content-Type" => "application/json",
        ])
        ->json('POST', '/api/refreshToken', [
            "refresh_token" => "def50200302575c625093afe8b6a8324605f1999ec99e95e353a5c8004550624168d4b3d7ceb59112a8d0b70896c3db07cebdd6b1bd8dff4d6cb2f7111230941b93ae4f8b66805ef3c70c27c903164e4f3eba37db7ff1ff239c1338920514eeaa18846612f68ac6aea52c71f45cba306f08a9202d63fe09679359f41d38627cb4f8c256478d1484b5ea08baf74c0fd067028e2f87c6ea63347160841d67953bc9b20ed1805cab9216ffbe171ce54a5f9a25b01afd29e7d229a59c37a2bc68e5cb9ae9e262ad23225cbe4dc222a63da77e0666cdb6d908aeb64cdeb350afa397447d11bdd3dcb781cbb2cc2dd16f6fe7cd4c264b833b5634bb8c10afc3d56f281948eca64fe9e0671cc2dcd172915f9d66c1cb2e63687427100695d9fc4e37b3ef83246c59aaab67269f1a8064cd0acb35a6ced6aa77770e06eaf72abfa3ea6ff746c4c55b4c6480ba916dcf7ae21c938ebc7b3e065b21c1319ee39c84dadeb7c6a",           
        ]);        
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'success',
        ]);
    }
    
    public function testInValidRefreshToken()
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFhNDg3Nzc3Yzk1NTM4ZGFiNWQ4NjFhMWI1ZGJhMWUxNjg2ZmQxOTcwZjFlMzViNjFjOWM1N2JlMzRkMWE3NDBmZGUxYzEzNjJlODVjMDU2In0.eyJhdWQiOiIyIiwianRpIjoiMWE0ODc3NzdjOTU1MzhkYWI1ZDg2MWExYjVkYmExZTE2ODZmZDE5NzBmMWUzNWI2MWM5YzU3YmUzNGQxYTc0MGZkZTFjMTM2MmU4NWMwNTYiLCJpYXQiOjE1NjYzODEzMzEsIm5iZiI6MTU2NjM4MTMzMSwiZXhwIjoxNTk4MDAzNzMxLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.Uq10r6TFfgpBTWNQ3B1FfQMaIrqG-nV7Tk5KPfLekRpfZ-PPzHi0vk9qrlkD4LY1hGviD1gZ2rThgJztKE7GUJ2xjLzL6UnpjOj4zyJWAgnHglreMXZ1f3GB7fXD1_uEWcgxdzWrviPKam_9-Yp6VCdN-uYmGTTHR4XeAfbKYTZul9oorU3yEsULybHgeLhcg6fqK3YsfIX_ZF_-26lUKwv_dxZpYslEmSPhOPeb3d7a3fZ8vtOy-yuMid0HePYmd_FpcZx5N8TfF09FuNhRr2DtsiKKOj6FqTBvm6QbMgl8dUV25EP9xtJkfm9RexE_odpw3Ps2xgsKqwBs4rZZH7nVXhuJOTrP1XitHfWwcys5Y6u4jy6v52a_PayFlYAZ0Q6HjBVqcKiHth8MSYPz8v7L5_CyP9oUz-e2Lb5jbTAfMke-w4NqNywNvtnlVxYpBFvSMaeZAW32o3x-Ni71mkJjaGZVByP7C54TP7FOgzN2A1CbQLQp83j4jDDaAFiywr12yDfFY0hu7mzN_Is76-SwY6pCkYbZew0h6r4ODDIwT2nUUMp8zkvlXG65E3qkkYK7Q7hPOKvvyXd-vFX6mB9LMuZaEgeBi5mvoPEMU6n86UKHAW6afUgkyTKIx1L-iQY9ZmY6UIEic9zQe4PKVgBPVSZQKZnBn-iSIziM9ro",
            "Content-Type" => "application/json",
        ])
        ->json('POST', '/api/refreshToken', [
            "refresh_token" => "def50200302575c625093afe8b6a8324605f1999ec99e95e353a5c8004550624168d4b3d7ceb59112a8d0b70896c3db07cebdd6b1bd8dff4d6cb2f7111230941b93ae4f8b66805ef3c70c27c903164e4f3eba37db7ff1ff239c1338920514eeaa18846612f68ac6aea52c71f45cba306f08a9202d63fe09679359f41d38627cb4f8c256478d1484b5ea08baf74c0fd067028e2f87c6ea63347160841d67953bc9b20ed1805cab9216ffbe171ce54a5f9a25b01afd29e7d229a59c37a2bc68e5cb9ae9e262ad23225cbe4dc222a63da77e0666cdb6d908aeb64cdeb350afa397447d11bdd3dcb781cbb2cc2dd16f6fe7cd4c264b833b5634bb8c10afc3d56f281948eca64fe9e0671cc2dcd172915f9d66c1cb2e63687427100695d9fc4e37b3ef83246c59aaab67269f1a8064cd0acb35a6ced6aa77770e06eaf72abfa3ea6ff746c4c55b4c6480ba916dcf7ae21c938ebc7b3e065b21c1319ee39c84dadeb7c6a",           
        ]);         
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }
    
    public function testValidateRefreshToken() {
        $response = $this->withHeaders([
            "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkwZTZlZDBmZmU2NTRmN2Y5YjdhOGFiYTJjYjY1OWI4NmMxYWZiN2U3YTEwZTliY2MzNDI3ZDViMjQzNWE1OWNmNjZkOGNmZTU1YTYzZTkyIn0.eyJhdWQiOiIyIiwianRpIjoiOTBlNmVkMGZmZTY1NGY3ZjliN2E4YWJhMmNiNjU5Yjg2YzFhZmI3ZTdhMTBlOWJjYzM0MjdkNWIyNDM1YTU5Y2Y2NmQ4Y2ZlNTVhNjNlOTIiLCJpYXQiOjE1NjYzNjgwNzMsIm5iZiI6MTU2NjM2ODA3MywiZXhwIjoxNTk3OTkwNDczLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.S9ieVccKBEQZ5hTKZkVjxDmf75FvN5uTDfPLN0iF4yvWsbHtoUR3RUVxrB5ZIWvxI931VU0TK1k5JBYAGDDO93-rWHQqdE7I-OlXM5JqiDIexG_wVnewT6Q1D6B3L-GU-jAz-u2_PVPK3MINOs9C4kxubXUXcJoYgKhiMurDNgW-7S7QP9W8fqs2ucgIfRC_tsyBc8upillHDZ0t2p0phCmYG6nGyJyOMbIeGmcdpf-fBRWr153MltYjmd0w5KAHu3g5MaTCpgzg1aeCp82-G6BStiSaWF-GxVJqaBAO1MOZ2KkTmbUgpfUl3O2PjMYBc3zFNj5tz1PmfTi8nbjoKTAz2OvQLgxGZnk6iwf5z186ILLnAhy_hxpbz-W2FlDOvSSFQP6urykGtuYJjM6eDBgNbAQ-M-gR6ksxfqtrULeSEpOws3QPeNxfOlzZs6NGne_2lA1Hdh2shW3Y1N8FISz3q0l6mn2e9_MO5uLSTlgDP1Jywnh0FEY4HksQmA9-HxZrnvJZw4fzP4frkLaO-FwPntJiHTx5_ROpIYmFK-dIw5Vy7sL061l2XaIVmZ2-qOBdKZY5TOubMSwNtA1c_2MwHcUPXzpsBM4tUFKkyQ7oY1rpz9DqQd8f8mu57oN1pCAQg8EKB5BDY6dr1gXuGY_4U74UhuPJ0X1Tu9xF74o",
            "Content-Type" => "application/json",
        ])
        ->json('POST', '/api/refreshToken');         
       // $response->dumpHeaders();
        $response->dump();
        $response
        ->assertJson([
            'status' => 'error',
        ]);
    }
}
