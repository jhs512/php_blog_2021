<?php

namespace App\Repository;

class MemberRepository
{
    public function getForPrintMemberByLoginIdAndLoginPw(string $loginId, string $loginPw): array|null
    {
        $sql = DB__secSql();
        $sql->add("SELECT *");
        $sql->add("FROM `member` AS M");
        $sql->add("WHERE M.loginId = ?", $loginId);
        $sql->add("AND M.loginPw = ?", $loginPw);
        $sql->add("AND M.delStatus = 0");

        return DB__getRow($sql);
    }

    public function getForPrintMemberById(int $id): array|null
    {
        $sql = DB__secSql();
        $sql->add("SELECT M.*");
        $sql->add("FROM `member` AS M");
        $sql->add("WHERE M.id = ?", $id);
        $sql->add("AND M.delStatus = 0");
        return DB__getRow($sql);
    }

    public function secession(int $id)
    {
        $sql = DB__secSql();
        $sql->add("UPDATE `member`");
        $sql->add("SET delStatus = 1");
        $sql->add(", delDate = NOW()");
        $sql->add("WHERE id = ?", $id);
        DB__update($sql);
    }
}