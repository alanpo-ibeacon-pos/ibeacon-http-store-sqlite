BEGIN TRANSACTION;
CREATE TABLE `traces` (
	`datetime`	TEXT,
	`selfMac`	INTEGER,
	`uuid`	BLOB,
	`major`	INTEGER,
	`minor`	INTEGER,
	`mac`	INTEGER,
	`txpower`	INTEGER,
	`rssi`	INTEGER
);
INSERT INTO `traces` VALUES ('2015-01-27 04:42:36',113780617483,X'E2C56DB5DFFB48D2B060D0F53F96E0',0,0,136780173000720,-58,-63);
INSERT INTO `traces` VALUES ('2015-01-27 04:42:36',113780617483,X'E2C56DB5DFFB48D2B060D0F53F96E0',0,0,136780173000720,-58,-60);
COMMIT;
