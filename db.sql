# DB 생성
DROP DATABASE IF EXISTS php_blog_2021;
CREATE DATABASE php_blog_2021;
USE php_blog_2021;

# 게시물 테이블 생성
CREATE TABLE article (
    id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    regDate DATETIME NOT NULL,
    updateDate DATETIME NOT NULL,
    title CHAR(100) NOT NULL,
    `body` TEXT NOT NULL
);

# 테스트 게시물 생성
INSERT INTO article 
SET regDate = NOW(),
updateDate = NOW(),
title = '제목1',
`body` = '내용1';

INSERT INTO article 
SET regDate = NOW(),
updateDate = NOW(),
title = '제목2',
`body` = '내용2';

INSERT INTO article 
SET regDate = NOW(),
updateDate = NOW(),
title = '제목3',
`body` = '내용3';

INSERT INTO article 
SET regDate = NOW(),
updateDate = NOW(),
title = '제목4',
`body` = '내용4';

# 회원 테이블 생성
CREATE TABLE `member` (
    id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    regDate DATETIME NOT NULL,
    updateDate DATETIME NOT NULL,
    loginId CHAR(20) NOT NULL,
    loginPw CHAR(100) NOT NULL,
    `name` CHAR(20) NOT NULL,
    nickname CHAR(20) NOT NULL,
    email CHAR(100) NOT NULL,
    cellphoneNo CHAR(20) NOT NULL
);

# 테스트 회원 생성
INSERT INTO `member`
SET regDate = NOW(),
updateDate = NOW(),
loginId = 'user1',
loginPw = 'user1',
`name` = '홍길동',
nickname = '강바람',
email = 'user1@test.com',
cellphoneNo = '01011111111';

INSERT INTO `member`
SET regDate = NOW(),
updateDate = NOW(),
loginId = 'user2',
loginPw = 'user2',
`name` = '홍길순',
nickname = '이또한',
email = 'user2@test.com',
cellphoneNo = '01022222222';

# 게시물 테이블에 작성자 정보 저장
ALTER TABLE article ADD COLUMN memberId INT(10) UNSIGNED NOT NULL AFTER updateDate;

# 기존 게시물을 특정 회원들과 연결, 랜덤으로
UPDATE article
SET memberId = id % 2 + 1
WHERE memberId = 0;

# 회원에 삭제여부 칼럼 추가
ALTER TABLE `member` ADD COLUMN delStatus TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER updateDate;
ALTER TABLE `member` ADD COLUMN delDate DATETIME AFTER delStatus;

TRUNCATE article;

INSERT INTO article 
SET regDate = NOW(),
updateDate = NOW(),
memberId = 1,
title = '토스트 UI 뷰어 사용법',
`body` = '
# 기초(큰 제목)
## 자바스크립트(작은 제목)
```javascript
let a = 10;
console.log(a + 10);
```
## HTML과 자바스크립트
```html
<div class="aritlce"></div>
<script>
let div = document.getElementsByClassName("article")[0];
</script>
```
## SQL
```sql
SELECT *
FROM article
```
## PHP
```php
<?php
$a = 10;
?>
```
## Kotlin
```kotlin
val a = 10
```
';

# 대용량 이미지도 저장가능하도록 수정
ALTER TABLE article MODIFY COLUMN `body` LONGTEXT NOT NULL;