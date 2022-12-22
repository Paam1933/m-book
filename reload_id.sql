SET @num := 0;
UPDATE `tb_books` SET `id` = @num := (@num+1);
ALTER TABLE `tb_books` AUTO_INCREMENT = 1;