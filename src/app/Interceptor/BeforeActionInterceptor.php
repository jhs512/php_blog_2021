<?php

namespace App\Interceptor;

use App\Container\Container;

class BeforeActionInterceptor extends Interceptor
{
    use Container;

    function run(string $action)
    {
        $_REQUEST['App__isLogined'] = false;
        $_REQUEST['App__loginedMemberId'] = 0;
        $_REQUEST['App__loginedMember'] = null;

        if (isset($_SESSION['loginedMemberId'])) {
            $_REQUEST['App__isLogined'] = true;
            $_REQUEST['App__loginedMemberId'] = intval($_SESSION['loginedMemberId']);
            $_REQUEST['App__loginedMember'] = $this->memberService()->getForPrintMemberById($_REQUEST['App__loginedMemberId']);
        }
    }
}