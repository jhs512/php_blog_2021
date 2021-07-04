<?php

namespace App\Service;

use App\Container\Container;

class MemberService
{
    use Container;

    public function getForPrintMemberByLoginIdAndLoginPw(string $loginId, string $loginPw): array|null
    {
        return $this->memberRepository()->getForPrintMemberByLoginIdAndLoginPw($loginId, $loginPw);
    }

    public function getForPrintMemberById(int $id): array|null
    {
        return $this->memberRepository()->getForPrintMemberById($id);
    }

    public function secession(int $id)
    {
        $this->memberRepository()->secession($id);
    }
}