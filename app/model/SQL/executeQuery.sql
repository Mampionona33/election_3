CREATE PROCEDURE executeQuery(IN query TEXT)
BEGIN
    SET @sql = query;
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END;